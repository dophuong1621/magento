<?php

namespace Tigren\CustomerGroupCatalog\Pricing\Render;

use Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface;
use Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface;
use Magento\Customer\Model\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Pricing\Price\PriceInterface;
use Magento\Framework\Pricing\Render\RendererPool;
use Magento\Framework\Pricing\SaleableInterface;

/**
 * Class FinalPriceBox
 * @package Tigren\CustomerGroupCatalog\Pricing\Render
 */
class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param SaleableInterface $saleableItem
     * @param PriceInterface $price
     * @param RendererPool $rendererPool
     * @param array $data
     * @param SalableResolverInterface|null $salableResolver
     * @param MinimalPriceCalculatorInterface|null $minimalPriceCalculator
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        SaleableInterface                                $saleableItem,
        PriceInterface                                   $price,
        RendererPool                                     $rendererPool,
        array                                            $data = [],
        SalableResolverInterface                         $salableResolver = null,
        MinimalPriceCalculatorInterface                  $minimalPriceCalculator = null
    )
    {
        parent::__construct(
            $context,
            $saleableItem,
            $price,
            $rendererPool,
            $data,
            $salableResolver,
            $minimalPriceCalculator
        );
    }

    /**
     * @param $html
     * @return string
     */
    protected function wrapResult($html)
    {
        $objectManager = ObjectManager::getInstance();
        $httpContext = $objectManager->get('Magento\Framework\App\Http\Context');
        $isLoggedIn = $httpContext->getValue(Context::CONTEXT_AUTH);
        if ($isLoggedIn) {
            return '<div class="price-box ' . $this->getData('css_classes') . '" ' .
                'data-role="priceBox" ' .
                'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                '>' . $html . '</div>';
        } else {
            $wording = 'Please Login To See Price';
            return '<div class="" ' .
                'data-role="priceBox" ' .
                'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                '>' . $wording . '</div>';
        }
    }
}
