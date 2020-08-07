/*
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

define([
    'Magento_Ui/js/form/element/multiselect',
    'underscore'
], function (Multiselect, _) {

    return Multiselect.extend({
        validate: function () {
            if (!this.disabled()) {
                this.source.set(this.dataScope + '_output', this.value().join(','));
            }
        }
    });
});
