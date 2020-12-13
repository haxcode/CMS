<?php

namespace App\Helpdesk\Application\Command;

use App\Common\CQRS\Command;

/**
 * Class CreateIssue
 *
 * @package          App\Helpdesk\Application\Command
 * @createDate       2020-12-10
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class CreateIssue implements Command {

    private string  $title;
    private string  $description;
    private int     $author;
    private ?string $client;
    private string  $importance;
    private string  $confidential;

    /**
     * CreateIssue constructor.
     *
     * @param string      $title
     * @param string      $description
     * @param string      $importance
     * @param string      $confidential
     * @param int         $author
     * @param string|null $client
     */
    public function __construct(string $title, string $description, string $importance, string $confidential, int $author, ?string $client) {

        $this->title = $title;
        $this->description = $description;
        $this->client = $client;
        $this->author = $author;
        $this->importance = $importance;
        $this->confidential = $confidential;
    }

}