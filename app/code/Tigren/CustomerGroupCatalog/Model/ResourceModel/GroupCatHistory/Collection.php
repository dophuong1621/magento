<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Model\ResourceModel\GroupCatHistory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Tigren\CustomerGroupCatalog\Model\GroupCatHistory;

/**
 * Class Collection
 * @package Tigren\CustomerGroupCatalog\Model\ResourceModel\GroupCat
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = GroupCatHistory::GROUPCATHISTORY_ID;

    /**
     * @param bool|int $strDateCurrent
     * @param array $array
     * @return void
     */
    public function addAttributeToFilter(bool|int $strDateCurrent, array $array)
    {
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Tigren\CustomerGroupCatalog\Model\GroupCatHistory', 'Tigren\CustomerGroupCatalog\Model\ResourceModel\GroupCatHistory');
    }

}
