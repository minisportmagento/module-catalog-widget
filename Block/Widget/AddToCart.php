<?php

namespace Minisport\CatalogWidget\Block\Widget;

use Magento\Framework\View\Element\Template;

class AddToCart extends Template implements \Magento\Widget\Block\BlockInterface
{
    protected $_template = 'Minisport_CatalogWidget::add_to_cart.phtml';

    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
}
