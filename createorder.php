<?php

use Magento\Framework\App\Bootstrap;

require 'app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

$om = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $om->get('Psr\Log\LoggerInterface');
$storeManager->info('Magecomp Log');

$storeManager = $om->get('Magento\Store\Model\StoreManagerInterface');
$product = $om->get('Magento\Catalog\Model\Product');
$quote = $om->get('Magento\Quote\Model\QuoteFactory');
$quoteManagement = $om->get('Magento\Quote\Model\QuoteManagement');
$customerFactory = $om->get('Magento\Customer\Model\CustomerFactory');
$customerRepository = $om->get('Magento\Customer\Api\CustomerRepositoryInterface');
$orderService = $om->get('Magento\Sales\Model\Service\OrderService');
$cart = $om->get('Magento\Checkout\Model\Cart');
$productFactory = $om->get('Magento\Catalog\Model\ProductFactory');
$cartRepositoryInterface = $om->get('Magento\Quote\Api\CartRepositoryInterface');
$cartManagementInterface = $om->get('Magento\Quote\Api\CartManagementInterface');

$tempData = [
    'currency_id'  => 'USD',
    'email'        => 'lctiendat@gmail.com', //buyer email id
    'shipping_address' => [
        'firstname'    => 'Le Tien', //address Details
        'lastname'     => 'Dat',
        'street' => 'Main Street',
        'city' => 'Pheonix',
        'country_id' => 'US',
        'region_id'  => '12',
        'region' => 'Arizona',
        'postcode' => '85001',
        'telephone' => '823322565',
        'fax' => '3245845623',
        'save_in_address_book' => 10
    ],
    'items' => [
        //array of product which order you want to create
        ['product_id' => '23', 'qty' => 1],
        ['product_id' => '24', 'qty' => 1]
    ]
];

$store = $storeManager->getStore();
$websiteId = $storeManager->getStore()->getWebsiteId();
$customer = $customerFactory->create();
$customer->setWebsiteId($websiteId);
$customer->loadByEmail($tempData['email']); // load customet by email address
if (!$customer->getEntityId()) {
    //If not avilable then create this customer
    $customer->setWebsiteId($websiteId)
        ->setStore($store)
        ->setFirstname($tempData['shipping_address']['firstname'])
        ->setLastname($tempData['shipping_address']['lastname'])
        ->setEmail($tempData['email'])
        ->setPassword($tempData['email']);
    $customer->save();
}
$cart_id = $cartManagementInterface->createEmptyCart();
$cart = $cartRepositoryInterface->get($cart_id);

$cart->setStore($store);

// if you have already had the buyer id, you can load customer directly
$customer = $customerRepository->getById($customer->getEntityId());
$cart->setCurrency();
$cart->assignCustomer($customer); //Assign quote to customer

//add items in quote
foreach ($tempData['items'] as $item) {
    $product = $productFactory->create()->load($item['product_id']);
    $cart->addProduct(
        $product,
        intval($item['qty'])
    );
}

//Set Address to quote
//$quote->getBillingAddress()->addData($tempData['shipping_address']);
$cart->getBillingAddress()->addData($tempData['shipping_address']);
//$quote->getShippingAddress()->addData($tempData['shipping_address']);
$cart->getShippingAddress()->addData($tempData['shipping_address']);

/*$this->shippingRate
    ->setCode('freeshipping_freeshipping')
    ->getPrice(1);
*/
$shippingAddress = $cart->getShippingAddress();


$shippingQuoteRate = $objectManager->get('\Magento\Quote\Model\Quote\Address\Rate');
$shippingRateCarrier = 'freeshipping';
$shippingRateCarrierTitle = 'Freeshipping';
$shippingRateCode = 'freeshipping_freeshipping';
$shippingRateMethod = 'freeshipping';
$shippingRatePrice = '0';
$shippingRateMethodTitle = 'Free shipping';
$shippingAddress = $cart->getShippingAddress();
$shippingQuoteRate->setCarrier($shippingRateCarrier);
$shippingQuoteRate->setCarrierTitle($shippingRateCarrierTitle);
$shippingQuoteRate->setCode($shippingRateCode);
$shippingQuoteRate->setMethod($shippingRateMethod);
$shippingQuoteRate->setPrice($shippingRatePrice);
$shippingQuoteRate->setMethodTitle($shippingRateMethodTitle);
$shippingAddress->setCollectShippingRates(false)
    ->collectShippingRates()
    ->setShippingMethod($shippingRateCode);

// $shippingAddress->setCollectShippingRates(true)
//     ->collectShippingRates()
//     ->setShippingMethod('freeshipping_freeshipping'); //shipping method

$cart->getShippingAddress()->addShippingRate($shippingQuoteRate);
$cart->setPaymentMethod('checkmo'); //payment method

$cart->setInventoryProcessed(false);

// Set sales order payment
$cart->getPayment()->importData(['method' => 'checkmo']);

// Collect total and save
$cart->collectTotals();

// Submit the quote and create the order
$cart->save();
$cart = $cartRepositoryInterface->get($cart->getId());
$order_id = $cartManagementInterface->placeOrder($cart->getId());

echo "Order Created";
