<?php

namespace Lctiendat\Sales\Plugin;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\ResourceModel\Order\Collection;

class OrderRepository
{
    /**
     * @var OrderExtensionFactory
     */
    protected $orderExtensionFactory;

    /**
     * Init plugin
     *
     * @param OrderExtensionFactory $orderExtensionFactory
     */
    public function __construct(
        OrderExtensionFactory $orderExtensionFactory
    ) {
        $this->orderExtensionFactory = $orderExtensionFactory;
    }

    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface $resultOrder
    ) {
        $extensionAttributes = $resultOrder->getExtensionAttributes();
        if ($extensionAttributes && $extensionAttributes->getOrderStatus()) {
            return $resultOrder;
        }

        /** @var \Magento\Sales\Api\Data\OrderExtension $orderExtension */
        $orderExtension = $extensionAttributes ? $extensionAttributes : $this->orderExtensionFactory->create();
        $orderExtension->setOrderStatus($resultOrder->getOrderStatus());
        $resultOrder->setExtensionAttributes($orderExtension);

        return $resultOrder;
    }

    public function afterGetList(
        OrderRepositoryInterface $subject,
        Collection $resultOrder
    ) {
        /** @var  $order */
        foreach ($resultOrder->getItems() as $order) {
            $this->afterGet($subject, $order);
        }
        return $resultOrder;
    }
}
