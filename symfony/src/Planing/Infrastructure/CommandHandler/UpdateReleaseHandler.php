<?php

namespace App\Planing\Infrastructure\CommandHandler;

use App\Common\Event\EventBus;
use App\Common\CQRS\CommandHandler;
use Symfony\Component\Uid\Uuid;
use App\Common\Exception\NotFoundException;
use App\Planing\Infrastructure\Repository\ReleaseRepository;
use App\Planing\Application\Command\UpdateRelease;
use DateTime;

/**
 * Class UpdateReleaseHandler
 *
 * @package          App\Planing\Infrastructure\CommandHandler
 * @createDate       2021-01-10
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class UpdateReleaseHandler implements CommandHandler {

    /**
     * @var ReleaseRepository
     */
    private ReleaseRepository $repository;
    /**
     * @var EventBus
     */
    private EventBus $eventBus;

    /**
     * UpdateReleaseHandler constructor.
     *
     * @param ReleaseRepository $repository
     * @param EventBus          $eventBus
     */
    public function __construct(ReleaseRepository $repository, EventBus $eventBus) {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param UpdateRelease $c
     *
     * @throws NotFoundException
     * @throws \Exception
     */
    public function __invoke(UpdateRelease $c): void {

        $release = $this->repository->find(new Uuid($c->getData()['release_id']));
        if (!$release) {
            throw new NotFoundException('Release with this uuid was not found.');
        }

        if ($c->isChanged('codename')) {
            $release->setCodename($c->getData()['codename']);
        }

        if ($c->isChanged('planed_release')) {
            $release->setPlanedRelease(new DateTime($c->getData()['planed_release']));
        }

        if ($c->isChanged('release_note')) {
            $release->setReleaseNote($c->getData()['release_note']);
        }

        $this->repository->update($release);

    }

}
