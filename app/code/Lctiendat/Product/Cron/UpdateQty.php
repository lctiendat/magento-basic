<?php

namespace Lctiendat\Product\Cron;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateQty
{
    protected $logger;
    protected $productRepository;
    protected $searchCriteriaBuilder;

    function __construct(
        LoggerInterface $logger,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuiler
    ) {
        $this->logger = $logger;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuiler;
    }

    public function execute()
    {
        try {
            $productCollection = $this->productRepository->getList($this->searchCriteriaBuilder->create());
            foreach ($productCollection->getItems() as $product) {
                $this->logger->info('Updating #' . $product->getId() . ' process...');
                $product->setStockData(['qty' => 1000]);
                $this->productRepository->save($product);
                $this->logger->info('Updated #' . $product->getId());
            }
            $this->logger->info('Updated all product successfully');
        } catch (\Throwable $th) {
            $this->logger->info($th->getMessage());
        }
    }
}
