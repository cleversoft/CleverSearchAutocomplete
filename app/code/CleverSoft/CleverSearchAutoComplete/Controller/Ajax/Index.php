<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace CleverSoft\CleverSearchAutoComplete\Controller\Ajax;

use \CleverSoft\CleverSearchAutoComplete\Helper\Data as HelperData;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\Controller\ResultFactory;
use \Magento\Search\Model\QueryFactory;
use \Magento\Store\Model\StoreManagerInterface;
use \CleverSoft\CleverSearchAutoComplete\Model\Search as SearchModel;

/**
 * CleverSearchAutoComplete ajax controller
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \CleverSoft\CleverSearchAutoComplete\Helper\Data
     */
    protected $helperData;

    /**
     * @var \Magento\Search\Model\QueryFactory
     */
    private $queryFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \CleverSoft\CleverSearchAutoComplete\Model\Search
     */
    private $searchModel;

    /**
     * Index constructor.
     *
     * @param HelperData $helperData
     * @param Context $context
     * @param QueryFactory $queryFactory
     * @param StoreManagerInterface $storeManager
     * @param SearchModel $searchModel
     */
    public function __construct(
        HelperData $helperData,
        Context $context,
        QueryFactory $queryFactory,
        StoreManagerInterface $storeManager,
        SearchModel $searchModel
    ) {
        $this->helperData = $helperData;
        $this->storeManager = $storeManager;
        $this->queryFactory = $queryFactory;
        $this->searchModel = $searchModel;
        parent::__construct($context);
    }

    /**
     * Retrieve json of result data
     *
     * @return array|\Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $query = $this->queryFactory->get();
        $query->setStoreId($this->storeManager->getStore()->getId());

        $responseData = [];

        if ($query->getQueryText() != '') {

            $query->setId(0)->setIsActive(1)->setIsProcessed(1);

            $responseData['result'] = $this->searchModel->getData();

            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        }

        $resultJson->setData($responseData);
        return $resultJson;
    }
}
