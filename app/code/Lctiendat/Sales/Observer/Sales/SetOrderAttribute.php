<?php

namespace Lctiendat\Sales\Observer\Sales;


class SetOrderAttribute implements \Magento\Framework\Event\ObserverInterface

{
    protected $messageManager;
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }


    public function execute(
        \Magento\Framework\Event\Observer $observer
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
