<?php
namespace Lctiendat\Brand\Model;

class Brand extends \Magento\Framework\Model\AbstractModel
{

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 1;

    protected function _construct()
    {
        $this->_init('Lctiendat\Brand\Model\ResourceModel\Brand');
    }
}