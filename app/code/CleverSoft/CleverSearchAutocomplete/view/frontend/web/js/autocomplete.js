/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

define([
    'jquery',
    'uiComponent',
    'ko'
], function ($, Component, ko) {
    'use strict';


    return Component.extend({
        defaults: {
            template: 'CleverSoft_CleverSearchAutocomplete/autocomplete',
            addToCartFormSelector: '[data-role=cleversearchautocomplete-tocart-form]',
            showPopup: ko.observable(false),
            result: {
                suggest: {
                    data: ko.observableArray([])
                },
                product: {
                    data: ko.observableArray([]),
                    size: ko.observable(0),
                    url: ko.observable('')
                }
            },
            anyResultCount: false
        },


        initialize: function () {
            var self = this;
            this._super();

            this.anyResultCount = ko.computed(function () {
                var sum = self.result.suggest.data().length + self.result.product.data().length;
                if (sum > 0) {
                    return true; }
                return false;
            }, this);
        },

    });
});
