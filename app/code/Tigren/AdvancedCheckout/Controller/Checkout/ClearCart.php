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
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\Result\JsonFactory;
use Tigren\AdvancedCheckout\Model\ResourceModel\Quote\CollectionFactory;
use Zend_Log;
use Zend_Log_Exception;
use Zend_Log_Writer_Stream;

/**
 * Class AdvancedCheckout
 * @package Tigren\AdvancedCheckout\Controller\Checkout
 */
class ClearCart extends Action
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @param Cart $cart
     * @param JsonFactory $jsonFactory
     * @param Context $context
     */
    public function __construct(
        Cart              $cart,
        JsonFactory       $jsonFactory,
        Context           $context,
        CollectionFactory $collectionFactory,
    )
    {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->cart = $cart;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return false|string
     * @throws Zend_Log_Exception
     */
    public function execute()
    {
        $checkoutSession = $this->getCheckoutSession();
        $allItems = $checkoutSession->getQuote()->getAllVisibleItems();


        foreach ($allItems as $item) {
            $cartItemId = $item->getItemId();
            $itemObj = $this->getItemModel()->load($cartItemId);

            $itemObj->delete();

            echo json_encode([
                'result' => true,
            ]);
        }
    }

    public function getCheckoutSession()
    {
        $objectManager = ObjectManager::getInstance();
        $checkoutSession = $objectManager->get('Magento\Checkout\Model\Session');
        return $checkoutSession;
    }

    public function getItemModel()
    {
        $objectManager = ObjectManager::getInstance();
        $itemModel = $objectManager->create('Magento\Quote\Model\Quote\Item');
        return $itemModel;
    }
}
