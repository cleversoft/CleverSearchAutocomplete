<?php

namespace CleverSoft\CleverSearchAutoComplete\Model\Search;

use \CleverSoft\CleverSearchAutoComplete\Helper\Data as HelperData;
use \Magento\Search\Helper\Data as SearchHelper;
use \CleverSoft\CleverSearchAutoComplete\Model\Autocomplete\SearchDataProvider;
use \CleverSoft\CleverSearchAutoComplete\Model\Source\AutocompleteFields;
use \CleverSoft\CleverSearchAutoComplete\Model\Source\ProductFields;
use \Magento\Framework\ObjectManagerInterface as ObjectManager;
use Magento\Framework\App\Request\Http;
/**
 * Product model. Return suggested data used in search autocomplete
 */
class Product implements \CleverSoft\CleverSearchAutoComplete\Model\SearchInterface
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
     * Product constructor.
     *
     * @param HelperData $helperData
     * @param SearchHelper $searchHelper
     * @param AutocompleteInterface $searchDataProvider
     */
    public function __construct(
        HelperData $helperData,
        SearchHelper $searchHelper,
        SearchDataProvider $searchDataProvider,
        ObjectManager $objectManager,
        Http $request
    ) {
    
        $this->helperData = $helperData;
        $this->searchHelper = $searchHelper;
        $this->searchDataProvider = $searchDataProvider;
        $this->objectManager = $objectManager;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseData()
    {
        $responseData['code'] = AutocompleteFields::PRODUCT;
        $responseData['data'] = [];

        if (!$this->canAddToResult()) {
            return $responseData;
        }

        $productResultFields = $this->helperData->getProductResultFieldsAsArray();
        $productResultFields[] = ProductFields::URL;

        $productCollection = $this->getProductCollection();
        $productResultNumber = $this->helperData->getProductResultNumber();
        
        $limitedCollection = array_slice($productCollection, 0, $productResultNumber);
        $cat = $this->request->getParam('cat');

        foreach ($limitedCollection as $product) {
            if ($cat) {
                if (!in_array($cat, $product->getCategoryIds())) {
                    continue;
                }
            }
            $responseData['data'][] = array_intersect_key($this->getProductData($product), array_flip($productResultFields));
        }

        $responseData['size'] = count($productCollection);
        $responseData['url'] = (count($productCollection) > 0) ? $this->searchHelper->getResultUrl($this->searchDataProvider->getQueryText()) : '';
        return $responseData;
    }

        /**
     * Retrive product collection by query text
     *
     * @param  string $queryText
     * @return mixed
     */
    protected function getProductCollection()
    {
        $productCollection = $this->searchDataProvider->getProductCollection();
        return $productCollection;
    }

    /**
     * Retrieve all product data
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return array
     */
    protected function getProductData($product)
    {
        /** @var \CleverSoft\CleverSearchAutoComplete\Block\Autocomplete\Product $product */
        $product = $this->objectManager->create('CleverSoft\CleverSearchAutoComplete\Block\Autocomplete\ProductAgregator')
            ->setProduct($product);

        $data = [
            ProductFields::NAME => $product->getName(),
            ProductFields::SKU => $product->getSku(),
            ProductFields::IMAGE => $product->getSmallImage(),
            ProductFields::REVIEWS_RATING => $product->getReviewsRating(),
            ProductFields::SHORT_DESCRIPTION => $product->getShortDescription(),
            ProductFields::DESCRIPTION => $product->getDescription(),
            ProductFields::PRICE => $product->getPrice(),
            ProductFields::ADD_TO_CART => $product->getAddToCartData(),
            ProductFields::URL => $product->getUrl()
        ];

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function canAddToResult()
    {
        return in_array(AutocompleteFields::PRODUCT, $this->helperData->getAutocompleteFieldsAsArray());
    }
}
