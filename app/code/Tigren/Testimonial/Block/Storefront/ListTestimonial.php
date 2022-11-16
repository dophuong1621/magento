<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Block\Storefront;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Tigren\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;

/**
 * Class ListTestimonial
 * @package Tigren\Testimonial\Block\Storefront
 */
class ListTestimonial extends Template
{

    /**
     * @var CollectionFactory
     */
    protected $_testimonial;

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @var null
     */
    protected $_testimonialCollection = null;

    /**
     * @param Context $context
     * @param CollectionFactory $testimonial
     * @param ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
        Context            $context,
        CollectionFactory  $testimonial,
        ResourceConnection $resource,
        array              $data = []
    )
    {
        $this->_testimonial = $testimonial;
        $this->_resource = $resource;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * @return null
     */
    protected function _getTestimonialCollection()
    {
        if ($this->_testimonialCollection === null) {
            $testimonialCollection = $this->_testimonial->create()
                ->addFieldToSelect('*');

            $this->_testimonialCollection = $testimonialCollection;
        }
        return $this->_testimonialCollection;
    }

    /**
     * @return null
     */
    public function getLoadedTestimonialCollection()
    {
        return $this->_getTestimonialCollection();
    }

    /**
     * @param $testimonial
     * @return string
     */
    public function getTestimonialUrl($testimonial)
    {
        if (!$testimonial->getId()) {
            return '#';
        }

        return $this->getUrl('testimonial/storefront/index', ['id' => $testimonial->getId()]);
    }
}
