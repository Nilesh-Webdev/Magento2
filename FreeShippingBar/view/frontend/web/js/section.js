define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (Component, customerData) {
    'use strict';

    return Component.extend({
    	initialize: function () {
        	this._super();
        	this.rvsshippingpromotion = customerData.get('rvs_shipping_promotion');
    	}
    });
});
