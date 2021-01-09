<?php

namespace App\Planing\Infrastructure\CommandHandler;

use App\Common\CQRS\CommandHandler;
use App\Planing\Infrastructure\Repository\ReleaseRepository;
use App\Common\Event\EventBus;
use App\Planing\Application\Command\CreateRelease;
use App\Planing\Domain\Entity\Release;
use App\Planing\Domain\ValueObject\Version;

/**
 * Class CreateReleaseHandler
 *
 * @package          App\Planing\Infrastructure\CommandHandler
 * @createDate       2021-01-10
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class CreateReleaseHandler implements CommandHandler {

    /**
     * @var ReleaseRepository
     */
    private ReleaseRepository $repository;
    /**
     * @var EventBus
     */
    private EventBus $eventBus;

    /**
     * CreateReleaseHandler constructor.
     *
     * @param ReleaseRepository $repository
     * @param EventBus          $eventBus
     */
    public function __construct(ReleaseRepository $repository, EventBus $eventBus) {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param CreateRelease $cm
     */
    public function __invoke(CreateRelease $cm): void {
        $data = $this->repository->findLastReleased($cm->getVersionType());
        if (!$data) {
            $version = new Version();
        }
        $this->repository->create(new Release($cm->getUuid(), $version->getNextVersion($cm->getVersionType()), $cm->getCodeName(), $cm->getPlanedRelease()));

    }

}
