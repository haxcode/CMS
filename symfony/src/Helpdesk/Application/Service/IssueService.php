<?php

namespace App\Helpdesk\Application\Service;

use App\Common\CQRS\QueryBus;
use App\Common\CQRS\CommandBus;
use App\Common\Service\TServiceParameterValidator;
use Symfony\Component\Uid\Uuid;
use App\Helpdesk\Domain\ValueObject\Importance;
use App\Helpdesk\Application\Command\CreateIssue;

class IssueService {

    use TServiceParameterValidator;

    private QueryBus   $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus) {

        $this->serviceName = 'Issue';
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

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

}