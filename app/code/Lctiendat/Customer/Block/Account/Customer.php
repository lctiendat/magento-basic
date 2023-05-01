<?php

namespace Lctiendat\Customer\Block\Account;

use \Magento\Customer\Model\Session;


class Customer extends \Magento\Customer\Block\Account\AuthorizationLink
{

    protected $_customer;
    protected $_customerUrl;
    protected $_httpContext;

    public function __construct(
        Session $customer,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Customer\Model\Url $customerUrl,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $httpContext,
            $customerUrl,
            $postDataHelper,
            $data
        );

        $this->_customer = $customer;
        $this->_customerUrl = $customerUrl;
        $this->_httpContext = $httpContext;
    }


    public function getInforCustomer()
    {
        $customer = null;
        if ($this->isLoggedIn()) {
            $customer = [
                'email' => $this->_httpContext->getValue('customer_email'),
                'name' => $this->_httpContext->getValue('customer_name')
            ];
            return $customer;
        }
        return $customer;
    }

    public function getUrlMyAccount()
    {
        return $this->_customerUrl->getAccountUrl();
    }

    public function getLogoutUrl()
    {
        return $this->_customerUrl->getLogoutUrl();
    }
}
