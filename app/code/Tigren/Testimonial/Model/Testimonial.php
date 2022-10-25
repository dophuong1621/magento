<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Testimonial
 * @package Tigren\Testimonial\Model
 */
class Testimonial extends AbstractModel
{
    /**
     *
     */
    const Testimonial_ID = 'entity_id'; // We define the id fieldname

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'testimonial';

    /**
     * Name of the event object
     *
     * @var string
     */
    protected $_eventObject = 'testimonial';

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = self::Testimonial_ID;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Tigren\Testimonial\Model\ResourceModel\Testimonial');
    }

    /**
     * @return int
     */
    public function getEnableStatus()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function getDisableStatus()
    {
        return 0;
    }

    /**
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [$this->getDisableStatus() => __('Disabled'), $this->getEnableStatus() => __('Enabled')];
    }
}
