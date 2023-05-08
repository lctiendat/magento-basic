<?php

namespace Lctiendat\Sales\Plugin;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
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

    public function getAItem(
        $resultOrder
    ) {
        $extensionAttributes = $resultOrder->getExtensionAttributes();
        if ($extensionAttributes && $extensionAttributes->getOrderStatus()) {
            return $resultOrder;
        }
        $orderExtension = $extensionAttributes ? $extensionAttributes : $this->orderExtensionFactory->create();
        $orderExtension->setOrderStatus($resultOrder->getOrderStatus());
        $resultOrder->setExtensionAttributes($orderExtension);
        return $resultOrder;
    }

    public function afterGetList(
        OrderRepositoryInterface $subject,
        Collection $resultOrder
    ) {
        foreach ($resultOrder->getItems() as $order) {
            $this->getAItem($order);
        }
        return $resultOrder;
    }
}
