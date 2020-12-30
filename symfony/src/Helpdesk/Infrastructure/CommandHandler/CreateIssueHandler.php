<?php

namespace App\Helpdesk\Infrastructure\CommandHandler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Helpdesk\Application\Command\CreateIssue;
use App\Helpdesk\Infrastructure\Repository\IssueRepository;
use App\Helpdesk\Domain\Entity\Issue;
use Symfony\Component\Uid\Uuid;
use App\Client\Infrastructure\Repository\ClientRepository;

/**
 * Class CreateIssueHandler
 *
 * @package          App\Helpdesk\Infrastructure\CommandHandler
 * @createDate       2020-12-13
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class CreateIssueHandler implements MessageHandlerInterface {

    /**
     * @var IssueRepository
     */
    private IssueRepository $repository;
    /**
     * @var ClientRepository
     */
    private ClientRepository $clientRepository;

    public function __construct(IssueRepository $repository, ClientRepository $clientRepository) {
        $this->repository = $repository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param CreateIssue $cm
     */
    public function __invoke(CreateIssue $cm): void {

        $client = $this->clientRepository->find($cm->getClient());
        $issue = new Issue(Uuid::v4(), $client, $cm->getComponent(), $cm->getTitle(), $cm->getDescription(), $cm->getAuthor(), $cm->getImportance(), $cm->getConfidential());
        file_put_contents('debug.html','<pre>'.print_r($issue,TRUE).'</pre>');
        $this->repository->create($issue);
    }

}
