<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model;

use MagePrakash\ProductAttachment\Model\ResourceModel\Attachment\CollectionFactory;
use Magento\Framework\App\RequestInterface;

class InsertListing extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;

    /**
     * @var GetIconForFile
     */
    private $getIconForFile;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var int
     */
    private $totalRecordPlus;

    public function __construct(
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
}
