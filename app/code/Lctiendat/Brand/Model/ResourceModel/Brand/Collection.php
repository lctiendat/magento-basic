<?php
namespace Lctiendat\Brand\Model\ResourceModel\Brand;
 
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
class Collection extends AbstractCollection
{
    protected $_idFieldName="brand_id";
    protected function _construct()
    {
        $this->_init(
            'Lctiendat\Brand\Model\Brand',
            'Lctiendat\Brand\Model\ResourceModel\Brand'
        );
    }
}