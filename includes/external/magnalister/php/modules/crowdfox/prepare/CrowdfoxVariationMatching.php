<?php
/**
 * 888888ba                 dP  .88888.                    dP
 * 88    `8b                88 d8'   `88                   88
 * 88aaaa8P' .d8888b. .d888b88 88        .d8888b. .d8888b. 88  .dP  .d8888b.
 * 88   `8b. 88ooood8 88'  `88 88   YP88 88ooood8 88'  `"" 88888"   88'  `88
 * 88     88 88.  ... 88.  .88 Y8.   .88 88.  ... 88.  ... 88  `8b. 88.  .88
 * dP     dP `88888P' `88888P8  `88888'  `88888P' `88888P' dP   `YP `88888P'
 *
 *                          m a g n a l i s t e r
 *                                      boost your Online-Shop
 *
 * -----------------------------------------------------------------------------
 * $Id$
 *
 * (c) 2010 - 2013 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */
// äöüß

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

defined('TABLE_MAGNA_CROWDFOX_VARIANTMATCHING') OR
define('TABLE_MAGNA_CROWDFOX_VARIANTMATCHING', 'magnalister_crowdfox_variantmatching');

require_once(DIR_MAGNALISTER_MODULES . 'magnacompatible/prepare/VariationMatching.php');
require_once(DIR_MAGNALISTER_MODULES . 'crowdfox/CrowdfoxHelper.php');
require_once(DIR_MAGNALISTER_MODULES . 'crowdfox/prepare/CrowdfoxCategoryMatching.php');
require_once(DIR_MAGNALISTER_MODULES . 'crowdfox/classes/CrowdfoxTopTenCategories.php');

class CrowdfoxVariationMatching extends VariationMatching {
    protected function getAttributesMatchingHelper() {
        return CrowdfoxHelper::gi();
    }

    protected function getTopTenCategoriesHandler() {
        return new CrowdfoxTopTenCategories();
    }

    protected function getCategoryMatchingHandler() {
        return new CrowdfoxCategoryMatching();
    }

    protected function renderCategoryOptions($sType, $sCategory) {
        return '<option value="CrowdfoxPlaceholderCategory" selected="selected">CrowdfoxPlaceholderCategory</option>';
    }
}
