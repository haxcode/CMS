<?php

namespace App\Helpdesk\Infrastructure\CommandHandler;

use App\Helpdesk\Infrastructure\Repository\IssueRepository;
use App\Client\Infrastructure\Repository\ClientRepository;
use App\Common\Event\EventBus;
use App\Common\CQRS\CommandHandler;
use App\Helpdesk\Application\Command\UpdateIssue;
use App\Client\Infrastructure\Repository\ClientNotFoundException;
use Symfony\Component\Uid\Uuid;
use App\Common\Exception\NotFoundException;
use App\Dictionary\Repository\ComponentRepository;
use App\Helpdesk\Domain\ValueObject\Importance;
use App\Common\Exception\NotSupportedType;
use App\User\Security\AccessRoleHelper;
use App\User\Entity\ValueObject\Role;
use App\Common\Exception\Access\ObjectAccessException;
use App\Helpdesk\Domain\Entity\Issue;

/**
 * Class UpdateIssueHandler
 *
 * @package          App\Helpdesk\Infrastructure\CommandHandler
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class UpdateIssueHandler implements CommandHandler {

    /**
     * @var IssueRepository
     */
    private IssueRepository $repository;
    /**
     * @var ClientRepository
     */
    private ClientRepository $clientRepository;
    /**
     * @var EventBus
     */
    private EventBus $eventBus;
    /**
     * @var ComponentRepository
     */
    private ComponentRepository $componentRepository;

    public function __construct(IssueRepository $repository, ClientRepository $clientRepository, ComponentRepository $componentRepository, EventBus $eventBus) {
        $this->repository = $repository;
        $this->clientRepository = $clientRepository;
        $this->eventBus = $eventBus;
        $this->componentRepository = $componentRepository;
    }

    /**
     * @param UpdateIssue $cm
     *
     * @throws ClientNotFoundException
     * @throws NotFoundException
     * @throws NotSupportedType
     */
    public function __invoke(UpdateIssue $cm): void {

        $issue = $this->repository->find(new Uuid($cm->getData()['issue_id']));
        if (!$issue) {
            throw new NotFoundException('Issue with this uuid was not found');
        }

        if (($issue->getAuthor() != $cm->getModifier()->getId()) && !AccessRoleHelper::hasRole($cm->getModifier(), Role::ADMIN)) {
            throw new ObjectAccessException(Issue::class, 'Can not modify this issue. Access deny.');
        }

        if ($cm->isChanged('client_id')) {
            $client = $this->clientRepository->getByUuid(new Uuid($cm->getData()['client_id']));
            $issue->setClient($client);
        }

        if ($cm->isChanged('title')) {
            $issue->setTitle($cm->getData()['title']);
        }

        if ($cm->isChanged('description')) {
            $issue->setDescription($cm->getData()['description']);
        }

        if ($cm->isChanged('component_uuid')) {
            $component = $this->componentRepository->find($cm->getData()['component_uuid']);
            if (!$component) {
                throw new NotFoundException('Component with this uuid is not exist');
            }
            $issue->setComponent($component->getId());
        }

        if ($cm->isChanged('importance')) {
            $issue->setImportance(new Importance($cm->getData()['importance']));
        }

        if ($cm->isChanged('is_confidential')) {
            $issue->setConfidential($cm->getData()['is_confidential']);
        }
        $issue->setModifier($cm->getModifier()->getId());
        $this->repository->update($issue);

    }

}
