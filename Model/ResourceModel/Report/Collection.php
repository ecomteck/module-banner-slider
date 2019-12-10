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

namespace Ecomteck\Bannerslider\Model\ResourceModel\Report;

/**
 * Report Collection
 * @category Ecomteck
 * @package  Ecomteck_Bannerslider
 * @module   Bannerslider
 * @author   Ecomteck Developer
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    const REPORT_TYPE_ALL_SLIDER = '1';
    const REPORT_TYPE_PER_SLIDER = '2';

    protected function _construct()
    {
        $this->_init('Ecomteck\Bannerslider\Model\Report', 'Ecomteck\Bannerslider\Model\ResourceModel\Report');
    }

    /**
     * load slider and banner information to report
     */
    public function reportClickAndImpress($reportType)
    {
        $this->getSelect()->joinLeft(
            ['table_banner' => $this->getTable('ecomteck_bannerslider_banner')],
            'main_table.banner_id = table_banner.banner_id',
            ['banner_name' => 'table_banner.name', 'banner_url' => 'table_banner.click_url']
        )->joinLeft(
            ['table_slider' => $this->getTable('ecomteck_bannerslider_slider')],
            'main_table.slider_id = table_slider.slider_id',
            ['slider_title' => 'table_slider.title']
        )->columns('SUM(main_table.clicks) AS banner_click')
            ->columns('SUM(main_table.impmode) AS banner_impress');

        if ($reportType == self::REPORT_TYPE_ALL_SLIDER) {
            $this->getSelect()->group('main_table.banner_id');
        } else if ($reportType == self::REPORT_TYPE_PER_SLIDER) {
            $this->getSelect()->group('main_table.slider_id')
                ->group('main_table.banner_id');
        }

        return $this;
    }
}
