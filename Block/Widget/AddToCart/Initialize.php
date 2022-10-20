<?php

namespace Minisport\CatalogWidget\Block\Widget\AddToCart;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Helper\Cart as CartHelper;
use Minisport\CatalogWidget\Helper\AddToCart as Helper;

class Initialize extends Template
{
    /**
     * {@inheritdoc}
     */
    protected $_template = 'add_to_cart/initialize.phtml';

    /**
     * @var CartHelper
     */
    private $cartHelper;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        CartHelper $cartHelper,
        Helper $helper,
        ProductRepositoryInterface $productRepo,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Template\Context $context,
        array $data = []
    ) {
        $this->cartHelper = $cartHelper;
        $this->helper = $helper;
        $this->productRepo = $productRepo;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    /**
     * Get array of products requested for add to cart widget.
     *
     * @return array
     */
    public function getProducts(): array
    {
        $productIds = $this->helper->getProductIds();
        if (!$productIds) {
            return [];
        }

        $criteria = $this->searchCriteriaBuilder
            ->addFilter('entity_id', implode(',', $productIds), 'in')
            ->create();
        $products = $this->productRepo->getList($criteria)->getItems();

        return $products ?: [];
    }

    public function getProductsAsJson(): string
    {
        $products = $this->getProducts();
        if (!$products) {
            return '';
        }

        $data = array_map(function ($product) {
            return [
                'id' => $product->getId(),
                'isAvailable' => $product->isAvailable(),
                'urlAddToCart' => $product->isAvailable() ? $this->cartHelper->getAddUrl($product) : false
            ];
        }, $products);

        return json_encode(array_values($data));
    }
}
