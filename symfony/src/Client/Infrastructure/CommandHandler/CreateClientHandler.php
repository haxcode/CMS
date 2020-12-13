<?php

namespace App\Client\Infrastructure\CommandHandler;

use App\Client\Application\Command\CreateClient;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Client\Infrastructure\Repository\ClientRepository;
use App\Client\Domain\Entity\Client;
use App\Common\UUID;

final class CreateClientHandler implements MessageHandlerInterface {

    /**
     * @var ClientRepository
     */
    private ClientRepository $repository;

    public function __construct(ClientRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @param CreateClient $command
     */
    public function __invoke(CreateClient $command) {

        $client = new Client(UUID::random(), $command->getNip(), $command->getName(), $command->getShortName(), $command->isSla());
        $this->repository->create($client);
        
    }

}
