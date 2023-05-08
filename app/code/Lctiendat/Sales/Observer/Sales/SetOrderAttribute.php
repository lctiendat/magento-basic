<?php

namespace Lctiendat\Sales\Observer\Sales;

use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SetOrderAttribute implements ObserverInterface

{
    protected $messageManager;
    public function __construct(
        ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }


    public function execute(
        Observer $observer
    ) {
        try {
            $order = $observer->getOrder();
            $grandTotal = $observer->getData('order')->getGrandTotal();
            if ($grandTotal > 200) {
                $order->setOrderStatus('Yes');
                return $order->save();
            }
            $order->setOrderStatus('No');
            return $order->save();
        } catch (\Throwable $th) {
            $this->messageManager->addErrorMessage('Error', $th->getMessage());
        }
    }
}
