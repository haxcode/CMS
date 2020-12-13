<?php

declare(strict_types=1);

namespace App\Common\CQRS;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerQueryBus
 *
 * @package          App\Common\CQRS
 * @createDate       2020-12-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class MessengerQueryBus implements QueryBus {

    use HandleTrait {
        handle as handleQuery;
    }

    /**
     * MessengerQueryBus constructor.
     *
     * @param MessageBusInterface $queryBus
     */
    public function __construct(MessageBusInterface $queryBus) {
        $this->messageBus = $queryBus;
    }

    /**
     * @param Query $query
     *
     * @return mixed
     */
    public function handle(Query $query) {
        return $this->handleQuery($query);
    }

}