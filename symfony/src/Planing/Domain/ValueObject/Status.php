<?php

namespace App\Planing\Domain\ValueObject;

use App\Common\Exception\NotSupportedType;
use Stringable;

class Status implements Stringable {

    public const BACKLOG = 'BACKLOG';
    public const WEEKLY = 'WEEKLY';
    public const DAILY = 'DAILY';
    public const VERIFICATION = 'VERIFICATION';
    public const DONE = 'DONE';
    public const CANCELED = 'CANCELED';
    private string $guid;

    public function __construct(string $guid = self::BACKLOG) {
        if (!self::isValid($guid)) {
            throw new NotSupportedType('Not supported type of state');
        }
        $this->guid = $guid;
    }

    public static function getTypes(): array {
        return [
            self::BACKLOG      => 'added to backlog',
            self::WEEKLY       => 'planed in this sprint',
            self::DAILY        => 'in progres',
            self::VERIFICATION => 'done - in verification stage',
            self::DONE         => 'done',
            self::CANCELED     => 'canceled',
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