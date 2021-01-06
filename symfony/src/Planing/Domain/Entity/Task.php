<?php

namespace App\Planing\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use App\Planing\Infrastructure\Repository\TaskRepository;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task {

    private Uuid $id;
    private string $description;
    private ?int $assigned;
    private string $state;
    private ?string $clientID;
    private ?string $note;
    private ?string $relatedTo;
    private ?string $estimatedTime;
    private ?string $spendTime;

    public function __construct(Uuid $id, string $description, string $state, ?int $assigned, ?string $clientID) {

        $this->id = $id;
        $this->description = $description;
        $this->state = $state;
        $this->assigned = $assigned;
        $this->clientID = $clientID;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return int|null
     */
    public function getAssigned(): ?int {
        return $this->assigned;
    }

    /**
     * @return string
     */
    public function getState(): string {
        return $this->state;
    }

    /**
     * @return string|null
     */
    public function getClientID(): ?string {
        return $this->clientID;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string {
        return $this->note;
    }

    /**
     * @param string|null $note
     */
    public function setNote(?string $note): void {
        $this->note = $note;
    }

    /**
     * @return string|null
     */
    public function getRelatedTo(): ?string {
        return $this->relatedTo;
    }

    /**
     * @param string|null $relatedTo
     */
    public function setRelatedTo(?string $relatedTo): void {
        $this->relatedTo = $relatedTo;
    }

    /**
     * @return string|null
     */
    public function getEstimatedTime(): ?string {
        return $this->estimatedTime;
    }

    /**
     * @param string|null $estimatedTime
     */
    public function setEstimatedTime(?string $estimatedTime): void {
        $this->estimatedTime = $estimatedTime;
    }

    /**
     * @return string|null
     */
    public function getSpendTime(): ?string {
        return $this->spendTime;
    }

    /**
     * @param string|null $spendTime
     */
    public function setSpendTime(?string $spendTime): void {
        $this->spendTime = $spendTime;
    }

}