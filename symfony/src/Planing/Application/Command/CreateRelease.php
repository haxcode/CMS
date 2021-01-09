<?php

namespace App\Planing\Application\Command;

use App\Common\CQRS\Command;
use Symfony\Component\Uid\Uuid;
use App\Planing\Domain\ValueObject\VersionType;

class CreateRelease implements Command {

    /**
     * @var Uuid
     */
    private Uuid        $uuid;
    private VersionType $versionType;
    private string      $codeName;

    public function __construct(Uuid $uuid, VersionType $versionType, string $codeName) {
        $this->uuid = $uuid;
        $this->versionType = $versionType;
        $this->codeName = $codeName;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid {
        return $this->uuid;
    }

    /**
     * @return VersionType
     */
    public function getVersionType(): VersionType {
        return $this->versionType;
    }

    /**
     * @return string
     */
    public function getCodeName(): string {
        return $this->codeName;
    }

}