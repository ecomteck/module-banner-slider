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

namespace Ecomteck\Bannerslider\Controller\Adminhtml\Banner;

use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * ExportXml action
 * @category Ecomteck
 * @package  Ecomteck_Bannerslider
 * @module   Bannerslider
 * @author   Ecomteck Developer
 */
class ExportXml extends \Ecomteck\Bannerslider\Controller\Adminhtml\Banner
{
    public function execute()
    {
        $fileName = 'banners.xml';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Ecomteck\Bannerslider\Block\Adminhtml\Banner\Grid')->getXml();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
