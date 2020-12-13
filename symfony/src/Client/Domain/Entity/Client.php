<?php

namespace App\Client\Domain\Entity;

use App\Client\Infrastructure\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Common\UUID;
use App\Client\Domain\ValueObject\NIP;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client {

    /**
     * @ORM\Id
     * @ORM\Column(type="string", unique=true)
     */
    private UUID $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private string $name;

    /**
     * @ORM\Column(type="string", nullable=TRUE)
     * @var string|null
     */
    private ?string $shortName;

    /**
     * @ORM\Column(type="string")
     * @var NIP
     */
    private NIP $nip;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private bool $sla;

    /**
     * Client constructor.
     *
     * @param UUID        $id
     * @param NIP         $nip
     * @param string      $name
     * @param string|null $shortName
     * @param bool        $sla
     */
    public function __construct(UUID $id, NIP $nip, string $name, ?string $shortName, bool $sla = FALSE) {

        $this->id = $id;
        $this->nip = $nip;
        $this->name = $name;
        $this->shortName = $shortName;
        $this->sla = $sla;
    }

    /**
     * @return UUID
     */
    public function getId(): UUID {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void {
        $this->id = new UUID($id);
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getShortName(): string {
        return $this->shortName;
    }

    /**
     * @return string
     */
    public function getNip(): string {
        return $this->nip;
    }

    /**
     * @return bool
     */
    public function isSla(): bool {
        return $this->sla;
    }

}
