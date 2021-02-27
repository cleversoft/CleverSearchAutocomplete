<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace CleverSoft\CleverSearchAutoComplete\Block;

/**
 * Autocomplete class used to paste config data
 */
class Autocomplete extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \CleverSoft\CleverSearchAutoComplete\Helper\Data
     */
    protected $helperData;

    /**
     * Autocomplete constructor.
     *
     * @param \CleverSoft\CleverSearchAutoComplete\Helper\Data $helperData
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \CleverSoft\CleverSearchAutoComplete\Helper\Data $helperData,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
    
        $this->helperData = $helperData;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve search delay in miliseconds (500 by default)
     *
     * @return int
     */
    public function getSearchDelay()
    {
        return $this->helperData->getSearchDelay();
    }

    /**
     * Retrieve search action url
     *
     * @return string
     */
    public function getSearchUrl()
    {
        return $this->getUrl("cleversoft_cleversearchautocomplete/ajax/index");
    }
}
