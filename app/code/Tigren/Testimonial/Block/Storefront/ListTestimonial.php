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
use Tigren\Testimonial\Model\ResourceModel\Testimonial;

/**
 * Class ListTestimonial
 * @package Tigren\Testimonial\Block\Storefront
 */
class ListTestimonial extends Template
{

    /**
     * @var Testimonial
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
     * @param Testimonial $testimonial
     * @param ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
        Context            $context,
        Testimonial        $testimonial,
        ResourceConnection $resource,
        array              $data = []
    ) {
        $this->_testimonial = $testimonial;
        $this->_resource = $resource;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        // You can put these informations editable on BO
        $title = __('We are hiring');
        $description = __('Look at the testimonial we have got for you');
        $keywords = __('testimonial,hiring');

        $this->getLayout()->createBlock('Magento\Catalog\Block\Breadcrumbs');

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'testimonial',
                [
                    'label' => $title,
                    'title' => $title,
                    'link' => false // No link for the last element
                ]
            );
        }

        $this->pageConfig->getTitle()->set($title);
        $this->pageConfig->setDescription($description);
        $this->pageConfig->setKeywords($keywords);

        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle($title);
        }

        return $this;
    }

    /**
     * @return null
     */
    protected function _getTestimonialCollection()
    {
        if ($this->_testimonialCollection === null) {
            $testimonialCollection = $this->_testimonial->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('status', $this->_testimonial->getEnableStatus());
//                ->join(
//                    array('department' => $this->_department->getResource()->getMainTable()),
//                    'main_table.department_id = department.'.$this->_testimonial->getIdFieldName(),
//                    array('department_name' => 'name')
//                );

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

        return $this->getUrl('testimonial/testimonial/view', ['id' => $testimonial->getId()]);
    }
}
