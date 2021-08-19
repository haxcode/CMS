<?php

namespace App\Client\Domain\Entity;

use App\Client\Infrastructure\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Client\Domain\ValueObject\NIP;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Embeddable
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client {

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private Uuid $id;

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
     */
    private string $nip;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private bool $sla;

    /**
     * Client constructor.
     *
     * @param Uuid        $id
     * @param NIP         $nip
     * @param string      $name
     * @param string|null $shortName
     * @param bool        $sla
     */
    public function __construct(Uuid $id, NIP $nip, string $name, ?string $shortName, bool $sla = FALSE) {

        $this->id = $id;
        $this->nip = $nip;
        $this->name = $name;
        $this->shortName = $shortName;
        $this->sla = $sla;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void {
        $this->id = new Uuid($id);
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
    public function hasSla(): bool {
        return $this->sla;
    }

}
