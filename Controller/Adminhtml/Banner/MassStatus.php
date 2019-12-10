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

/**
 * MassStatus action
 * @category Ecomteck
 * @package  Ecomteck_Bannerslider
 * @module   Bannerslider
 * @author   Ecomteck Developer
 */
class MassStatus extends \Ecomteck\Bannerslider\Controller\Adminhtml\Banner
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $bannerIds = $this->getRequest()->getParam('banner');
        $status = $this->getRequest()->getParam('status');
        $storeViewId = $this->getRequest()->getParam('store');

        if (!is_array($bannerIds) || empty($bannerIds)) {
            $this->messageManager->addError(__('Please select banner(s).'));
        } else {
            $bannerCollection = $this->_bannerCollectionFactory->create()
                ->setStoreViewId($storeViewId)
                ->addFieldToFilter('banner_id', ['in' => $bannerIds]);
            try {
                foreach ($bannerCollection as $banner) {
                    $banner->setStoreViewId($storeViewId)
                        ->setStatus($status)
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been changed status.', count($bannerIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/', ['store' => $this->getRequest()->getParam('store')]);
    }
}
