<?php

namespace Lctiendat\Sales\Api;

interface CustomerOrderInterface
{
    /**
     * @param string $fromDate
     * @param string $toDate
     * @return void
     */
    public function getCustomerOrder($fromDate, $toDate);
}
