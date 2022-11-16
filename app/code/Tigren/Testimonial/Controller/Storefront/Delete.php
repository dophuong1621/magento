<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Controller\Storefront;

use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Tigren\Testimonial\Model\TestimonialFactory;

/**
 * Class Delete
 * @package Tigren\Testimonial\Controller\Storefront
 */
class Delete extends Action
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;
    /**
     * @var Http
     */
    protected $_request;
    /**
     * @var TestimonialFactory
     */
    protected $_contactFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Http $request
     * @param TestimonialFactory $contactFactory
     */
    public function __construct(
        Context            $context,
        PageFactory        $pageFactory,
        Http               $request,
        TestimonialFactory $contactFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_request = $request;
        $this->_contactFactory = $contactFactory;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     */
    public function execute()
    {
        $id = $this->_request->getParam('id');
        $postData = $this->_contactFactory->create()->load($id);
        $postData->getData('entity_id');
        $postData->delete();
        return $this->_redirect('testimonial/storefront/index');
    }
}