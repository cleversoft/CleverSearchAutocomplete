<?php

namespace CleverSoft\CleverSearchAutoComplete\Model\Search;

use \CleverSoft\CleverSearchAutoComplete\Helper\Data as HelperData;
use \Magento\Search\Helper\Data as SearchHelper;
use \CleverSoft\CleverSearchAutoComplete\Model\Autocomplete\SearchDataProvider;
use \CleverSoft\CleverSearchAutoComplete\Model\Source\AutocompleteFields;

/**
 * Suggested model. Return suggested data used in search autocomplete
 */
class Suggested implements \CleverSoft\CleverSearchAutoComplete\Model\SearchInterface
{
    /**
     * @var \CleverSoft\CleverSearchAutoComplete\Helper\Data
     */
    protected $helperData;

    /**
     * @var \Magento\Search\Helper\Data
     */
    protected $searchHelper;

    /**
     * @var \CleverSoft\CleverSearchAutoComplete\Model\Autocomplete\SearchDataProvider
     */
    protected $searchDataProvider;

    /**
     * Suggested constructor.
     *
     * @param HelperData $helperData
     * @param SearchHelper $searchHelper
     * @param AutocompleteInterface $searchDataProvider
     */
    public function __construct(
        HelperData $helperData,
        SearchHelper $searchHelper,
        SearchDataProvider $searchDataProvider
    ) {
    
        $this->helperData = $helperData;
        $this->searchHelper = $searchHelper;
        $this->searchDataProvider = $searchDataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseData()
    {
        $responseData['code'] = AutocompleteFields::SUGGEST;
        $responseData['data'] = [];

        if (!$this->canAddToResult()) {
            return $responseData;
        }

        $suggestResultNumber = $this->helperData->getSuggestedResultNumber();

        $autocompleteData = $this->searchDataProvider->getItems();

        // $autocompleteData = array_slice($autocompleteData, 0, $suggestResultNumber);
        foreach ($autocompleteData as $item) {
            $item = $item->toArray();
            $item['url'] = $this->searchHelper->getResultUrl($item['title']);
            $responseData['data'][] = $item;
        }
        return $responseData;
    }

    /**
     * {@inheritdoc}
     */
    public function canAddToResult()
    {
        return in_array(AutocompleteFields::SUGGEST, $this->helperData->getAutocompleteFieldsAsArray());
    }
}
