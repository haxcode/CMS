<?php

namespace App\Helpdesk\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use App\Client\Domain\Entity\Client;
use App\Helpdesk\Domain\ValueObject\Importance;
use DateTime;
use App\Helpdesk\Domain\Exception\DomainHelpdeskLogicException;

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
     * @ORM\ManyToOne(targetEntity="App\Client\Domain\Entity\Client",fetch="EAGER")
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
     * @ORM\Column(type="datetime")
     */
    private DateTime $addDate;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private DateTime $lastModifyDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $solveDate;
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $solved = false;

    /**
     * @ORM\Column(type="bigint")
     */
    private int $author;

    /**
     * @ORM\Column(type="bigint",nullable=true)
     */
    private ?int $lastModifier;

    /**
     * @var int
     */
    private int $modifier;

    /**
     * @ORM\Column(type="string")
     */
    private string $importance;

    /**
     * @ORM\Column(type="boolean", name="is_confidential")
     */
    private string $confidential;

    /**
     * @ORM\Column(type="uuid", name="component_uuid")
     */
    private Uuid $component;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $withdrawn = false;

    /**
     * @ORM\Column(type="uuid", name="release_uuid")
     */
    private ?Uuid $release;

    public function __construct(Uuid $uuid, Client $client, Uuid $component, string $title, string $description, int $modifier, string $importance = Importance::NORMALLY, bool $confidential = FALSE) {

        $this->issueId = $uuid;
        $this->component = $component;
        $this->client = $client;
        $this->title = $title;
        $this->description = $description;
        $this->modifier = $modifier;
        $this->importance = $importance;
        $this->confidential = $confidential;

    }

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

    /**
     * @return Uuid
     */
    public function getComponent(): Uuid {
        return $this->component;
    }

    /**
     * @param Uuid $component
     */
    public function setComponent(Uuid $component): void {
        $this->component = $component;
    }

    public function stampModified(): void {
        $this->lastModifyDate = new DateTime();
        $this->lastModifier = $this->modifier;
    }

    public function stampCreate(): void {
        $this->addDate = new DateTime();
        $this->author = $this->modifier;
    }

    public function markAsSolved(): void {
        if ($this->isWithdrawn()) {
            throw new DomainHelpdeskLogicException('Can not mark issue as solved, because is withdrawn.');
        }

        if(!$this->getRelease()){
            throw new DomainHelpdeskLogicException('Can not solve issue! Issue must be related to release before mark as solved.');
        }

        if ($this->solved == true) {
            return;
        }
        $this->solveDate = new DateTime();
        $this->solved = true;
    }

    /**
     * @return bool
     */
    public function isSolved(): bool {
        return $this->solved;
    }

    /**
     * @param int $modifier
     */
    public function setModifier(int $modifier): void {
        $this->modifier = $modifier;
    }

    /**
     * @throws DomainHelpdeskLogicException
     */
    public function withdraw(): void {
        if ($this->isSolved()) {
            throw new DomainHelpdeskLogicException('Can not withdraw issue, because is marked as done.');
        }
        $this->withdrawn = true;
    }

    /**
     * @return bool
     */
    public function isWithdrawn(): bool {
        return $this->withdrawn;
    }

    /**
     * @return Uuid|null
     */
    public function getRelease(): ?Uuid {
        return $this->release;
    }

    /**
     * @param Uuid|null $release
     */
    public function setRelease(?Uuid $release): void {
        $this->release = $release;
    }

}