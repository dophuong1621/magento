<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Observer;

use Exception;
use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;
use Tigren\CustomerGroupCatalog\Model\GroupCatHistory;
use Zend_Log;
use Zend_Log_Exception;
use Zend_Log_Writer_Stream;

/**
 * Class OrderGroupCat
 * @package Tigren\CustomerGroupCatalog\Observer
 */
class OrderGroupCat implements ObserverInterface
{
    /* @var $order Order */
    /**
     * @param Observer $observer
     * @return void
     */
    protected $customerSession;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var GroupCatHistory
     */
    private $groupCatHistory;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @param Session $customerSession
     */

    public function __construct(
        Session         $customerSession,
        Session         $checkoutSession,
        GroupCatHistory $groupCatHistory,
        LoggerInterface $logger,
    ) {
        $this->groupCatHistory = $groupCatHistory;
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws Zend_Log_Exception
     */

    public function execute(Observer $observer)
    {
        $writer = new Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new Zend_Log();
        $logger->addWriter($writer);
        try {
            $order = $observer->getEvent()->getData('order');
            $customerId = $order->getCustomerId(); // customer id

            $ruleId = $this->checkoutSession->getRuleId(); // rule id
            $productId = $this->checkoutSession->getProductId(); // rule id

            if ($ruleId) {
                $oderDataHistory = [
                    'order_id' => $order->getIncrementId(),
                    'customer_id' => $customerId,
                    'rule_id' => $ruleId,
                    'product_id' => $productId,
                ];

                $groupCatHistory = $this->groupCatHistory;
                $groupCatHistory->addData($oderDataHistory);
                $groupCatHistory->save();
                $this->checkoutSession->unsRuleId();
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
        }
    }
}