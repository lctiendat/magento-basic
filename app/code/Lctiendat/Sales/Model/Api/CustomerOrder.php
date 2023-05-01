<?php

namespace Lctiendat\Sales\Model\Api;

use Psr\Log\LoggerInterface;
use \Magento\Framework\App\Request\Http;
use Magento\Sales\Model\OrderRepository;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class CustomerOrder implements \Lctiendat\Sales\Api\CustomerOrderInterface
{

    protected $logger;
    protected $request;
    protected $orderRepository;
    protected $orderCollectionFactory;
    protected $resultJsonFactory;

    public function __construct(
        LoggerInterface $logger,
        Http $request,
        OrderRepository $orderRSP,
        CollectionFactory $orderCollectionFactory,
        JsonFactory $resultJsonFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;
        $this->request = $request;
        $this->orderRepository = $orderRSP;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    public function getCustomerOrder()
    {
        try {
            $fromDate = $this->request->getParam('from');
            $toDate = $this->request->getParam('to');
            $orders = $this->orderCollectionFactory->create()
                ->addFieldToSelect('*')
                ->addFieldToFilter('created_at', ['from' => $fromDate, 'to' => $toDate])
                ->getData();
            echo json_encode($orders);
        } catch (\Throwable $th) {
            $this->logger->error($th->getMessage());
            echo json_encode([
                'success' =>  false,
                'message' => $th->getMessage()
            ]);
        }
    }

    function convertData()
    {
        return [];
    }
}
