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

    /**
     * IssueFromClientWithSLAReported constructor.
     *
     * @param Uuid       $issueID
     * @param Client     $client
     * @param Importance $importance
     * @param DateTime   $reportedAt
     */
    public function __construct(Uuid $issueID, Client $client, Importance $importance, DateTime $reportedAt) {

        $this->issueID = $issueID;
        $this->importance = $importance;
        $this->reportedAt = $reportedAt;
        $this->client = $client;
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

}