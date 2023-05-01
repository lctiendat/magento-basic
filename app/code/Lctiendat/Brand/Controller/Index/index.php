<?php
declare(strict_types=1);

namespace Lctiendat\Brand\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;


/**
 * Class Index
 */
class Index extends \Magento\Framework\App\Action\Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
      * @var RequestInterface
      */
    private $request;

    /**
     * @param PageFactory $pageFactory
     * @param RequestInterface $request
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        // // Get the params that were passed from our Router
        // $firstParam = $this->request->getParam('first_param', null);
        // $secondParam = $this->request->getParam('second_param', null);

        return $this->pageFactory->create();
    }
}