<?php

namespace App\Dictionary\Change;

use Doctrine\ORM\Mapping as ORM;
use App\Common\UUID;

/**
 * @ORM\Entity(repositoryClass=ChangeRepository::class)
 * @ORM\Table(name="change")
 */
class Change {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     */
    private UUID $id;

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

    public function __construct(UUID $id, string $excerpt, string $description, string $release = '', bool $released = FALSE) {
        $this->id = $id;
        $this->excerpt = $excerpt;
        $this->description = $description;
        $this->release = $release;
        $this->released = $released;
    }

    /**
     * @return UUID
     */
    public function getId(): UUID {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getExcerpt(): string {
        return $this->excerpt;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
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