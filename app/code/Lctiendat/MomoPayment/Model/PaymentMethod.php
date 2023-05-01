<?php

namespace Lctiendat\MomoPayment\Model;

/**
 * MD Custom Payment Method Model
 */
class PaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{
    /**
     * Payment Method code
     *
     * @var string
     */
    protected $_code = 'custompayment';
}
