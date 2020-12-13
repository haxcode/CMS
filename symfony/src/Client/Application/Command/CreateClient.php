<?php

namespace App\Client\Application\Command;

use App\Common\CQRS\Command;
use App\Client\Domain\ValueObject\NIP;

final class CreateClient implements Command {

    private string  $name;
    private NIP     $nip;
    private ?string $shortName;
    private bool    $sla;

    public function __construct(string $nip, string $name, ?string $shortName, bool $sla = FALSE) {
        $this->name = $name;
        $this->nip = NIP::create($nip);
        $this->shortName = $shortName;
        $this->sla = $sla;
    }

    public function getName(): string {
        return $this->name;
    }

    /**
     * @return NIP
     */
    public function getNip(): NIP {
        return $this->nip;
    }

    /**
     * @return string|null
     */
    public function getShortName(): ?string {
        return $this->shortName;
    }

    /**
     * @return bool
     */
    public function isSla(): bool {
        return $this->sla;
    }

}
