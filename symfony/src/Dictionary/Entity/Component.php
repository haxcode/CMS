<?php

namespace App\Dictionary\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Dictionary\Repository\ComponentRepository;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ComponentRepository::class)
 */
class Component {

    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="uuid", unique=true)
     */
    private Uuid $id;

    /**
     * @ORM\Column(name="name",type="string")
     */
    private string $name;
    /**
     * @ORM\Column(name="description")
     */
    private string $description;

    /**
     * @ORM\Column(name="version",nullable=TRUE)
     */
    private string $version;

    /**
     * @ORM\Column(name="is_stable")
     */
    private bool $is_stable;

    public function __construct(Uuid $id, string $name, string $description, string $version = '', bool $is_stable = TRUE) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->version = $version;
        $this->is_stable = $is_stable;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid {
        return $this->id;
    }

    /**
     * @param Uuid $id
     */
    public function setId(Uuid $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
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
    public function getVersion(): string {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void {
        $this->version = $version;
    }

    /**
     * @return bool
     */
    public function isIsStable(): bool {
        return $this->is_stable;
    }

    /**
     * @param bool $is_stable
     */
    public function setIsStable(bool $is_stable): void {
        $this->is_stable = $is_stable;
    }

}