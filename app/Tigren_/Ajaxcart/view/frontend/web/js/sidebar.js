define([
    'jquery',
    'Magento_Customer/js/model/authentication-popup',
    'Magento_Customer/js/customer-data',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/confirm',
    'jquery/ui',
    'mage/decorate',
    'mage/collapsible',
    'mage/cookies',
    'Magento_Checkout/js/sidebar',
    
], function ($, authenticationPopup, customerData, alert, confirm) {
    'use strict';
    $.widget('tigren.sidebar', $.mage.sidebar, {
        _removeItem: function (elem) {
            var itemId = elem.data('cart-item');
            $('body').trigger('processStart');
            this._ajax(this.options.url.remove, {
                item_id: itemId
            }, elem, this._removeItemAfter);
        },

        _removeItemAfter: function (elem, response) {
            $('body').trigger('processStop');
        },
        
        _calcHeight: function () {
            
        }
    });

    return $.tigren.sidebar;
});