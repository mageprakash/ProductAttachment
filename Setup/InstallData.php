<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
	protected $_iconFactory;

	public function __construct(\MagePrakash\ProductAttachment\Model\IconFactory $iconFactory)
	{
		$this->_iconFactory = $iconFactory;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$iconList = [
			'jpg' => [
			    'filename' => 'jpg.svg',
			    'extensions' => [
			        'jpg',
			        'jpeg'
			    ]
			],
			'pdf' => [
			    'filename' => 'pdf.svg',
			    'extensions' => [
			        'pdf'
			    ]
			],
			'png' => [
			    'filename' => 'png.svg',
			    'extensions' => [
			        'png'
			    ]
			],
			'txt' => [
			    'filename' => 'txt.svg',
			    'extensions' => [
			        'txt'
			    ]
			],
			'xml' => [
			    'filename' => 'xml.svg',
			    'extensions' => [
			        'xml'
			    ]
			],
			'zip' => [
			    'filename' => 'zip.svg',
			    'extensions' => [
			        'zip'
			    ]
			],'doc' => [
			    'filename' => 'document.svg',
			    'extensions' => [
			        'doc,docx'
			    ]
			],
			'csv' => [
			    'filename' => 'csv.svg',
			    'extensions' => [
			        'csv'
			    ]
			],
			'json' => [
			    'filename' => 'json.svg',
			    'extensions' => [
			        'json'
			    ]
			],
			'mp3' => [
			    'filename' => 'mp3.svg',
			    'extensions' => [
			        'mp3'
			    ]
			],
			'mp4' => [
			    'filename' => 'mp4.svg',
			    'extensions' => [
			        'mp4'
			    ]
			]
		];
		
		foreach ($iconList as $key => $value) {
			try {
				$icon = $this->_iconFactory->create();
				$data = [
							'image'			 => $value['filename'],
							'is_active'		 => 1,
							'icon_extension' => implode(",", $value['extensions'])
						];
                $icon->addData($data)->save();
            } catch (\Magento\Framework\Exception\CouldNotSaveException $e) {

            }
		}
	}
}