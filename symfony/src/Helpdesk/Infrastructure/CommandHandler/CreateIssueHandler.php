<?php

namespace App\Helpdesk\Infrastructure\CommandHandler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Helpdesk\Application\Command\CreateIssue;

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
     * @param CreateIssue $command
     */
    public function __invoke(CreateIssue $command): void {

      
    }

}
