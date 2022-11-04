<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\DataObject;

/**
 * Class Test
 * @package Tigren\CustomerGroupCatalog\Controller\Index
 */
class Test extends Action
{
    /**
     * @return void
     */
    public function execute()
    {
        $textDisplay = new DataObject(['text' => 'Tigren']);
        $this->_eventManager->dispatch('tigren_groupcat_display_text', ['mp_text' => $textDisplay]);
        echo $textDisplay->getText();
        exit;
    }
}

