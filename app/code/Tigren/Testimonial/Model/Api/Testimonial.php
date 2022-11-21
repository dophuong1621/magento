<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Model\Api;

use Tigren\Testimonial\Api\TestimonialInterface;
use Tigren\Testimonial\Model\TestimonialFactory;

/**
 * Class Testimonial
 * @package Tigren\AdvancedQuestion\Model\Api
 */
class Testimonial implements TestimonialInterface
{
    /**
     * @var TestimonialFactory
     */
    private $testimonialFactory;

    /**
     * @param TestimonialFactory $testimonialFactory
     */

    public function __construct(
        TestimonialFactory $testimonialFactory,
    ) {
        $this->testimonialFactory = $testimonialFactory;
    }

    /**
     * @param string $data
     * @return array
     */
    public function saveTestimonial($data)
    {
        $formData = json_decode($data, true);
        $newData = [
            'name' => $formData['name'],
            'email' => $formData['email'],
            'message' => $formData['message'],
            'company' => $formData['company'],
            'rating' => $formData['rating'],
            'status' => $formData['status'],
        ];

        if (isset($formData['id'])) {
            $testimonial = $this->testimonialFactory->create()->load($formData['id']);
            $testimonial->setData('name', $formData['name']);
            $testimonial->setData('email', $formData['email']);
            $testimonial->setData('message', $formData['message']);
            $testimonial->setData('company', $formData['company']);
            $testimonial->setData('rating', $formData['rating']);
            $testimonial->setData('status', $formData['status']);
        } else {
            $testimonial = $this->testimonialFactory->create();
            $testimonial->addData($newData);
        }

        $testimonial->save();
        return [
            'url_redirect' => '/testimonial/testimonial/index',
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteTestimonial(int $id)
    {
        $model = $this->testimonialFactory->create()->load($id);
        $model->delete();

        return [
            'url_redirect' => '/testimonial/testimonial/index'
        ];
    }
}
