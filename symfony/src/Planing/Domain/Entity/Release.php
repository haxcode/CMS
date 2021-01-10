<?php

namespace App\Planing\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use DateTime;
use App\Planing\Domain\Exception\DomainPlaningLogicException;
use App\Planing\Infrastructure\Repository\ReleaseRepository;

/**
 * @ORM\Entity(repositoryClass=ReleaseRepository::class)
 */
class Release {

    /**
     * @ORM\Column(type="uuid", name="release_id")
     * @ORM\Id
     */
    private Uuid $uuid;
    /**
     * @ORM\Column(type="string")
     */
    private string $version;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private ?string $codename;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $planedRelease;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private ?string $releaseNote;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $released = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $releaseDate;

    public function __construct(Uuid $uuid, string $version, string $codename, DateTime $planedRelease) {
        $this->uuid = $uuid;
        $this->version = $version;
        $this->codename = $codename;
        $this->planedRelease = $planedRelease;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getVersion(): string {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getCodename(): string {
        return $this->codename;
    }

    /**
     * @return DateTime
     */
    public function getPlanedRelease(): DateTime {
        return $this->planedRelease;
    }

    /**
     * @return string
     */
    public function getReleaseNote(): string {
        return $this->releaseNote;
    }

    /**
     * @param string $releaseNote
     */
    public function setReleaseNote(string $releaseNote): void {
        $this->releaseNote = $releaseNote;
    }

    public function release(): void {
        if (!$this->released && $this->getReleaseNote()) {
            throw new DomainPlaningLogicException('Can not release version without release-note. Please add release-note.');
        }
        $this->releaseDate = new DateTime();
        $this->released = true;
    }

    /**
     * @return bool
     */
    public function isReleased(): bool {
        return $this->released;
    }

    /**
     * @return DateTime|null
     */
    public function getReleaseDate(): ?DateTime {
        return $this->releaseDate;
    }

    /**
     * @param string|null $codename
     */
    public function setCodename(?string $codename): void {
        $this->codename = $codename;
    }

    /**
     * @param DateTime|null $planedRelease
     */
    public function setPlanedRelease(?DateTime $planedRelease): void {
        $this->planedRelease = $planedRelease;
    }



    
}