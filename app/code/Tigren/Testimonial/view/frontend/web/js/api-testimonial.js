/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */
define([
    'ko',
    'jquery',
    'mage/url',
], function (
    ko,
    $,
    urlBuilder,
) {
    'use strict';
    $(document).ready(function () {
        //create
        $('#submit').on('click', function () {
            var formData = new FormData($("#question-form")[0]);
            formData = JSON.stringify(Object.fromEntries(formData));
            $('body').trigger('processStart');
            $.ajax({
                type: "POST",
                url: urlBuilder.build("/V1/custom/getdata"),
                data: formData,
                dataType: 'json',
                contentType: 'application/json',
                success: function () {
                    $('body').trigger('processStop');
                    alert("Success");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('body').trigger('processStop');
                    alert("Errordffs");
                },
            });
        });

        //delete
        $('.delete').on('click', function () {
            var id = $('.id').text();
            $.ajax({
                type: "POST",
                url: urlBuilder.build("rest/V1/custom/delete/" + id),
                data: {
                    id: id,
                },
                dataType: 'json',
                contentType: 'application/json',
                success: function () {
                    alert("Success");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert("Error");
                },
            });
        });
    })

})

