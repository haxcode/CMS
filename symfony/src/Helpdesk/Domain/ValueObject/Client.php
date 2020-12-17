<?php

namespace App\Helpdesk\Domain\ValueObject;


use Symfony\Component\Uid\Uuid;

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
     * @var Uuid
     */
    private Uuid $clientID;
    /**
     * @var bool
     */
    private bool $withSLA;

    /**
     * Client constructor.
     *
     * @param Uuid $clientID
     * @param bool $withSLA
     */
    public function __construct(Uuid $clientID, bool $withSLA = FALSE) {

        $this->clientID = $clientID;
        $this->withSLA = $withSLA;
    }

}