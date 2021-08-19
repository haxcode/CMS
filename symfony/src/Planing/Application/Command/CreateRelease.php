<?php

namespace App\Planing\Application\Command;

use App\Common\CQRS\Command;
use Symfony\Component\Uid\Uuid;
use App\Planing\Domain\ValueObject\VersionType;
use DateTime;

class CreateRelease implements Command {

    /**
     * @var Uuid
     */
    private Uuid        $uuid;
    private VersionType $versionType;
    private string      $codeName;
    private ?DateTime   $planedRelease;

    /**
     * CreateRelease constructor.
     *
     * @param Uuid          $uuid
     * @param VersionType   $versionType
     * @param string        $codeName
     * @param DateTime|null $planedRelease
     */
    public function __construct(Uuid $uuid, VersionType $versionType, string $codeName, ?DateTime $planedRelease) {
        $this->uuid = $uuid;
        $this->versionType = $versionType;
        $this->codeName = $codeName;
        $this->planedRelease = $planedRelease;
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

    /**
     * @return DateTime|null
     */
    public function getPlanedRelease(): ?DateTime {
        return $this->planedRelease;
    }

}