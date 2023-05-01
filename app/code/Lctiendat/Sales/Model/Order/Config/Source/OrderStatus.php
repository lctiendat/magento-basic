<?php

namespace Lctiendat\Sales\Model\Order\Config\Source;

class OrderStatus implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => 'label1'],
            ['value' => 2, 'label' => 'label2']

        ];
    }
}
