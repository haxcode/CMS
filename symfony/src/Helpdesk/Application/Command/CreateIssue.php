<?php

namespace App\Helpdesk\Application\Command;

use App\Common\CQRS\Command;


final class CreateIssue implements Command {

    private string  $title;
    private string  $description;
    private int     $author;
    private ?string $client;
    private string  $importance;
    private bool    $confidential;

    /**
     * CreateIssue constructor.
     *
     * @param string      $title
     * @param string      $description
     * @param string      $importance
     * @param bool        $confidential
     * @param int         $author
     * @param string|null $client
     */
    public function __construct(string $title, string $description, string $importance, bool $confidential, int $author, ?string $client) {

        $this->title = $title;
        $this->description = $description;
        $this->client = $client;
        $this->author = $author;
        $this->importance = $importance;
        $this->confidential = $confidential;
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
     * @return string|null
     */
    public function getClient(): ?string {
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

}