<?php

namespace App\Dictionary\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Dictionary\Repository\ADRRepository;
use Symfony\Component\Uid\Uuid;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=ADRRepository::class)
 */
class ArchitectureDecisionRecord {

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid",name="adr_uuid", unique=true)
     */
    private Uuid $id;

    /**
     * @ORM\Column(type="text")
     */
    private string $title;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private ?string $result;

    /**
     * @ORM\Column(type="text")
     */
    private DateTime $addDate;

    /**
     * @ORM\Column(type="uuid",name="change_uuid")
     */
    private ?Uuid $change;

    public function __construct(Uuid $id, string $title = '') {
        $this->id = $id;
        $this->title = $title;
        $this->addDate = new DateTime();
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getResult(): string {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult(string $result): void {
        $this->result = $result;
    }

    /**
     * @return DateTime
     */
    public function getAddDate(): DateTime {
        return $this->addDate;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid {
        return $this->id;
    }

    /**
     * @return Uuid|null
     */
    public function getChange(): ?Uuid {
        return $this->change;
    }

    /**
     * @param Uuid|null $change
     */
    public function setChange(?Uuid $change): void {
        $this->change = $change;
    }

}