<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\HelloWorld\Model\Api\Data;
/**
 *
 */
interface TopicInterface
{
    /**
     * @return mixed
     */
    public function getId(): mixed;

    /**
     * @return mixed
     */
    public function setId(): mixed;

    /**
     * @return mixed
     */
    public function getTitle(): mixed;

    /**
     * @return mixed
     */
    public function setTitle(): mixed;

    /**
     * @return mixed
     */
    public function getContent(): mixed;

    /**
     * @return mixed
     */
    public function setContent(): mixed;

    /**
     * @return mixed
     */
    public function getCreationTime(): mixed;

    /**
     * @return mixed
     */
    public function setCreationTime(): mixed;
}
