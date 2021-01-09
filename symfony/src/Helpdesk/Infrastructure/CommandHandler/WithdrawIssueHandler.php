<?php

namespace App\Helpdesk\Infrastructure\CommandHandler;

use App\Common\CQRS\CommandHandler;
use App\Helpdesk\Infrastructure\Repository\IssueRepository;
use App\Common\Event\EventBus;
use App\Helpdesk\Application\Command\MarkIssueAsSolved;
use App\Common\Exception\NotFoundException;
use App\Helpdesk\Domain\Event\IssueWasSolved;
use App\User\Security\AccessRoleHelper;
use App\User\Entity\ValueObject\Role;
use App\Common\Exception\Access\ObjectAccessException;
use App\Helpdesk\Domain\Entity\Issue;
use App\Helpdesk\Domain\Event\IssueWasWithdraw;
use App\Helpdesk\Application\Command\WithdrawIssue;

/**
 * Class MarkIssueAsSolvedHandler
 *
 * @package          App\Helpdesk\Infrastructure\CommandHandler
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class WithdrawIssueHandler implements CommandHandler {

    /**
     * @var IssueRepository
     */
    private IssueRepository $repository;
    /**
     * @var EventBus
     */
    private EventBus $eventBus;

    /**
     * WithdrawIssueHandler constructor.
     *
     * @param IssueRepository $repository
     * @param EventBus        $eventBus
     */
    public function __construct(IssueRepository $repository, EventBus $eventBus) {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param WithdrawIssue $cm
     *
     * @throws NotFoundException
     * @throws ObjectAccessException
     */
    public function __invoke(WithdrawIssue $cm): void {
        $issue = $this->repository->find($cm->getUuid());
        if (!$issue) {
            throw new NotFoundException('Issue with this uuid not found');
        }

        if (!AccessRoleHelper::hasRole($cm->getUser(), Role::ADMIN)) {
            throw new ObjectAccessException(Issue::class, 'Can not withdraw issue because you are not administrator');
        }

        if ($issue->isWithdrawn()) {
            return;
        }
        $issue->setModifier($cm->getUser()->getId());
        $issue->withdraw();
        $this->repository->update($issue);

        $this->eventBus->raise(new IssueWasWithdraw($issue));

    }

}
