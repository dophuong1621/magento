<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Api;

/**
 *
 */
interface CustomInterface
{
    /**
     * @param string $data
     * @return mixed
     */
    public function saveTestimonial($data);

    /**
     * @return mixed
     */
    public function deleteTestimonial(int $id);
}
