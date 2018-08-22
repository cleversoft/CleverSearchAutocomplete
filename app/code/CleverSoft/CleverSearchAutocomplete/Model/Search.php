<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace CleverSoft\CleverSearchAutoComplete\Model;

use \CleverSoft\CleverSearchAutoComplete\Helper\Data as HelperData;
use \CleverSoft\CleverSearchAutoComplete\Model\SearchFactory;

/**
 * Search class returns needed search data
 */
class Search
{
    /**
     * @var \CleverSoft\CleverSearchAutoComplete\Helper\Data
     */
    protected $helperData;

    /**
     * @var \CleverSoft\CleverSearchAutoComplete\Model\SearchFactory
     */
    protected $searchFactory;

    /**
     * Search constructor.
     * @param \CleverSoft\CleverSearchAutoComplete\Model\SearchFactory $searchFactory
     */
    public function __construct(
        HelperData $helperData,
        SearchFactory $searchFactory
    ) {
        $this->helperData = $helperData;
        $this->searchFactory = $searchFactory;
    }

    /**
     * Retrieve suggested, product data
     *
     * @return array
     */
    public function getData()
    {
        $data = [];
        $autocompleteFields = $this->helperData->getAutocompleteFieldsAsArray();
        foreach ($autocompleteFields as $field) {
            $data[] = $this->searchFactory->create($field)->getResponseData();
        }
        return $data;
    }
}
