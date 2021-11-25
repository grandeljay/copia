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

defined('TABLE_MAGNA_EBAY_VARIANTMATCHING') OR define('TABLE_MAGNA_EBAY_VARIANTMATCHING', 'magnalister_ebay_variantmatching');

require_once(DIR_MAGNALISTER_MODULES . 'magnacompatible/prepare/VariationMatching.php');
require_once(DIR_MAGNALISTER_MODULES . 'ebay/EbayHelper.php');
require_once(DIR_MAGNALISTER_MODULES . 'ebay/classes/eBayCategoryMatching.php');
require_once(DIR_MAGNALISTER_MODULES . 'ebay/classes/ebayTopTen.php');

class EbayVariationMatching extends VariationMatching
{
	protected function getAttributesMatchingHelper()
	{
		return EbayHelper::gi();
	}

	protected function getTopTenCategoriesHandler()
	{
		return new EbayTopTen();
	}

	protected function getCategoryMatchingHandler()
	{
		return new eBayCategoryMatching();
	}
}
