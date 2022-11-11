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
use Tigren\AdvancedCheckout\Model\ResourceModel\Quote\CollectionFactory;
use Zend_Log_Exception;

/**
 * Class AdvancedCheckout
 * @package Tigren\AdvancedCheckout\Controller\Checkout
 */
class AdvancedCheckout extends Action
{
    /**
     * @var CollectionFactory
     */
    private $quoteItemFactory;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @param Cart $cart
     * @param Context $context
     */
    public function __construct(
        Cart              $cart,
        Context           $context,
        CollectionFactory $quoteItemFactory,
    )
    {
        parent::__construct($context);
        $this->quoteItemFactory = $quoteItemFactory;
        $this->cart = $cart;
    }

    /**
     * @return false|string
     * @throws Zend_Log_Exception
     */
    public function execute()
    {
        $allProDuctInCart = $this->cart->getQuote()->getAllVisibleItems();

        $idProduct = $this->getRequest()->getParam('product');

        $collection = $this->quoteItemFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('product_id', $idProduct)
            ->setOrder('quote_id', 'DESC');

        $addProduct = $collection->setPageSize(1)->getFirstItem();
        $skuProduct = $addProduct->getSku();

        foreach ($allProDuctInCart as $item) {
            if ($item->getSku() == $skuProduct) {
                $data = [
                    'product_in_cart' => $skuProduct,
                ];

                echo json_encode([
                    'result' => true,
                    'data' => $data,
                ]);
            }
        }
    }
}
