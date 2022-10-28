/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

function define(strings, param2) {

}

define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total'
    ],
    function ($, Component) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Tigren_CustomerGroupCatalog/checkout/summary/customdiscount'
            },
            isDisplayedCustomdiscount: function () {
                return true;
            },
            getCustomDiscount: function () {
                return '$10';
            }
        });
    }
);
