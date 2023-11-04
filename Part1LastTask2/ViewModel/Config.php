<?php
namespace Perspective\Part1LastTask2\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Config implements ArgumentInterface
{
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    private $_productFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $_registry;

    /**
     * @var \Magento\CatalogRule\Model\RuleFactory
     */
    private $_ruleFactory;

    /**
     * @var \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory
     */
    private $_catalogRuleCollectionFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $_timezone;

    public function __construct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Registry $registry,
        \Magento\CatalogRule\Model\RuleFactory $ruleFactory,
        \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory $catalogRuleCollectionFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
    )

    {
        $this->_productFactory = $productFactory;
        $this->_registry = $registry;
        $this->_ruleFactory = $ruleFactory;
        $this->_catalogRuleCollectionFactory = $catalogRuleCollectionFactory;
        $this->_timezone = $timezone;
    }

    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    public function getMinEndTime()
    {
        $_product = $this->_productFactory->create()->load($this->getCurrentProduct()->getId()); 
        $specialToDate = $_product->getSpecialtoDate(); 
        return $specialToDate;
    }

    public function _printAllCatalogPriceRules(){
        $currentDateTime = $this->_timezone->date()->format('Y-m-d H:i:s');
        $ruleCollection = $this->_catalogRuleCollectionFactory
        ->create()
        ->addFieldToFilter('is_active', 1)
        ->addFieldToFilter('from_date', ['lteq' => $currentDateTime])
        ->addFieldToFilter('to_date', ['gteq' => $currentDateTime])
        ->getItems();

        $firstArrayToDate = reset($ruleCollection)->getToDate();
        echo "Early Catalog Rule Price will end: " . $firstArrayToDate  . "<br>";

        foreach ($ruleCollection as $ruleItem) {
            echo "Catalog rule Price №" . $ruleItem->getId() 
            . " will end: " . $ruleItem->getToDate() . "<br>";
        }
    }

    public function getAllCatalogPriceRules(){
        $currentDateTime = $this->_timezone->date()->format('Y-m-d H:i:s');
        $ruleCollection = $this->_catalogRuleCollectionFactory
        ->create()
        ->addFieldToFilter('is_active', 1)
        ->addFieldToFilter('from_date', ['lteq' => $currentDateTime])
        ->addFieldToFilter('to_date', ['gteq' => $currentDateTime])
        ->getItems();

        $firstArrayToDate = reset($ruleCollection)->getToDate();
        return $firstArrayToDate;
    }

    public function countdownDate(){
        if ($this->getAllCatalogPriceRules() > $this->getMinEndTime()){
            return $this->getMinEndTime();
        }else{
            return $this->getAllCatalogPriceRules();
        }
    }

/*     public function getCatalogPriceRuleDates($ruleId){

        $startDate = $this->_ruleFactory->create()->load($ruleId)->getFromDate();
        $endDate = $this->_ruleFactory->create()->load($ruleId)->getToDate();

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    } */
}
