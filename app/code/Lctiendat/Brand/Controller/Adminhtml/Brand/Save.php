<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lctiendat\Brand\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Lctiendat\Brand\Model\Brand;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Save CMS page action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
   // const ADMIN_RESOURCE = 'Magento_Cms::save';

    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param PageFactory|null $pageFactory
     * @param PageRepositoryInterface|null $pageRepository
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        PageFactory $pageFactory = null,
        PageRepositoryInterface $pageRepository = null
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->pageFactory = $pageFactory ?: ObjectManager::getInstance()->get(PageFactory::class);
        $this->pageRepository = $pageRepository ?: ObjectManager::getInstance()->get(PageRepositoryInterface::class);
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return ResultInterface
     */
    public function execute()
    {

        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            // Optimize data
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Brand::STATUS_ENABLED;
            }
            if (empty($data['brand_id'])) {
                $data['brand_id'] = null;
            }

            // if (empty($data['image'])) {
            //     $data['image'] = null;
            // } else {
            //     if ($data['image'][0] && $data['image'][0]['name'])
            //         $data['image'] = $data['image'][0]['name'];
            //     else
            //         $data['image'] = null;
            // }   



            // Init model and load by ID if exists
            $model = $this->_objectManager->create(\Lctiendat\Brand\Model\Brand::class);
            $id = $this->getRequest()->getParam('brand_id');
            if ($id) {
                $model->load($id);
            }

            // Validate data
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                // Redirect to Edit page if has error
                return $resultRedirect->setPath('*/*/edit', ['brand_id' => $model->getId(), '_current' => true]);
            }

           // dd($data);


            if (empty($data['image'])) {
                $data['image'] = null;
            } else {
                if ($data['image'][0] && $data['image'][0]['name'])
                    $data['image'] = $data['image'][0]['name'];
                else
                    $data['image'] = null;
            } 

            // Update model
            $model->setData($data);

            // Save data to database
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the brand.'));
                $this->dataPersistor->clear('brand');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['brand_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                dd($e);
                $this->messageManager->addException($e, __('Something went wrong while saving the brand.'));
            }

            $this->dataPersistor->set('brand', $data);
            return $resultRedirect->setPath('*/*/edit', ['brand_id' => $this->getRequest()->getParam('brand_id')]);
        }

        // Redirect to List page
        return $resultRedirect->setPath('*/*/');
    }

}