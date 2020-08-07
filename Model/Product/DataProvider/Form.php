<?php
/**
 * @author MagePrakash Team
 * @copyright Copyright (c) 2020 MagePrakash (http://www.mageprakash.com/)
 * @package MagePrakash_ProductAttachment
 */

namespace MagePrakash\ProductAttachment\Model\Product\DataProvider;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use MagePrakash\ProductAttachment\Model\Product\DataProvider\Modifiers\Data;
use MagePrakash\ProductAttachment\Model\Product\DataProvider\Modifiers\Meta;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\DB\Helper as DbHelper;
use Magento\Catalog\Model\Category as CategoryModel;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Framework\AuthorizationInterface;

class Form extends AbstractModifier
{
    /**
     * @var Modifiers\Data
     */
    private $dataModifier;
 /**#@+
     * Category tree cache id
     */
    const CATEGORY_TREE_ID = 'CATALOG_PRODUCT_CATEGORY_TREE';
    /**#@-*/

    /**
     * @var CategoryCollectionFactory
     * @since 101.0.0
     */
    protected $categoryCollectionFactory;

    /**
     * @var DbHelper
     * @since 101.0.0
     */
    protected $dbHelper;

    /**
     * @var array
     * @deprecated 101.0.0
     * @since 101.0.0
     */
    protected $categoriesTrees = [];

    /**
     * @var LocatorInterface
     * @since 101.0.0
     */
    protected $locator;

    /**
     * @var UrlInterface
     * @since 101.0.0
     */
    protected $urlBuilder;

    /**
     * @var ArrayManager
     * @since 101.0.0
     */
    protected $arrayManager;

    /**
     * @var CacheInterface
     */
    private $cacheManager;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var AuthorizationInterface
     */
    private $authorization;
    public function __construct(
        Meta $metaModifier,
        Data $dataModifier,
           LocatorInterface $locator,
        CategoryCollectionFactory $categoryCollectionFactory,
        DbHelper $dbHelper,
        UrlInterface $urlBuilder,
        ArrayManager $arrayManager,
        SerializerInterface $serializer = null,
        AuthorizationInterface $authorization = null
    ) {
        $this->metaModifier = $metaModifier;
        $this->dataModifier = $dataModifier;

          $this->locator = $locator;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->dbHelper = $dbHelper;
        $this->urlBuilder = $urlBuilder;
        $this->arrayManager = $arrayManager;
        $this->serializer = $serializer ?: ObjectManager::getInstance()->get(SerializerInterface::class);
        $this->authorization = $authorization ?: ObjectManager::getInstance()->get(AuthorizationInterface::class);
    }

      /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        return $this->metaModifier->execute($meta);
    }

    public function modifyData(array $data)
    {
        return $this->dataModifier->execute($data);
    }
}
