<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\GroupCat;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Controller\Result\Redirect;
use Tigren\CustomerGroupCatalog\Model\GroupCat;

/**
 * Class Save
 * @package Tigren\CustomerGroupCatalog\Controller\Adminhtml\Post
 */
class Save extends Action
{
    /**
     * @var ResourceConnection
     */
    private ResourceConnection $connection;
    /**
     * @var GroupCat
     */
    private GroupCat $groupCatFactory;

    /**
     * Save constructor.
     * @param Context $context
     * @param GroupCat $groupCatFactory
     */
    public function __construct(
        Context            $context,
        GroupCat           $groupCatFactory,
        ResourceConnection $connection,
    )
    {
        parent::__construct($context);
        $this->groupCatFactory = $groupCatFactory;
        $this->connection = $connection;
    }

    /**
     * @return Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
//        echo "<pre>";
//        print_r($data);
//        die();
//        $dataStore = implode(',', $data['store']);
//        echo "<pre>";
//        print_r($dataStore);
//        exit;
        $id = !empty($data['rule_id']) ? $data['rule_id'] : null;

        $groupCatData = [
            'name' => $data['name'],
            'discount_amount' => $data['discount_amount'],
            'customer_group_ids' => implode(',', $data['customer_group_ids']),
            'store_ids' => implode(',', $data['store_ids']),
            'product_ids' => $data['product_ids'],
            'start_time' => $data['start_time'],
            'time_end' => $data['time_end'],
            'priority' => $data['priority'],
            'active' => $data['active'],
        ];
        $groupCatFactory = $this->groupCatFactory;
        if ($id) {
            $groupCatFactory->load($id);
        }
        try {
            $groupCatFactory->addData($groupCatData);
            $groupCatFactory->save();
//            $idNew = $groupCatFactory->getData('rule_id');
//            $connect = $this->connection->getConnection();

//            //  Customer Group
//            $tableCustomerGroup = $connect->getTableName('tigren_groupcat_customer_group');
//            foreach ($data['customer_group'] as $customerGroup) {
//                $connect->insert($tableCustomerGroup, [
//                    'customer_rule_id' => $idNew,
//                    'customer_group_id' => $customerGroup
//                ]);
//            }
//
//            // Store
//            $tableStore = $connect->getTableName('tigren_groupcat_store');
//            foreach ($data['store'] as $store) {
//                $connect->insert($tableStore, [
//                    'customer_rule_id' => $idNew,
//                    'store_id' => $store
//                ]);
//            }
//
//            // Products
//            $tableProduct = $connect->getTableName('tigren_groupcat_product');
////            foreach ($data['products'] as $products) {
//            $connect->insert($tableProduct, [
//                'customer_rule_id' => $idNew,
//                'product_sku' => $data['product_sku'],
//            ]);
//            }

            $this->messageManager->addSuccessMessage(__('You saved the post.'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        return $this->resultRedirectFactory->create()->setPath('groupcat/groupcat/index');
    }
}
