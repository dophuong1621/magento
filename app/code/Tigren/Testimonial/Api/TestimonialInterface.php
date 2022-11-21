<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Api;

/**
 * Class TestimonialInterface
 * @package TestimonialInterface
 */
interface TestimonialInterface
{
    /**
     * @param string $data
     * @return array
     */
    public function saveTestimonial($data);

    /**
     * @return array
     */
    public function deleteTestimonial(int $id);
}
