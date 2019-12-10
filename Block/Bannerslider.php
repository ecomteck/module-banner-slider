<?php

/**
 * Ecomteck
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Ecomteck.com license that is
 * available through the world-wide-web at this URL:
 * http://www.ecomteck.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Ecomteck
 * @package     Ecomteck_Bannerslider
 * @copyright   Copyright (c) 2019 Ecomteck (http://www.ecomteck.com/)
 * @license     http://www.ecomteck.com/license-agreement.html
 */

namespace Ecomteck\Bannerslider\Block;

use Ecomteck\Bannerslider\Model\Slider as SliderModel;
use Ecomteck\Bannerslider\Model\Status;

/**
 * Bannerslider Block
 * @category Ecomteck
 * @package  Ecomteck_Bannerslider
 * @module   Bannerslider
 * @author   Ecomteck Developer
 */
class Bannerslider extends \Magento\Framework\View\Element\Template
{
    /**
     * banner slider template
     * @var string
     */
    protected $_template = 'Ecomteck_Bannerslider::bannerslider.phtml';

    /**
     * Registry object.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * slider collecion factory.
     *
     * @var \Ecomteck\Bannerslider\Model\ResourceModel\Slider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * scope config.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * [__construct description].
     *
     * @param \Magento\Framework\View\Element\Template\Context                $context
     * @param \Magento\Framework\Registry                                     $coreRegistry
     * @param \Ecomteck\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Ecomteck\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Magento\Catalog\Model\CategoryFactory                          $categoryFactory
     * @param \Magento\Store\Model\StoreManagerInterface                      $storeManager
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Ecomteck\Bannerslider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Ecomteck\Bannerslider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $coreRegistry;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;

        $this->_scopeConfig = $context->getScopeConfig();
        $this->_storeManager = $context->getStoreManager();
    }

    /**
     * @return
     */
    protected function _toHtml()
    {
        $store = $this->_storeManager->getStore()->getId();

        if ($this->_scopeConfig->getValue(
            SliderModel::XML_CONFIG_BANNERSLIDER, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store
        )
        ) {
            return parent::_toHtml();
        }

        return '';
    }

    /**
     * add child block slider.
     *
     * @param \Ecomteck\Bannerslider\Model\ResourceModel\Slider\Collection $sliderCollection [description]
     *
     * @return \Ecomteck\Bannerslider\Block\Bannerslider [description]
     */
    public function appendChildBlockSliders(
        \Ecomteck\Bannerslider\Model\ResourceModel\Slider\Collection $sliderCollection
    ) {
        foreach ($sliderCollection as $slider) {
            $this->append(
                $this->getLayout()->createBlock(
                    'Ecomteck\Bannerslider\Block\SliderItem'
                )->setSliderId($slider->getId())
            );
        }

        return $this;
    }

    /**
     * set position for banner slider.
     *
     * @param mixed string|array $position
     */
    public function setPosition($position)
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }

    /**
     * set position for banner slider.
     *
     * @param mixed string|array $position
     */
    public function setCategoryPosition($position)
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $category = $this->_coreRegistry->registry('current_category');
        if (!is_null($category)) {
            $categoryPathIds = $category->getPathIds();
    
            foreach ($sliderCollection as $slider) {
                $sliderCategoryIds = explode(',', $slider->getCategoryIds());
                if (count(array_intersect($categoryPathIds, $sliderCategoryIds)) > 0) {
                    $this->append(
                        $this->getLayout()->createBlock(
                            'Ecomteck\Bannerslider\Block\SliderItem'
                        )->setSliderId($slider->getId())
                    );
                }
            }
        }
        return $this;
    }

    /**
     * set position for note.
     */
    public function setPositionNote()
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('style_content', SliderModel::STYLE_CONTENT_YES)
            ->addFieldToFilter('style_slide', SliderModel::STYLESLIDE_SPECIAL_NOTE)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);

        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }

    /**
     * set popup on home page.
     */
    public function setPopupOnHomePage()
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('style_content', SliderModel::STYLE_CONTENT_YES)
            ->addFieldToFilter('style_slide', SliderModel::STYLESLIDE_POPUP)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }
}
