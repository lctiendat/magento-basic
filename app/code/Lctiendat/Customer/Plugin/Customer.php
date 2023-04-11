<?php

namespace Lctiendat\Customer\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;

class Customer
{
    public function afterSave(CustomerRepositoryInterface $subject, CustomerInterface $customer)
    {
        $customMobile = '5666999999'; 
        $currentMobile = $customer->getCustomAttribute('customer_mobile');
        if($currentMobile) {
          $currentMobile = $customer->getCustomAttribute('customer_mobile')->getValue();
        }
        if($currentMobile !== $customMobile) {
            $customer->setCustomAttribute('customer_mobile',$customMobile);
            return $subject->save($customer);
        }
        return $customer;
        
    }
}
