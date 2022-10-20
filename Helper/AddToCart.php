<?php

namespace Minisport\CatalogWidget\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class AddToCart extends AbstractHelper
{
	/**
	 * @var array
	 */
	private $productId = [];

	/**
	 * @param int $productId
	 */
    public function addProduct(int $productId): void
    {
    	if (!in_array($productId, $this->productId)) {
    		$this->productId[] = $productId;
    	}
    }

    public function getProductIds(): array
    {
    	return $this->productId;
    }
}
