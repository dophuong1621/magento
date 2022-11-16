<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class GroupCat
 * @package Tigren\AdvancedCheckout\Model
 */
class CustomerEntity extends AbstractModel
{
    /**
     *
     */
    const ENTITY_ID = 'entity_id';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'checkout';

    /**
     * Name of the event object
     *
     * @var string
     */
    protected $_eventObject = 'checkout';

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = self::ENTITY_ID;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Tigren\AdvancedCheckout\Model\ResourceModel\CustomerEntity');
    }
}
