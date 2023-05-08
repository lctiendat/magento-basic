<?php

namespace Lctiendat\Product\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Magento\Catalog\Ui\DataProvider\Product\ProductCollection;

class UpdateQty extends Command
{

    protected $productRepository;
    protected $searchCriteriaBuilder;
    protected $state;

    const NAME = 'snaptec:updatestock';

    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuiler,
        State $state
    ) {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuiler;
        $this->state = $state;
    }

    protected function configure()
    {
        $this->setName('snaptec:updatestock')
            ->setDescription('The description of you command here!');


        parent::configure(self::NAME);
    }

    function execute(InputInterface $input, OutputInterface $output)
    {
        $this->state->setAreaCode(Area::AREA_ADMINHTML);

        try {
            $productCollection = $this->productRepository->getList($this->searchCriteriaBuilder->create());
            foreach ($productCollection->getItems() as $product) {
                $output->writeln('Updating #' . $product->getId() . ' process...');
                $product->setStockData(['qty' => 1000]);
                $this->productRepository->save($product);
                $output->writeln('Updated #' . $product->getId());
            }
            $output->writeln('Updated all product successfully');
        } catch (\Throwable $th) {
            $output->writeln($th->getMessage());
        }
    }
}
