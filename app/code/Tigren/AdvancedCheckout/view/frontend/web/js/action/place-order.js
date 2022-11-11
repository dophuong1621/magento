/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

/**
 * @api
 */
define([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/place-order',
], function (quote, urlBuilder, customer, placeOrderService, $) {
    'use strict';


    return function (paymentData, messageContainer) {
        var serviceUrl, payload;
        payload = {
            cartId: quote.getQuoteId(),
            billingAddress: quote.billingAddress(),
            paymentMethod: paymentData
        };

        if (customer.isLoggedIn()) {
            serviceUrl = urlBuilder.createUrl('/carts/mine/payment-information', {});
        } else {
            serviceUrl = urlBuilder.createUrl('/guest-carts/:quoteId/payment-information', {
                quoteId: quote.getQuoteId()
            });
            payload.email = quote.guestEmail;
        }
        return function placeOrderService(serviceUrl, payload, messageContainer, $) {
            require(['jquery'], function ($) {
                $.ajax({
                    url: 'checkout/placeorder/placeorder',
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response.result);
                        if (response.result === false) {
                            var popup = $('<div class="add-to-cart-modal-popup"/>').html('<span> You have an order that is not complete. Please wait to complete the order before creating a new order.</span>').modal({
                                modalClass: 'add-to-cart-popup',
                                title: $.mage.__("Warning !!"),
                                buttons: [
                                    {
                                        text: 'Close',
                                        click: function () {
                                            popup.modal('closeModal');
                                        }
                                    }
                                ]
                            });
                            popup.modal('openModal');
                        }
                    },
                });
            })
        };
    };
});
