<?php

namespace App\Helpdesk\Application\Command;

use App\Common\CQRS\Command;
use Symfony\Component\Uid\Uuid;

final class CreateIssue implements Command {

    private string $title;
    private string $description;
    private int    $author;
    private ?Uuid  $client;
    private string $importance;
    private bool   $confidential;
    private ?Uuid  $component;

    /**
     * CreateIssue constructor.
     *
     * @param string    $title
     * @param string    $description
     * @param string    $importance
     * @param bool      $confidential
     * @param int       $author
     * @param Uuid|null $client
     * @param Uuid|null $component
     */
    public function __construct(string $title, string $description, string $importance, bool $confidential, int $author, ?Uuid $client, ?Uuid $component) {

        $this->title = $title;
        $this->description = $description;
        $this->client = $client;
        $this->author = $author;
        $this->importance = $importance;
        $this->confidential = $confidential;
        $this->component = $component;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getAuthor(): int {
        return $this->author;
    }

    /**
     * @return Uuid|null
     */
    public function getClient(): ?Uuid {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getImportance(): string {
        return $this->importance;
    }

    /**
     * @return bool
     */
    public function getConfidential(): bool {
        return $this->confidential;
    }

    /**
     * @return Uuid|null
     */
    public function getComponent(): ?Uuid {
        return $this->component;
    }

}