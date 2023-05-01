<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Lctiendat\Customer\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CustomerLogin implements ObserverInterface
{
    protected $_customerRepositoryInterface;


    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function execute(Observer $observer)
    {
        // $customer = $observer->getEvent()->getCustomer();
        // $customerData = $customer->getDataModel();
        // $customerData->setData('middlename', 'Mid');
        // $customer->updateData($customerData);
        // $customer->save();
    }
}
