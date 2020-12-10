<?php

namespace App\Common;

use Symfony\Component\Uid\Uuid as UID;

/**
 * Class UUID
 *
 * @package          App\Common
 * @createDate       2020-12-10
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class UUID {

    /**
     * @var string|\Symfony\Component\Uid\AbstractUid|UID
     */
    private string $value;

    /**
     * UUID constructor.
     *
     * @param string $value
     */
    public function __construct(string $value) {
        $this->value = UID::fromString($value);
    }

    /**
     * @return static
     */
    public static function random(): self {
        return new self(UID::v4());
    }

    /**
     * @param string $uuid
     *
     * @return bool
     */
    public static function valid(string $uuid): bool {
        return UID::isValid($uuid);
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->value;
    }

    /**
     * @param UUID $id
     *
     * @return bool
     */
    public function isEqual(self $id): bool {
        return $this->value === $id->value;
    }

}