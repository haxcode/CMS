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

/**
 * Class MarkIssueAsSolvedHandler
 *
 * @package          App\Helpdesk\Infrastructure\CommandHandler
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class MarkIssueAsSolvedHandler implements CommandHandler {

    /**
     * @var IssueRepository
     */
    private IssueRepository $repository;
    /**
     * @var EventBus
     */
    private EventBus $eventBus;

    public function __construct(IssueRepository $repository, EventBus $eventBus) {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param MarkIssueAsSolved $cm
     */
    public function __invoke(MarkIssueAsSolved $cm): void {
        $issue = $this->repository->find($cm->getUuid());
        if (!$issue) {
            throw new NotFoundException('Issue with this uuid not found');
        }

        if (!AccessRoleHelper::hasRole($cm->getUser(), Role::ADMIN) && ($cm->getUser()->getId() != $issue->getAuthor())) {
            throw new ObjectAccessException(Issue::class, 'Can not mark as solved issue because you are not author of this issue');
        }

        if ($issue->isSolved()) {
            return;
        }
        $issue->setModifier($cm->getUser()->getId());
        $issue->markAsSolved();
        $this->repository->update($issue);

        $this->eventBus->raise(new IssueWasSolved($issue));

    }

}
