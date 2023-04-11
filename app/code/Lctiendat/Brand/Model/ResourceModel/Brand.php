<?php
namespace Lctiendat\Brand\Model\ResourceModel;
 
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
 
class Brand extends AbstractDb
{
    protected function _construct()
    {
        // magetop_hello là tên bảng , id là khóa chính primary của bảng
        $this->_init('lctiendat_manager_brand', 'brand_id');
    }
}