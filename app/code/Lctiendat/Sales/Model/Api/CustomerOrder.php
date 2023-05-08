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

    public function getCustomerOrder($fromDate, $toDate): void
    {
        try {
            $orders = $this->orderCollectionFactory->create()
                ->addFieldToSelect('*')
                ->addFieldToFilter('created_at', ['fromDate' => $fromDate, 'toDate' => $toDate])
                ->getData();
            echo json_encode(array_values($this->group($orders)));
        } catch (\Throwable $th) {
            $this->logger->error($th->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    function group($arrayVar): array
    {
        $arrUsers = array_map(function ($item) {
            return  [
                "customer_email" => $item["customer_email"],
                "customer_firstname" => $item["customer_firstname"],
                "customer_lastname" => $item["customer_lastname"],
                "customer_middlename" => $item["customer_middlename"],
                "customer_prefix" => $item["customer_prefix"],
                "customer_suffix" => $item["customer_suffix"],
                "customer_taxvat" => $item["customer_taxvat"],
            ];
        }, $arrayVar);
        $arrUsers = array_unique($arrUsers, SORT_REGULAR);
        foreach ($arrUsers as $key => &$user) {
            $user['orders'] = array_values(array_filter($arrayVar, fn ($order) => $order['customer_email'] == $user['customer_email']));
        }
        return $arrUsers;
    }
}
