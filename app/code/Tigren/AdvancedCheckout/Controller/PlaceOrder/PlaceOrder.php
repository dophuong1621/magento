<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Controller\PlaceOrder;

use Magento\Checkout\Model\Cart;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Tigren\AdvancedCheckout\Model\ResourceModel\SalesOrder\CollectionFactory;
use Zend_Log_Exception;

/**
 * Class AdvancedCheckout
 * @package Tigren\AdvancedCheckout\Controller\PlaceOrder
 */
class PlaceOrder extends Action
{
    /**
     * @var CollectionFactory
     */
    private $salesOrderFactory;

    /**
     * @var Cart
     */
    private $cart;

    private $_customerSession;

    /**
     * @param Cart $cart
     * @param Context $context
     */
    public function __construct(
        Cart              $cart,
        Context           $context,
        CollectionFactory $salesOrderFactory,
        Session           $customerSession,
    )
    {
        parent::__construct($context);
        $this->salesOrderFactory = $salesOrderFactory;
        $this->cart = $cart;
        $this->_customerSession = $customerSession;
    }

    /**
     * @return void
     * @throws Zend_Log_Exception
     */
    public function execute()
    {
        $email = $this->_customerSession->getCustomer()->getEmail();

        $collection = $this->salesOrderFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('customer_email', $email)
            ->setOrder('entity_id', 'ASC');

        $checkStatus = $collection->setPageSize(1)->getFirstItem();

        $status = $checkStatus->getStatus();
        $complete = 'complete';

        if (strpos($complete, $status) === false) {
            echo json_encode([
                'result' => false,
            ]);
        } else {
            echo json_encode([
                'result' => false,
            ]);
        }
    }
}
