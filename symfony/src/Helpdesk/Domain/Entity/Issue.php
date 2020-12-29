<?php

namespace App\Helpdesk\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Client\Domain\Entity\Client;
use App\User\Entity\User;
use App\Dictionary\Entity\Component;

/**
 * @ORM\Entity(repositoryClass="App\Helpdesk\Infrastructure\Repository\IssueRepository")
 */
class Issue {

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid",name="issue_id")
     */
    private Uuid $issueId;

    /**
     * @OneToOne(targetEntity="App\Client\Domain\Entity\Client")
     * @JoinColumn(name="client_uuid", referencedColumnName="id")
     */
    private Client $client;

    /**
     * @ORM\Column(type="text",name="title")
     */
    private string $title;

    /**
     * @ORM\Column(type="text",name="description")
     */
    private string $description;

    /**
     * @OneToOne(targetEntity="App\User\Entity\User")
     * @JoinColumn(name="usr_id", referencedColumnName="id")
     */
    private User $author;

    /**
     * @ORM\Column(type="string")
     */
    private string $importance;

    /**
     * @ORM\Column(type="boolean", name="is_confidential")
     */
    private string $confidential;

    /**
     * @OneToOne(targetEntity="App\Dictionary\Entity\Component")
     * @JoinColumn(name="component_uuid", referencedColumnName="id")
     */
    private string $component;

    /**
     * @return Uuid
     */
    public function getIssueId(): Uuid {
        return $this->issueId;
    }

    /**
     * @param Uuid $issueId
     */
    public function setIssueId(Uuid $issueId): void {
        $this->issueId = $issueId;
    }

    /**
     * @return Client
     */
    public function getClient(): Client {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getConfidential(): string {
        return $this->confidential;
    }

    /**
     * @param string $confidential
     */
    public function setConfidential(string $confidential): void {
        $this->confidential = $confidential;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getAuthor(): int {
        return $this->author;
    }

    /**
     * @param int $author
     */
    public function setAuthor(int $author): void {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getImportance(): string {
        return $this->importance;
    }

    /**
     * @param string $importance
     */
    public function setImportance(string $importance): void {
        $this->importance = $importance;
    }

}