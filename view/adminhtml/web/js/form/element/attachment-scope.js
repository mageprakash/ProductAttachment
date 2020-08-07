/*
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select',
    'Magento_Ui/js/modal/modal',
    'jquery'    
], function (_, uiRegistry, select, modal,$) {
    'use strict';

    return select.extend({

        /**
         * On value change handler.
         *
         * @param {String} value
         */
        onUpdate: function (value) {
            console.log('Selected Value: ' + value);
        
    
            if(value == 1) {
                $('div[data-index="additional"]').show();
                $('div[data-index="conditions"]').hide();
            } else if(value == 2) {
                $('div[data-index="additional"]').hide();
                $('div[data-index="conditions"]').show();
            } else if(value == 3) {
                $('div[data-index="additional"]').show();
                $('div[data-index="conditions"]').show();                
            }

            return this._super();
        }/*,
        setInitialValue: function () {
                if (this.value()){
                        var value = this.value();
                        console.log(value);
                        if(value == 1) {
                            $('div[data-index="additional"]').show();
                            $('div[data-index="conditions"]').hide();
                        } else if(value == 2) {
                            $('div[data-index="additional"]').hide();
                            $('div[data-index="conditions"]').show();
                        } else if(value == 3) {
                            $('div[data-index="additional"]').show();
                            $('div[data-index="conditions"]').show();                
                        }
                }
                 return this._super();
        }*/
    });
});