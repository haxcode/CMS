<?php

namespace App\Planing\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use App\Planing\Infrastructure\Repository\TaskRepository;
use App\Planing\Domain\ValueObject\Status;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task {

    /**
     * @ORM\Column(type="uuid", name="task_id")
     * @ORM\Id
     */
    private Uuid $id;
    /**
     * @ORM\Column(type="string")
     */
    private string $description;
    /**
     * @ORM\Column(type="bigint", nullable=TRUE)
     */
    private ?int $assigned;
    /**
     * @ORM\Column(type="string")
     */
    private string $state;
    /**
     * @ORM\Column(type="string", nullable=TRUE)
     */
    private ?string $clientID;
    /**
     * @ORM\Column(type="string", nullable=TRUE)
     */
    private ?string $note;
    /**
     * @ORM\Column(type="string", nullable=TRUE)
     */
    private ?string $relatedTo;
    /**
     * @ORM\Column(type="string", nullable=TRUE)
     */
    private ?string $estimatedTime;
    /**
     * @ORM\Column(type="string", nullable=TRUE)
     */
    private ?string $spendTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $addDate;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private DateTime $lastModifyDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $doneDate;
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $done = false;

    /**
     * @ORM\Column(type="bigint")
     */
    private int $author;

    /**
     * @ORM\Column(type="bigint",nullable=true)
     */
    private ?int $lastModifier;

    /**
     * @var int
     */
    private int $modifier;

    /**
     * Task constructor.
     *
     * @param Uuid        $id
     * @param string      $description
     * @param Status      $state
     * @param int         $modifier
     * @param int|null    $assigned
     * @param string|null $clientID
     */
    public function __construct(Uuid $id, string $description, Status $state, int $modifier, ?int $assigned, ?string $clientID) {

        $this->id = $id;
        $this->description = $description;
        $this->state = $state;
        $this->assigned = $assigned;
        $this->clientID = $clientID;
        $this->modifier = $modifier;
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

    public function stampModified(): void {
        $this->lastModifyDate = new DateTime();
        $this->lastModifier = $this->modifier;
    }

    public function stampCreate(): void {
        $this->addDate = new DateTime();
        $this->author = $this->modifier;
    }

    public function markAsDone(): void {
        if ($this->done == true) {
            return;
        }
        $this->done = true;
        $this->state = Status::DONE;
        $this->doneDate = new DateTime();
    }

}