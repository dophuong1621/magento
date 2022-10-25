<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Model\Source\Testimonial;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Tigren\Testimonial\Model\Testimonial
     */
    protected $_testimonial;

    /**
     * Constructor
     *
     * @param \Tigren\Testimonial\Model\Testimonial $testimonial
     */
    public function __construct(\Tigren\Testimonial\Model\Testimonial $testimonial)
    {
        $this->_testimonial = $testimonial;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->_testimonial->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
