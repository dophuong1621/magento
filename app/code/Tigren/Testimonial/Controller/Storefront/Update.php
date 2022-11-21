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
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Tigren\Testimonial\Model\TestimonialFactory;

/**
 * Class Update
 * @package Tigren\Testimonial\Controller\Storefront
 */
class Update extends Action
{
    /**
     * @var TestimonialFactory
     */
    protected $testimonialFactory;

    /**
     * @var
     */
    protected $session;

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @param TestimonialFactory $testimonialFactory
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        TestimonialFactory $testimonialFactory,
        Context            $context,
        PageFactory        $pageFactory,

    )
    {
        $this->testimonialFactory = $testimonialFactory;
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * @return Page|Redirect|ResultInterface
     * @throws Exception
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $id = $data['id'];
        $newData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
            'company' => $data['company'],
            'rating' => $data['rating'],
            'status' => $data['status'],
        ];

        $post = $this->testimonialFactory->create()->load($id);
        if (isset($newData)) {
            $post->setData($newData);
            $post->save();
            $this->messageManager->addSuccessMessage(__('You update the question success.'));
            $resutl = $this->resultRedirectFactory->create()->setPath('testimonial/storefront/index');
        } else {
            $this->messageManager->addErrorMessage('Error');
            return $this->pageFactory->create();
        }
        return $resutl;
    }
}
