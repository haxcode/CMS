<?php

namespace App\Helpdesk\Domain\ValueObject;

use App\Common\UUID;

/**
 * Class Client
 *
 * @package          App\Helpdesk\Domain\ValueObject
 * @createDate       2020-12-10
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class Client {

    /**
     * @var UUID
     */
    private UUID $clientID;
    /**
     * @var bool
     */
    private bool $withSLA;

    /**
     * Client constructor.
     *
     * @param UUID $clientID
     * @param bool $withSLA
     */
    public function __construct(UUID $clientID, bool $withSLA = FALSE) {

        $this->clientID = $clientID;
        $this->withSLA = $withSLA;
    }

}