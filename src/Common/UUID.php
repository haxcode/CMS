<?php

namespace App\Common;

use Symfony\Component\Uid\Uuid as UID;

final class UUID {

    private string $value;

    public function __construct(string $value) {
        $this->value = UID::fromString($value);
    }

    public static function random(): self {
        return new self(UID::v4());
    }

    public function __toString(): string {
        return $this->value;
    }

    public function isEqual(self $id): bool {
        return $this->value === $id->value;
    }

}