<?php

namespace App\Helpdesk\Domain\Event;

use Symfony\Component\Uid\Uuid;
use App\Helpdesk\Domain\ValueObject\Importance;
use DateTime;
use App\Client\Domain\Entity\Client;
use App\Common\Event\Event;

class CreatedIssueFromClientWithSLAReported implements Event {

    /**
     * @var Uuid
     */
    private Uuid $issueID;
    /**
     * @var Importance
     */
    private Importance $importance;
    private DateTime   $reportedAt;
    /**
     * @var Client
     */
    private Client $client;
    private string $issueTitle;
    private int    $issuer;

    /**
     * IssueFromClientWithSLAReported constructor.
     *
     * @param Uuid       $issueID
     * @param string     $issueTitle
     * @param Client     $client
     * @param Importance $importance
     * @param DateTime   $reportedAt
     * @param int        $issuer
     */
    public function __construct(Uuid $issueID, string $issueTitle, Client $client, Importance $importance, DateTime $reportedAt, int $issuer) {

        $this->issueID = $issueID;
        $this->importance = $importance;
        $this->reportedAt = $reportedAt;
        $this->client = $client;
        $this->issueTitle = $issueTitle;
        $this->issuer = $issuer;
    }

    /**
     * @return string
     */
    public function getIssueTitle(): string {
        return $this->issueTitle;
    }

    /**
     * @return Uuid
     */
    public function getIssueID(): Uuid {
        return $this->issueID;
    }

    /**
     * @return Importance
     */
    public function getImportance(): Importance {
        return $this->importance;
    }

    /**
     * @return DateTime
     */
    public function getReportedAt(): DateTime {
        return $this->reportedAt;
    }

    /**
     * @return Client
     */
    public function getClient(): Client {
        return $this->client;
    }

    /**
     * @return int
     */
    public function getIssuer(): int {
        return $this->issuer;
    }

}