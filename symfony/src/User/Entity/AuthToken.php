<?php

namespace App\User\Entity;

use App\User\Repository\AuthTokenRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use App\Common\UUID;
use Symfony\Component\Serializer\Annotation\Ignore;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=AuthTokenRepository::class)
 * @ORM\Table(name="`user_auth_token`")
 */
class AuthToken {

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private UUID $id;
    /**
     * @ORM\Column(type="string", nullable=TRUE)
     * @Ignore()
     */
    private ?UUID $parent_id = NULL;
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
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private DateTimeInterface $createdAt;
    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $resource = [];

    public function __construct(UUID $id) {
        $this->id = $id;
        $this->setCreatedAt();
    }

    public function getId(): UUID {
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

    public function getExpireAt(): ?DateTimeInterface {
        return $this->expireAt;
    }

    public function setExpireAt(DateTimeInterface $expireAt): void {
        $this->expireAt = $expireAt;
    }

    public function getCreatedAt(): ?DateTimeInterface {
        return $this->createdAt;
    }

    public function setCreatedAt(): void {
        $this->createdAt = new DateTime("now");
    }

    public function getResource(): ?array {
        return $this->resource;
    }

    public function setResource(?array $resource): void {
        $this->resource = $resource;
    }

    /**
     * @return ?UUID
     */
    public function getParentId(): ?UUID {
        return $this->parent_id;
    }

    /**
     * @param UUID $parent_id
     */
    public function setParentId(?UUID $parent_id = NULL): void {
        $this->parent_id = $parent_id;
    }

}
