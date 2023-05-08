<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Lctiendat\Customer\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;


class CustomerLogin implements ObserverInterface
{
    protected $_customerRepositoryInterface;
    protected $logger;


    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        LoggerInterface $logger
    ) {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {
            $customer = $observer->getEvent()->getCustomer();
            if ($customer) {
                $customerData = $customer->getDataModel();
                $customerData->setData('middlename', 'Mid');
                $customer->updateData($customerData);
                $customer->save();
            }
        } catch (\Throwable $th) {
            $this->logger->error($th->getMessage());
            echo $th->getMessage();
        }
    }
}
