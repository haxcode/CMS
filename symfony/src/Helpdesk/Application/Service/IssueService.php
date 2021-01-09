<?php

namespace App\Helpdesk\Application\Service;

use App\Common\CQRS\QueryBus;
use App\Common\CQRS\CommandBus;
use App\Common\Service\TServiceParameterValidator;
use Symfony\Component\Uid\Uuid;
use App\Helpdesk\Domain\ValueObject\Importance;
use App\Helpdesk\Application\Command\CreateIssue;
use App\Helpdesk\Application\Command\MarkIssueAsSolved;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Helpdesk\Application\Command\WithdrawIssue;
use App\Helpdesk\Application\Command\UpdateIssue;
use App\Common\Exception\Services\ServiceTypeParameterException;
use App\Common\Exception\Services\ServiceParameterRequiredException;
use App\Common\Exception\Services\NotSupportedServiceParameterException;
use App\Common\Exception\NotSupportedType;

class IssueService {

    use TServiceParameterValidator;

    private QueryBus   $queryBus;
    private CommandBus $commandBus;

    /**
     * IssueService constructor.
     *
     * @param QueryBus   $queryBus
     * @param CommandBus $commandBus
     */
    public function __construct(QueryBus $queryBus, CommandBus $commandBus) {

        $this->serviceName = 'Issue';
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * @param array $data
     *
     * @return Uuid
     * @throws NotSupportedType
     * @throws NotSupportedServiceParameterException
     * @throws ServiceParameterRequiredException
     * @throws ServiceTypeParameterException
     */
    public function creatIssue(array $data): Uuid {

        $this->validate($data, [
            'title'        => 'required|text',
            'description'  => 'required|text',
            'client'       => 'required|uuid',
            'component'    => 'required|uuid',
            'importance'   => 'text',
            'confidential' => 'bool',
            'author'       => 'int',
        ]);

        $importance = $data['importance'] ?? Importance::NORMALLY;

        $confidential = $data['confidential'] ?? FALSE;

        $id = Uuid::v4();
        $command = new CreateIssue($id, $data['title'], $data['description'], new Importance($importance), (bool)$confidential, $data['author'], Uuid::fromString($data['client']), Uuid::fromString($data['component']));
        $this->commandBus->dispatch($command);

        return $id;

    }

    /**
     * @param string        $uuid
     * @param UserInterface $user
     *
     * @return bool
     */
    public function solveIssue(string $uuid, UserInterface $user): bool {
        $uuid = new Uuid($uuid);
        $command = new MarkIssueAsSolved($uuid, $user);

        $this->commandBus->dispatch($command);

        return true;
    }

    /**
     * @param string        $uuid
     * @param UserInterface $user
     *
     * @return bool
     */
    public function withdrawIssue(string $uuid, UserInterface $user): bool {

        $uuid = new Uuid($uuid);
        $command = new WithdrawIssue($uuid, $user);

        $this->commandBus->dispatch($command);

        return true;
    }

    /**
     * @param array $data
     *
     * @throws NotSupportedServiceParameterException
     * @throws ServiceParameterRequiredException
     * @throws ServiceTypeParameterException
     */
    public function updateIssue(array $data, UserInterface $user): void {

        $this->validate($data, [
            'issue_id'        => 'required|uuid',
            'title'           => 'text',
            'description'     => 'text',
            'client_id'       => 'uuid',
            'component_uuid'  => 'uuid',
            'importance'      => 'text',
            'is_confidential' => 'bool',
        ]);

        $command = new UpdateIssue($data, $user);
        $this->commandBus->dispatch($command);

    }

}