<?php
namespace Lctiendat\Catalog\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class ProductCollection extends Template
{
    protected $productCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getNewProducts()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        // $collection->addAttributeToFilter('news_from_date', ['date' => true, 'to' => date('Y-m-d H:i:s')]);
        // $collection->addAttributeToSort('news_from_date', 'DESC');
        $collection->setPageSize(10);

        return $collection;
    }

    public function getBestsellers()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addStoreFilter();
        $collection->setPageSize(10); // Set the number of products to show

        return $collection;
    }
}