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
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/ComparisonShopping/ComparisonShoppingSummaryView.php');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/ComparisonShopping/ComparisonShoppingCategoryView.php');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/ComparisonShopping/ComparisonShoppingCheckinSubmit.php');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/CheckinManager.php');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/ComparisonShopping/ComparisonShoppingCheckinProductList.php');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/ComparisonShopping/MLProductListComparisonShoppingAbstract.php');

class PreissuchmaschineSummaryView extends ComparisonShoppingSummaryView {
	protected function getAdditionalProductNameStuff($prod) {
		return '
			<a class="right gfxbutton magnifier" target="_blank" '.
			  'href="http://www.preissuchmaschine.de/preisvergleich/produkt.cgi?suche='.urlencode($prod['products_name']).'" '.
			  'title="'.ML_PREISSUCHMASCHINE_SAME_PRODUCT_THERE.'"></a>';
	}
}

$sCheckinView = '';
if (defined('MAGNA_DEV_PRODUCTLIST') && MAGNA_DEV_PRODUCTLIST === true) {
$sCheckinView = 'ComparisonShoppingCheckinProductList';
} else {
$sCheckinView = 'ComparisonShoppingCategoryView';
}

$cm = new CheckinManager(
	array(
		'summaryView'   => 'PreissuchmaschineSummaryView',
		'checkinView'   => $sCheckinView,
		'checkinSubmit' => 'ComparisonShoppingCheckinSubmit'
	), array(
		'marketplace' => $_Marketplace
	)
);

echo $cm->mainRoutine();