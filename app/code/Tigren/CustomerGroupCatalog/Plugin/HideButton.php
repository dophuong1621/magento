<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Plugin;


use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Context;
use Magento\Framework\App\ObjectManager;

/**
 * Class HideButton
 * @package Tigren\CustomerGroupCatalog\Plugin
 */
class HideButton
{
    /**
     * @param Product $product
     * @return string
     */
    public function afterIsSaleable(Product $product)
    {
//        return [];
        $objectManager = ObjectManager::getInstance();
        $httpContext = $objectManager->get('Magento\Framework\App\Http\Context');
        $isLoggedIn = $httpContext->getValue(Context::CONTEXT_AUTH);
        if ($isLoggedIn) {
            return true;
        } else {
            return false;
//            $wording = 'Please Login To See Price';
//            return '<div class="" ' .
//                'data-role="priceBox" ' .
//                'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
//                '>' . $wording . '</div>';
        }
    }
}
