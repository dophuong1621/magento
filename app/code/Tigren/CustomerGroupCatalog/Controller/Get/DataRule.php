<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Controller\Get;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\GroupCat\CollectionFactory;

/**
 * Class DataRule
 * @package Tigren\CustomerGroupCatalog\Controller\Get
 */
class DataRule extends Action
{
    /**
     * @var PageFactory
     */
    protected $PageFactory;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var
     */
    private $dateTimeFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context           $context,
        PageFactory       $pageFactory,
        CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->PageFactory = $pageFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return void
     */
    public function execute()
    {
        echo "Lấy dữ liệu từ bảng tigren_customer_group_catalog";
        $this->collectionFactory->create();
        $collection = $this->collectionFactory->create()
            ->addFieldToSelect(['*'])
            ->addFieldToFilter('active', 1);

        echo '<pre>';
        print_r($collection->getData());
        echo '<pre>';
    }

    /**
     * @param int $id
     * @return void
     */
    public function getRule(int $id)
    {
        var_dump($id);
    }
}
