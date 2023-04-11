<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Lctiendat\Brand\Block\Brand;

use Lctiendat\Brand\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;

/**
 * Catalog Products List widget block
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class Widget extends Template implements BlockInterface
{
    protected $brandCollectionFactory;

    public function __construct(
        Template\Context $context,
        array $data,
        CollectionFactory $brandCollectionFactory)
    {
        $this->brandCollectionFactory = $brandCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Set data to View
     */
    protected function _beforeToHtml()
    {
        // Init collection
        $collection = $this->brandCollectionFactory->create();

        // Get enabled images
        $brands = $collection->addFieldToFilter('is_active', ['eq' => true])->getData();
       
        $this->setData('brands', $brands);
        $this->setData('mediaURL', $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/tmp/category/');

        // Return to View
        return parent::_beforeToHtml();
    }
}
