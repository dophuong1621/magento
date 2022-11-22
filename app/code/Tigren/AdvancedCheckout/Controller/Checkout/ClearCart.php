<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Controller\Checkout;

use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class AdvancedCheckout
 * @package Tigren\AdvancedCheckout\Controller\Checkout
 */
class ClearCart extends Action
{

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @param Cart $cart
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Cart        $cart,
        Context     $context,
        JsonFactory $resultJsonFactory,
    ) {
        parent::__construct($context);
        $this->cart = $cart;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * @return Json
     */
    public function execute()
    {
        $this->cart->truncate()->save();
        $response = [
            'result' => true,
        ];
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
    }
}
