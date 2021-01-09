<?php

namespace App\Helpdesk\Application\Command;

use App\Common\CQRS\Command;
use Symfony\Component\Security\Core\User\UserInterface;

class UpdateIssue implements Command {

    private array $data;

    private array $changedFields = [];
    /**
     * @var UserInterface
     */
    private UserInterface $modifier;

    /**
     * UpdateIssue constructor.
     *
     * @param array         $data
     * @param UserInterface $modifier
     */
    public function __construct(array $data, UserInterface $modifier) {
        $this->data = $data;
        $this->changedFields = array_keys($data);
        $this->modifier = $modifier;
    }

    /**
     * @return array
     */
    public function getData(): array {
        return $this->data;
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
     * @return UserInterface
     */
    public function getModifier(): UserInterface {
        return $this->modifier;
    }

}