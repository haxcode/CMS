<?php

declare(strict_types=1);

namespace App\Common\CQRS;

/**
 * Interface QueryBus
 *
 * @package App\Common\CQRS
 */
interface QueryBus {

    /**
     * @param Query $query
     *
     * @return mixed
     */
    public function handle(Query $query);

}