<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace CleverSoft\CleverSearchAutoComplete\Model;

/**
 * @api
 */
interface SearchInterface
{
    /**
     * Retrieve selected in config data
     *
     * @return array
     */
    public function getResponseData();

    /**
     * Check if data used in search result
     *
     * @return bool
     */
    public function canAddToResult();
}
