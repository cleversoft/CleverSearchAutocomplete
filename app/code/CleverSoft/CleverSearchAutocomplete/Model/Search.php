<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace CleverSoft\CleverSearchAutocomplete\Model;

use \CleverSoft\CleverSearchAutocomplete\Helper\Data as HelperData;
use \CleverSoft\CleverSearchAutocomplete\Model\SearchFactory;

/**
 * Search class returns needed search data
 */
class Search
{
    /**
     * @var \CleverSoft\CleverSearchAutocomplete\Helper\Data
     */
    protected $helperData;

    /**
     * @var \CleverSoft\CleverSearchAutocomplete\Model\SearchFactory
     */
    protected $searchFactory;

    /**
     * Search constructor.
     * @param \CleverSoft\CleverSearchAutocomplete\Model\SearchFactory $searchFactory
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
