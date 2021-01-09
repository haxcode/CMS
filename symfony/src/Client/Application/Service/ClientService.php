<?php

namespace App\Client\Application\Service;

use App\Common\Service\TServiceParameterValidator;
use Symfony\Component\Uid\Uuid;
use App\Client\Application\Command\CreateClient;
use App\Common\CQRS\CommandBus;

class ClientService {

    use TServiceParameterValidator;

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus) {
        $this->serviceName = 'Client';
        $this->commandBus = $commandBus;
    }

    public function createClient(array $data): Uuid {
        $this->validate($data, [
            'nip'        => 'required|text',
            'name'       => 'required|text',
            'short_name' => 'required|text',
            'sla'        => 'bool',
        ]);

        $sla = $data['sla'] ?? FALSE;

        $createClient = new CreateClient($data['nip'], $data['name'], $data['short_name'], $sla);

        $this->commandBus->dispatch($createClient);
        return $createClient->getId();
    }

}