<?php

namespace App\Dictionary\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Dictionary\Repository\ChangeRepository;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ChangeRepository::class)
 */
class Change {

    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="uuid", unique=true)
     */
    private Uuid $id;

    /**
     * @ORM\Column(name="excerpt")
     */
    private string $excerpt;
    /**
     * @ORM\Column(name="description")
     */
    private string $description;

    /**
     * @ORM\Column(name="release",nullable=TRUE)
     */
    private string $release;

    /**
     * @ORM\Column(name="released")
     */
    private bool $released;
    /**
     * @ORM\Column(type="uuid")
     */
    private ?Uuid $componentUuid;
    /**
     * @ORM\Column(type"uuid")
     */
    private ?Uuid $issueUuid;

    /**
     * Change constructor.
     *
     * @param Uuid   $id
     * @param string $excerpt
     * @param string $description
     */
    public function __construct(Uuid $id, string $excerpt, string $description) {
        $this->id = $id;
        $this->excerpt = $excerpt;
        $this->description = $description;
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
    public function getExcerpt(): string {
        return $this->excerpt;
    }

    public function setExcerpt(string $excerpt): void {
        $this->excerpt = $excerpt;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getRelease(): string {
        return $this->release;
    }

    /**
     * @return bool
     */
    public function isReleased(): bool {
        return $this->released;
    }

    /**
     * @return Uuid|null
     */
    public function getComponentUuid(): ?Uuid {
        return $this->componentUuid;
    }

    /**
     * @param Uuid|null $componentUuid
     */
    public function setComponentUuid(?Uuid $componentUuid): void {
        $this->componentUuid = $componentUuid;
    }

    /**
     * @return Uuid|null
     */
    public function getIssueUuid(): ?Uuid {
        return $this->issueUuid;
    }

    /**
     * @param Uuid|null $issueUuid
     */
    public function setIssueUuid(?Uuid $issueUuid): void {
        $this->issueUuid = $issueUuid;
    }
    
}