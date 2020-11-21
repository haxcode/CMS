<?php

namespace App\User\Entity;

use App\User\Repository\AuthTokenRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass=AuthTokenRepository::class)
 * @ORM\Table(name="`user_auth_token`")
 */
class AuthToken {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $userId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $token;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isRefresh;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $expireAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $resource = [];

    public function getId(): ?int {
        return $this->id;
    }

    public function getUserId(): ?int {
        return $this->userId;
    }

    public function setUserId(int $userId): self {
        $this->userId = $userId;

        return $this;
    }

    public function getToken(): ?string {
        return $this->token;
    }

    public function setToken(string $token): self {
        $this->token = $token;

        return $this;
    }

    public function getIsRefresh(): ?bool {
        return $this->isRefresh;
    }

    public function setIsRefresh(bool $isRefresh): self {
        $this->isRefresh = $isRefresh;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeInterface $expireAt): self {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getResource(): ?array {
        return $this->resource;
    }

    public function setResource(?array $resource): self {
        $this->resource = $resource;

        return $this;
    }

}
