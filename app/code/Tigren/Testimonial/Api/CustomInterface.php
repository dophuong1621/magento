<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Api;
interface CustomInterface
{
    /**
     * GET for Post api
     * @param string $title
     * @return string
     */
    public function getPost($title);

    /**
     * @return string
     */
    public function getData();

    /**
     * @param int $id
     * @return bool true on success
     */
    public function getDelete($id);

    /**
     * @param int $id
     * @return string
     */
    public function getById($id);

    /**
     * GET for Post api
     * @param string $title
     * @return string
     */
    public function getEdit($title);
}
