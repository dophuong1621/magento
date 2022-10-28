<?php

namespace Tigren\CustomerGroupCatalog\Controller\Get;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\GroupCat;

/**
 * Class DataRule
 * @package Tigren\CustomerGroupCatalog\Controller\Get
 */
class DataRule extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $PageFactory;
    /**
     * @var GroupCat
     */
    protected GroupCat $groupCat;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param GroupCat $groupCat
     */
    public function __construct(Context $context, PageFactory $pageFactory, GroupCat $groupCat)
    {
        parent::__construct($context);
        $this->PageFactory = $pageFactory;
        $this->groupCat = $groupCat;
    }

    /**
     * @return void
     */
    public function execute()
    {
        echo "Lấy dữ liệu từ bảng tigren_customer_group_catalog";
        $this->groupCat->create();
        $collection = $this->groupCat->create()
            ->addFieldToSelect(['rule_id', 'name', 'discount_amount', 'start_time', 'time_end', 'customer_group_ids', 'store_ids', 'product_ids', 'priority', 'active', 'created_at'])
            ->addFieldToFilter('active', 1);
        echo '<pre>';
        print_r($collection->getData());
        echo '<pre>';
    }
}
