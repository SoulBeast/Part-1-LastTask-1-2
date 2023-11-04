<?php

namespace Perspective\Part1LastTask1\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\Template\Context;
use Perspective\Part1LastTask1\Helper\Data;

class Config implements ArgumentInterface
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Registry
     */
    private $_registry;

    /**
     * @var \Magento\CatalogInventory\Model\Stock\StockItemRepository
     */
    private $_stockItemRepository;

    /**
     * @var \Magento\Directory\Model\CurrencyFactory
     */
    private $_currencyFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    private $_productFactory;

    /**
     * @var \Magento\Catalog\Api\ScopedProductTierPriceManagementInterface
     */
    private $_tierPrice;

    /**
     * @var \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory
     */
    private $_ruleCollectionFactory;

    public function __construct(
        Context $context,
        Data $helper,
        \Magento\Framework\Registry $registry,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Api\ScopedProductTierPriceManagementInterface $tierPrice,
        \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory $ruleCollectionFactory
    ) {
        $this->helper = $helper;
        $this->_registry = $registry;
        $this->_stockItemRepository = $stockItemRepository;
        $this->_currencyFactory = $currencyFactory;
        $this->_storeManager = $storeManager;
        $this->_productFactory = $productFactory;
        $this->_tierPrice = $tierPrice;
        $this->_ruleCollectionFactory = $ruleCollectionFactory;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->helper->isEnabled();
    }

    public function isEnabledBasePrice()
    {
        return $this->helper->isEnabledBasePrice();
    }

    public function isEnabledFinalPrice()
    {
        return $this->helper->isEnabledFinalPrice();
    }

    public function isEnabledSpecialPrice()
    {
        return $this->helper->isEnabledSpecialPrice();
    }

    public function isEnabledTierPrice()
    {
        return $this->helper->isEnabledTierPrice();
    }

    public function isEnabledCatalogRulePrice()
    {
        return $this->helper->isEnabledCatalogRulePrice();
    }

    ### ### Current Product ### ###
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }
    ### ### Base Price ### ###
    ### Print
    public function _printBasePrice()
    {
        $forif = $this->getCurrentProduct()->getPrice();
        if (!empty($forif))
            $basePrice = round($forif,1) . " $";
        else
            $basePrice = "-";
        return $basePrice;
    }
    ### ### Final Price ### ###
    ### Print
    public function _printFinalPrice()
    {
        $forif = $this->getCurrentProduct()->getFinalPrice();
        if (!empty($forif))
            $finalPrice = round($forif,1) . " $";
        else
            $finalPrice = "-";
        return $finalPrice;
    }
    ### ### Special Price ### ###
    public function getSpecialPrice()
    {
        $_product = $this->_productFactory->create()->load($this->getCurrentProduct()->getId());
        $specialprice = $_product->getSpecialPrice();
        return $specialprice;
    }
    ### Print
    public function _printSpecialPrice()
    {
        $forif = $this->getSpecialPrice();
        if (!empty($forif))
            $specialPrice = round($forif,1) . " $";
        else
            $specialPrice = "-";
        return $specialPrice;
    }
    ### ### Tier Price ### ###
    public function getTierPrice()
    {
        $sku = $this->getCurrentProduct()->getSku();
        $customerGroupId = "all"; //you can also define 'all'
        $tierPrice = $this->_tierPrice->getList($sku, $customerGroupId);
        $tierArray = "";
        foreach($tierPrice as $TierPrices)
        {
            $tierArray = $tierArray . round($TierPrices->getValue(),1)
            . " $ for " . round($TierPrices->getQty()) . "<br>";
        }
        return $tierArray;
    }
    ### Print
    public function _printTierPrice()
    {
        $forif = $this->getTierPrice();
        if (!empty($forif))
            $tierPrice = $forif;
        else
            $tierPrice = "-";
        return $tierPrice;
    }
    ### ### Catalog Rule Price ### ###
    public function getCatalogRulePrice() 
    { 
        $product = $this->_productFactory->create()->load($this->getCurrentProduct()->getId());
        return $product->getPriceInfo()->getPrice('catalog_rule_price')->getAmount()->getValue();
    }
    ### Print
    public function _printCatalogRulePrice()
    {
        $forif = $this->getCatalogRulePrice();
        if (!empty($forif))
            $catalogrulePrice = round($forif,1) . " $";
        else
            $catalogrulePrice = "-";
        return $catalogrulePrice;
    }
}
