<?php

namespace App\Planing\Infrastructure\CommandHandler;

use App\Common\Event\EventBus;
use App\Common\CQRS\CommandHandler;
use App\Common\Exception\NotFoundException;
use App\Planing\Infrastructure\Repository\ReleaseRepository;
use App\Planing\Application\Command\PublishRelease;

/**
 * Class PublishReleaseHandler
 *
 * @package          App\Planing\Infrastructure\CommandHandler
 * @createDate       2021-01-10
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class PublishReleaseHandler implements CommandHandler {

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
     * @param PublishRelease $c
     *
     * @throws NotFoundException
     */
    public function __invoke(PublishRelease $c): void {

        $release = $this->repository->find($c->getUuid());
        if (!$release) {
            throw new NotFoundException('Release with this uuid was not found.');
        }

        $release->release();
        $this->repository->update($release);

    }

}
