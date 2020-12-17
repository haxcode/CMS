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

    public function __construct(Uuid $id, string $excerpt, string $description, string $release = '', bool $released = FALSE) {
        $this->id = $id;
        $this->excerpt = $excerpt;
        $this->description = $description;
        $this->release = $release;
        $this->released = $released;
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

}