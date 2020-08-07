/*
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

define([
    'Magento_Ui/js/form/element/file-uploader',
    'underscore',
    'uiRegistry',
    'jquery',
    'prototype',
], function (fileUploader, _, registry,$) {
    return fileUploader.extend({
        getFilePreviewType: function (file) {
            if (!_.isUndefined(file.previewUrl)) {
                return 'image';
            }

            return this._super();
        },
        getFileLink: function(file) {
            return file.url;
        },
        getFilePreview: function (file) {
            if (!_.isUndefined(file.previewUrl)) {
                return file.previewUrl;
            }

            return file.url;
        },
        addFile: function (file) {

            var fileNameField = registry.get(this.parentName + '.filename_container.filename'),
                labelField = registry.get(this.parentName + '.label');

            if (typeof fileNameField !== 'undefined' && !fileNameField.value()) {
                fileNameField.value(file.filename);
            }
            if (typeof labelField !== 'undefined' && !labelField.value()) {
                labelField.value(file.filename);
            }
            if(registry.get('index = icon_id'))
            {
                var field1 = registry.get('index = icon_id');
                if(file.icon_id != "")
                {
                    field1.value(file.icon_id);
                }else{
                    field1.value(file.icon_id);
                }
            }
            
            this._super();
        }
    })
});
