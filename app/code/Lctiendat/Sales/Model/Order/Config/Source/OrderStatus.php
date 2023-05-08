<?php

namespace Lctiendat\Sales\Model\Order\Config\Source;

class OrderStatus implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'Yes', 'label' => 'Yes'],
            ['value' => 'No', 'label' => 'No']
        ];
    }
}
