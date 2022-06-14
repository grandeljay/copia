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

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
require_once(DIR_MAGNALISTER_MODULES.'magnacompatible/checkin/MagnaCompatibleCheckinSubmit.php');
require_once(DIR_MAGNALISTER_MODULES.'check24/Check24Helper.php');
require_once(DIR_MAGNALISTER_MODULES.'check24/classes/Check24ProductSaver.php');

class Check24CheckinSubmit extends MagnaCompatibleCheckinSubmit {
	private $oLastException = null;

	public function __construct($settings = array()) {
		global $_MagnaSession;

		$settings = array_merge(array(
			'language' => getDBConfigValue($settings['marketplace'] . '.lang', $_MagnaSession['mpID'], ''),
			'currency' => getCurrencyFromMarketplace($_MagnaSession['mpID']),
			'keytype' => getDBConfigValue('general.keytype', '0'),
			'itemsPerBatch' => 100,
			'mlProductsUseLegacy' => false,
		), $settings);

		$this->summaryAddText = ML_CHECK24_TEXT_AFTER_UPLOAD;
		
		parent::__construct($settings);
		
		$this->settings['SyncInventory'] = array (
			'Price' => getDBConfigValue($settings['marketplace'].'.inventorysync.price', $this->mpID, '') == 'auto',
			'Quantity' => getDBConfigValue($settings['marketplace'].'.stocksync.tomarketplace', $this->mpID, '') == 'auto',
		);
	}

	protected function processException($e) {
		$this->oLastException = $e;
	}

	public function getLastException() {
		return $this->oLastException;
	}
	
	protected function setUpMLProduct() {
		parent::setUpMLProduct();
		
		// Set Price and Quantity settings
		MLProduct::gi()->setPriceConfig(Check24Helper::loadPriceSettings($this->mpID));
		MLProduct::gi()->setQuantityConfig(Check24Helper::loadQuantitySettings($this->mpID));
	}

	protected function appendAdditionalData($iPID, $aProduct, &$aData) {
		$aPropertiesRow = MagnaDB::gi()->fetchRow('
			SELECT * FROM '.TABLE_MAGNA_CHECK24_PROPERTIES.'
			 WHERE ' . ((getDBConfigValue('general.keytype', '0') == 'artNr')
				? 'products_model = "'.MagnaDB::gi()->escape($aProduct['ProductsModel']).'"'
				: 'products_id = "'.$iPID.'"'
			) . '
			       AND mpID = '.$this->_magnasession['mpID']
		);
		
		// Will not happen in sumbit cycle but can happen in loadProductByPId.
		if (empty($aPropertiesRow)) {
			$aData['submit'] = array();
			return;
		}

		#echo print_m($aProduct);

		$aData['submit']['SKU'] = $aData['submit']['MasterSKU'] = ($this->settings['keytype'] == 'artNr') ? $aProduct['MarketplaceSku'] : $aProduct['MarketplaceId'];
		$aData['submit']['Title'] = $aProduct['Title'];

		if (empty($aProduct['Description']) === false) {
			$aData['submit']['Description'] = $aProduct['Description'];
		}

		if (empty($aProduct['Manufacturer']) === false) {
			$aData['submit']['Manufacturer'] = $aProduct['Manufacturer'];
		} else {
			$manufacturerName = getDBConfigValue($this->marketplace.'.checkin.manufacturerfallback', $this->mpID, '');
			if (empty($manufacturerName) === false) {
				$aData['submit']['Manufacturer'] = $manufacturerName;
			}
		}

		if (empty($aProduct['ManufacturerPartNumber']) === false) {
			$aData['submit']['ManufacturerPartNumber'] = $aProduct['ManufacturerPartNumber'];
		}

		if (empty($aProduct['EAN']) === false) {
			$aData['submit']['EAN'] = $aProduct['EAN'];
		}

		if (empty($aProduct['Images']) === false) {
			foreach($aProduct['Images'] as $sImg) {
				$aData['submit']['Images'][] = array('URL' => SHOP_URL_POPUP_IMAGES . $sImg);
			}
		}

		$aData['submit']['ProductUrl'] = $_SERVER['SERVER_NAME'] . DIR_WS_CATALOG . $aProduct['ProductUrl'];
		$aData['submit']['Quantity'] = $aData['quantity'];
		$aData['submit']['Price'] = $aData['price'];
		$aData['submit']['BasePrice'] = $aProduct['BasePrice'];
		$aData['submit']['ShippingTime'] = $aPropertiesRow['ShippingTime'];
		$aData['submit']['ShippingCost'] = $aPropertiesRow['ShippingCost'];
		

		if (empty($aProduct['Variations']) === false) {
			$aData['submit']['Variations'] = $aProduct['Variations'];
		}
	}

	protected function afterPopulateSelectionWithData() {
		$newSelection = array();

		foreach ($this->selection as $productId => $product) {
			if (isset($product['submit']['Variations']) === false) {
				$newSelection[$productId] = $product;
				continue;
			}

			$i = 1;
			foreach ($product['submit']['Variations'] as $variation) {
				$variationData = $product;
				unset($variationData['submit']['Variations']);

				$variationData['submit']['SKU'] = $variation['MarketplaceSku'];
				$variationData['submit']['Quantity'] = $variation['Quantity'];
				$variationData['submit']['Price'] = $variation['Price']['Price'];
				$variationData['submit']['EAN'] = $variation['EAN'];

				foreach ($product['submit']['Variations'] as $v) {
					if ($v['MarketplaceSku'] === $variation['MarketplaceSku']) {
						$attributes = array();
						foreach ($v['Variation'] as $var) {
							$attributes[] = $var['Name'].' - '.$var['Value'];
						}

						$variationData['submit']['Title'] .= ': ' . implode(', ', $attributes);
						break;
					}
				}

				$newSelection[$productId . '_' . $i] = $variationData;
				$i++;
			}
		}

		$this->variationCount = count($newSelection) - count($this->selection);
		$this->selection = $newSelection;
	}

	protected function markAsFailed($sku) {
		$iPID = magnaSKU2pID($sku);
		$this->badItems[] = $iPID;
		unset($this->selection[$iPID]);
	}

	/*protected function postSubmit() {
		try {
			$result = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'UploadItems',
			));
		} catch (MagnaException $e) {
			$this->submitSession['api']['exception'] = $e;
			$this->submitSession['api']['html'] = MagnaError::gi()->exceptionsToHTML();
		}
	}*/

}
