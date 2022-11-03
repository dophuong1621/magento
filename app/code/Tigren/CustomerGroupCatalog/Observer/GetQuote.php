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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

//use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Stdlib\DateTime\DateTimeFactory;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\GroupCat\CollectionFactory;
use Zend_Log;
use Zend_Log_Exception;
use Zend_Log_Writer_Stream;

/**
 * Class GetQuote
 * @package Tigren\CustomerGroupCatalog\Observer
 */
class GetQuote implements ObserverInterface
{
    /**
     * @var Session
     */
    protected $_checkoutSession;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

//    /**
//     * @var DateTime
//     */
//    private $date;

    /**
     * @var DateTimeFactory
     */
    private $dateTimeFactory;

    /**
     * @param Session $checkoutSession
     * @param CollectionFactory $collectionFactory
     * //     * @param DateTime $date
     * @param DateTimeFactory $dateTimeFactory
     */
    public function __construct(
        Session           $checkoutSession,
        CollectionFactory $collectionFactory,
//        DateTime          $date,
        DateTimeFactory   $dateTimeFactory,
    )
    {
//        $this->date = $date;
        $this->_checkoutSession = $checkoutSession;
        $this->collectionFactory = $collectionFactory;
        $this->dateTimeFactory = $dateTimeFactory;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     * @throws Zend_Log_Exception
     */
    public function execute(Observer $observer)
    {
        $writer = new Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new Zend_Log();
        $logger->addWriter($writer);
        try {
            $product = $observer->getEvent()->getProduct(); // get product add to card
            $quoteItem = $observer->getEvent()->getQuoteItem();

            $sku = $product->getSku(); // sku product add to cart
            $priceProduct = $product->getPrice(); // price product

            // date
            $date = $this->dateTimeFactory->create();
            $formatDate = $date->gmtDate('Y-m-d H:i:s');
            $dateCurrent = date("Y-m-d H:i:s", strtotime($formatDate) + (60 * 420));

            // get rule
            $collection = $this->collectionFactory->create()
                ->addFieldToSelect('*')
                ->addFieldToFilter('active', 1)
                ->addFieldToFilter('product_ids', $sku)
                ->addFieldToFilter('start_time', ['lteq' => $dateCurrent])
                ->addFieldToFilter('time_end', ['gteq' => $dateCurrent])
                ->setOrder('priority', 'ASC');

            $rule = $collection->setPageSize(1)->getFirstItem();

            $logger->info(print_r($collection->getSelect()->__toString(), true));

            if ($rule->getId() > 0) {
                $discount = $rule->getDiscountAmount(); // price discount
                $price = $priceProduct - ($priceProduct * $discount / 100); //set price
                $quoteItem->setCustomPrice($price);
                $quoteItem->setOriginalCustomPrice($price);
                $quoteItem->getProduct()->setIsSuperMode(true);
            }
        } catch (Exception $e) {
            $writer = new Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
            $logger = new Zend_Log();
            $logger->addWriter($writer);
            $logger->info(print_r($e->getMessage(), true));
        }
    }
}
