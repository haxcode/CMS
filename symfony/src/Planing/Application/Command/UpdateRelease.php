<?php

namespace App\Planing\Application\Command;

use Symfony\Component\Security\Core\User\UserInterface;
use App\Common\CQRS\Command;

class UpdateRelease implements Command {

    private array $data;
    private array $changedFields;
    /**
     * @var UserInterface
     */
    private UserInterface $user;

    /**
     * UpdateTask constructor.
     *
     * @param array         $data
     * @param UserInterface $user
     */
    public function __construct(array $data, UserInterface $user) {

        $this->data = $data;
        $this->changedFields = array_keys($data);
        $this->user = $user;
    }

    /**
     * @param string $field
     *
     * @return bool
     */
    public function isChanged(string $field): bool {
        return in_array($field, $this->changedFields);
    }

    /**
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface {
        return $this->user;
    }

}