<?php 
namespace Lctiendat\Catalog\Block\Category;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoryCollection extends Template
{
    protected $categoryCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $categoryCollectionFactory,
        array $data = []
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getCategoryList()
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*')
        ->addIsActiveFilter()
        ->addAttributeToSort('position', 'ASC')
        ->addAttributeToFilter('is_active', 1)
        ->addAttributeToFilter('include_in_menu', 1)
        ->setPageSize(5);

        return $collection;
    }
}
