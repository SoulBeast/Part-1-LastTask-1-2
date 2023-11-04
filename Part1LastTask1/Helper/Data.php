<?php
namespace Perspective\Part1LastTask1\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends AbstractHelper
{

    /**
     * @param Context $context
     */

    public function __construct(Context $context)
    {        
        parent::__construct($context);
    }

    public function isEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'perspective/general/module_functionality',
            $scope
        );
    }

    public function isEnabledBasePrice($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'perspective/general/base_price_show',
            $scope
        );
    }

    public function isEnabledFinalPrice($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'perspective/general/final_price_show',
            $scope
        );
    }

    public function isEnabledSpecialPrice($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'perspective/general/special_price_show',
            $scope
        );
    }

    public function isEnabledTierPrice($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'perspective/general/tier_price_show',
            $scope
        );
    }

    public function isEnabledCatalogRulePrice($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'perspective/general/catalog_rule_price_show',
            $scope
        );
    }
}