<?php

namespace App\Planing\Domain\ValueObject;

class Version {

    private int $major;
    private int $minor;
    private int $patch;

    /**
     * Version constructor.
     *
     * @param int $major
     * @param int $minor
     * @param int $patch
     */
    public function __construct(int $major = 0, int $minor = 0, int $patch = 0) {
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
    }

    /**
     * @return int
     */
    public function getMajor(): int {
        return $this->major;
    }

    /**
     * @return int
     */
    public function getMinor(): int {
        return $this->minor;
    }

    /**
     * @return int
     */
    public function getPatch(): int {
        return $this->patch;
    }

    public function __toString(): string {
        return $this->major.'.'.$this->getMinor().'.'.$this->patch;
    }

}