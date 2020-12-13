<?php

namespace App\Client\Infrastructure\CommandHandler;

use App\Client\Application\Command\CreateClient;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Client\Infrastructure\Repository\ClientRepository;
use App\Client\Domain\Entity\Client;
use App\Common\UUID;
use App\Client\Domain\Exception\ClientWithThisNIPAlreadyExist;

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

        if ($this->repository->findByNIP($command->getNip()) !== NULL) {
            throw new ClientWithThisNIPAlreadyExist();
        }

        $client = new Client($command->getId(), $command->getNip(), $command->getName(), $command->getShortName(), $command->isSla());

        $this->repository->create($client);

    }

}
