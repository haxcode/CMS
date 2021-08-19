<?php

namespace App\Planing\Domain\ValueObject;

use App\Common\Exception\NotSupportedType;

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
     * @param VersionType $versionType
     *
     * @return Version
     * @throws NotSupportedType
     */
    public function getNextVersion(VersionType $versionType): Version {
        switch ($versionType) {
            case VersionType::MAJOR:
                return new Version($this->major + 1, 0, 0);
            case VersionType::MINOR:
                return new Version($this->major, $this->minor + 1, 0);
            case VersionType::PATCH:
                return new Version($this->major, $this->minor, $this->patch + 1);
            default:
                throw new NotSupportedType('Not supported type of Version');
        }
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