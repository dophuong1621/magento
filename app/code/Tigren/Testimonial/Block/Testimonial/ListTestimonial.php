<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Block\Testimonial;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Tigren\Testimonial\Model\TestimonialFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Tigren\Testimonial\Model\ResourceModel\Testimonial\Collection;
use Tigren\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;

/**
 * Class ListTestimonial
 * @package Tigren\Testimonial\Block\Testimonial
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
     * @var TestimonialFactory
     */
    protected $testimonialFactory;

    /**
     * @param Context $context
     * @param CollectionFactory $testimonial
     * @param ResourceConnection $resource
     * @param TestimonialFactory $testimonialFactory
     * @param array $data
     */
    public function __construct(
        Context            $context,
        CollectionFactory  $testimonial,
        ResourceConnection $resource,
        TestimonialFactory $testimonialFactory,
        array              $data = []
    )
    {
        $this->_testimonial = $testimonial;
        $this->_resource = $resource;
        $this->testimonialFactory = $testimonialFactory;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * @return AbstractDb|AbstractCollection
     */
    protected function _getTestimonialCollection()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->testimonialFactory->create()->getCollection();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }

    /**
     * @return AbstractCollection|AbstractDb
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

        return $this->getUrl('testimonial/testimonial/index', ['id' => $testimonial->getId()]);
    }

    /**
     * @return $this|ListTestimonial
     * @throws LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->_getTestimonialCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->_getTestimonialCollection()
                );
            $this->setChild('pager', $pager);
            $this->_getTestimonialCollection()->load();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
