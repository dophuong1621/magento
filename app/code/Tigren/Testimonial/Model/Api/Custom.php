<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Model\Api;

use Magento\Framework\Controller\Result\RedirectFactory;
use Tigren\Testimonial\Api\CustomInterface;
use Tigren\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;
use Tigren\Testimonial\Model\TestimonialFactory;
use Zend_Log;
use Zend_Log_Writer_Stream;

/**
 * Class Custom
 * @package Tigren\AdvancedQuestion\Model\Api
 */
class Custom implements CustomInterface
{
    /**
     * @var
     */
    protected $request;
    /**
     * @var TestimonialFactory
     */
    private TestimonialFactory $testimonialFactory;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @param TestimonialFactory $testimonialFactory
     * @param CollectionFactory $collectionFactory
     * @param RedirectFactory $resultRedirectFactory
     */

    public function __construct(
        TestimonialFactory $testimonialFactory,
        CollectionFactory  $collectionFactory,
        RedirectFactory    $resultRedirectFactory,
    )
    {
        $this->testimonialFactory = $testimonialFactory;
        $this->collectionFactory = $collectionFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function saveTestimonial($data)
    {
        $writer = new Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new Zend_Log();
        $logger->addWriter($writer);
        $logger->info(print_r($data));
        $logger->info(print_r(json_decode($data, true)));

        $formData = json_decode($data, true);
        $newData = [
            'name' => $formData['name'],
            'email' => $formData['email'],
            'message' => $formData['message'],
            'company' => $formData['company'],
            'rating' => $formData['rating'],
            'status' => $formData['status'],
        ];

        if ($formData['id'] > 0) {
            $update = $this->testimonialFactory->create()->load($formData['id']);
            $update->setData($newData);
            $update->save();
//            return $this->resultRedirectFactory->create()->setPath('testimonial/storefront/index');
        } else {
            $create = $this->testimonialFactory->create();
            $create->addData($newData);
            $create->save();
//            return $this->resultRedirectFactory->create()->setPath('testimonial/storefront/index');
        }
        return "Success";
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteTestimonial(int $id)
    {
        $model = $this->testimonialFactory->create()->load($id);
        $model->delete();

//        return $this->resultRedirectFactory->create()->setPath('testimonial/storefront/index');
        return "Success";
    }
}
