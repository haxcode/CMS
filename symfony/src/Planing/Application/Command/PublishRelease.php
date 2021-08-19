<?php

namespace App\Planing\Application\Command;

use App\Common\CQRS\Command;
use Symfony\Component\Uid\Uuid;

class PublishRelease implements Command {

    /**
     * @var Uuid
     */
    private Uuid $uuid;
    private      $user;

    /**
     * PublishRelease constructor.
     *
     * @param Uuid $uuid
     * @param      $user
     */
    public function __construct(Uuid $uuid, $user) {
        $this->uuid = $uuid;
        $this->user = $user;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid {
        return $this->uuid;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

}