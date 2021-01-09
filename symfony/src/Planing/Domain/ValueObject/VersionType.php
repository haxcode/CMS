<?php

namespace App\Planing\Domain\ValueObject;

use App\Common\Exception\NotSupportedType;

class VersionType {

    public const MAJOR = 'MAJOR';
    public const MINOR = 'MINOR';
    public const PATCH = 'PATCH';
    private string $guid;


    public function __construct(string $guid) {
        if (!self::isValid($guid)) {
            throw new NotSupportedType('Not supported type of importance');
        }
        $this->guid = $guid;
    }

    public static function getTypes(): array {
        return [
            self::MINOR => 'Main release',
            self::MAJOR => 'Release with features',
            self::PATCH => 'Release with bug-fixes',
        ];
    }

    /**
     * @param string $guid
     *
     * @return bool
     */
    public static function isValid(string $guid): bool {
        return in_array($guid, array_keys(self::getTypes()));
    }

    /**
     * @return string
     */
    public function getLevelName(): string {
        return self::getTypes()[$this->guid];
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->guid;
    }

}