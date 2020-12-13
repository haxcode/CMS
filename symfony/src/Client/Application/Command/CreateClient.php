<?php

namespace App\Client\Application\Command;

final class CreateClient {

    private string  $name;
    private string  $nip;
    private ?string $shortName;
    private bool    $sla;

    public function __construct(string $nip, string $name, ?string $shortName, bool $sla = FALSE) {
        $this->name = $name;
        $this->nip = $nip;
        $this->shortName = $shortName;
        $this->sla = $sla;
    }

    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNip(): string {
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
