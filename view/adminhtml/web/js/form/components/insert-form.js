/*
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

define([
    'Magento_Ui/js/form/components/insert-form',
     'uiRegistry'
], function (Insert,registry) {
    'use strict';

    return Insert.extend({
        defaults: {
            listens: {
                responseData: 'onResponse'
            },
            modules: {
                addressListing: '${ $.attachmentListingProvider }',
                addressModal: '${ $.attachmentModalProvider }'
            }
        },

        /**
         * Close modal, reload customer address listing and save customer address
         *
         * @param {Object} responseData
         */
        onResponse: function (responseData) {
            console.log(responseData);
            if (!responseData.error) {
                    registry.async('index = productattachments')(function (filesContainer) {
                            var data = _.clone(filesContainer.cacheGridData);

                            data[data.length] = {
                                attachment_id: responseData.data.attachment_id,
                                filename: responseData.data.filename,
                                is_enable: responseData.data.is_enable,
                                customer_groups: responseData.data.customer_groups,
                                icon_image_src: responseData.data.icon_image
                            };

                            filesContainer.insertData(data);
                            this.newFilesCounter += 1;
                    }.bind(this));
                    this.addressModal().closeModal();
            }
        }
    });
});
