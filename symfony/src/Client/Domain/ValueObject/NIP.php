<?php

namespace App\Client\Domain\ValueObject;

use App\Client\Domain\Exception\NotValidNIP;
use Stringable;

/**
 * Class NIP
 *
 * @package          App\Client\Domain\ValueObject
 * @createDate       2020-12-13
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class NIP implements Stringable {

    /**
     * @var string
     */
    private string $nip;

    /**
     * NIP constructor.
     *
     * @param string $nip
     *
     * @throws NotValidNIP
     */
    public function __construct(string $nip) {
        $this->setNIP($nip);
    }

    /**
     * @param string $nip
     *
     * @return NIP
     * @throws NotValidNIP
     */
    public static function create(string $nip): NIP {
        $nipWithoutDashes = preg_replace('/-/', '', $nip);
        return new self($nipWithoutDashes);
    }

    public static function validate($nip): bool {
        $reg = '/^[0-9]{10}$/';
        if (preg_match($reg, $nip) == FALSE) {
            return FALSE;
        }

        $digits = str_split($nip);
        //compute checksum for NIP
        $checksum = (6 * intval($digits[0]) + 5 * intval($digits[1]) + 7 * intval($digits[2]) + 2 * intval($digits[3]) + 3 * intval($digits[4]) + 4 * intval($digits[5]) + 5 * intval($digits[6]) + 6 * intval($digits[7]) + 7 * intval($digits[8])) % 11;
        return (intval($digits[9]) == $checksum);

    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->nip;
    }

    /**
     * @param string $nip
     *
     * @throws NotValidNIP
     */
    private function setNIP(string $nip): void {
        if (!self::validate($nip)) {
            throw new NotValidNIP();
        }
        $this->nip = $nip;
    }

}