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
 * $Id: $
 *
 * (c) 2010 - 2014 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class HitmeisterProductSaver {
	const DEBUG = false;
	public $aErrors = array();

	protected $aMagnaSession = array();
	protected $sMarketplace = '';
	protected $sMpId = 0;

	protected $aConfig = array();

	public function __construct($magnaSession) {
		$this->aMagnaSession = &$magnaSession;
		$this->sMarketplace = $this->aMagnaSession['currentPlatform'];
		$this->mpId = $this->aMagnaSession['mpID'];

		$this->aConfig['keytype'] = getDBConfigValue('general.keytype', '0');
	}

	protected function insertPrepareData($aData) {
		/* {Hook} "HitmeisterInsertPrepareData": Enables you to modify the prepared product data before it will be saved.<br>
			Variables that can be used:
			<ul>
			 <li><code>$aData</code>: The data of a product.</li>
			 <li>$this->mpID</code>: The ID of the marketplace.</li>
			</ul>
		*/
		if (($hp = magnaContribVerify('HitmeisterInsertPrepareData', 1)) !== false) {
			require($hp);
		}
		if (self::DEBUG) {
			echo print_m($aData, __METHOD__);
			die();
		}
		#echo print_m($aData, __METHOD__);
		MagnaDB::gi()->insert(TABLE_MAGNA_HITMEISTER_PREPARE, $aData, true);
	}

	/**
	 * Hilfsfunktion fuer SaveHoodSingleProductProperties und SaveHoodMultipleProductProperties
	 * bereite die DB-Zeile vor mit allen Daten die sowohl fuer Single als auch Multiple inserts gelten
	 */
	protected function preparePropertiesRow($iProductId, $aItemDetails) {
		$aRow = array();
		$aRow['mpID'] = $this->mpId;
		$aRow['products_id'] = $iProductId;
		$result = MagnaDB::gi()->fetchArray('
			SELECT products_model, products_ean
			  FROM '.TABLE_PRODUCTS.'
			 WHERE products_id =' . $iProductId
		);
		
		$aRow['products_model'] = $result[0]['products_model'];
		$aRow['EAN'] = $result[0]['products_ean'];
		$aRow['PrepareType'] = 'Apply';
		$aRow['Verified'] = 'OK';


		// If Title is not set multi prepare is used so Title and Description should be used from product.
		if (isset($aItemDetails['Title']) === false) {
			$lang = getDBConfigValue($this->sMarketplace . '.lang', $this->mpId);

			$prod = MagnaDB::gi()->fetchArray('
				SELECT 
					p.products_id,
					p.products_model,
					p.products_ean as EAN,
					p.products_image as PictureUrl,
					pd.products_name as Title,
					pd.products_short_description as Subtitle,
					pd.products_description as Description
				FROM ' . TABLE_PRODUCTS . ' p
				LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON pd.products_id = p.products_id AND pd.language_id = "' . $lang . '"
				WHERE p.products_id = ' . $iProductId
			);

			$aItemDetails['Title'] = $prod[0]['Title'];
			$aItemDetails['Subtitle'] = $prod[0]['Subtitle'];
			$aItemDetails['Description'] = $prod[0]['Description'];
		}

		if (isset($aItemDetails['Images'])) {
			$aImages = (array)$aItemDetails['Images'];
			if (in_array('false', $aImages) && count($aImages) > 1) {
				array_shift($aImages);
			}
			
			$aPictureURL = array();
			foreach ($aImages as $key => $value) {
				$aPictureURL[urldecode($key)] = $value;
			}
			
			$aRow['PictureURL'] = json_encode($aPictureURL);
		} else {
			$aProduct = MLProduct::gi()->setLanguage(getDBConfigValue($this->sMarketplace . '.lang', $this->mpId))->getProductById($iProductId);

			$images = array();

			foreach ($aProduct['Images'] as $image) {
				$images[$image] = 'true';
			}

			$aRow['PictureURL'] = json_encode($images);
		}

		if (!isset($aItemDetails['mpCategory']) || $aItemDetails['mpCategory'] === '') {
			$aRow['Verified'] = 'ERROR';
			$this->aErrors['ML_RICARDO_ERROR_CATEGORY'] = ML_RICARDO_ERROR_CATEGORY;
		} else {
			$aRow['MarketplaceCategories'] = $aItemDetails['mpCategory'];
			$aRow['MarketplaceCategoriesName'] = $aItemDetails['mpCategoryName'];
		}

		if (!isset($aRow['EAN']) || $aRow['EAN'] === '') {
			$aRow['Verified'] = 'ERROR';
			$this->aErrors['ML_HITMEISTER_ERROR_EAN'] = ML_HITMEISTER_ERROR_EAN;
		}
		
		$aRow['Title'] = $aItemDetails['Title'];
		if (!isset($aRow['Title']) || $aRow['Title'] === '') {
			$aRow['Verified'] = 'ERROR';
			$this->aErrors['ML_HITMEISTER_ERROR_TITLE'] = ML_HITMEISTER_ERROR_TITLE;
		}

		if (isset($aItemDetails['Subtitle']) === true) {
			$aRow['Subtitle'] = $aItemDetails['Subtitle'];
		}
		
		$aRow['Description'] = $aItemDetails['Description'];
		if (!isset($aRow['Description']) || $aRow['Description'] === '') {
			$aRow['Verified'] = 'ERROR';
			$this->aErrors['ML_HITMEISTER_ERROR_DESCRITPION'] = ML_HITMEISTER_ERROR_DESCRITPION;
		}		
		
		$attributes = array();
		if (isset($aItemDetails['catAttributes']) && is_array($aItemDetails['catAttributes'])) {
			foreach ($aItemDetails['catAttributes'] as $key => $attribute) {
				if ($attribute['required'] === 'true') {
					if (is_array($attribute['values']) && empty($attribute['values']) === false) {
						foreach ($attribute['values'] as $value) {
							if (empty($value)) {
								$aRow['Verified'] = 'ERROR';
								$this->aErrors['ML_HITMEISTER_ERROR_CATEGORY_ATTRIBUTE'] = $key . ML_HITMEISTER_ERROR_CATEGORY_ATTRIBUTE;
								break;
							} else {
								$attributes[$key][] = $value;
							}
						}
						continue;
					} else if (empty($attribute['values'])) {
						$aRow['Verified'] = 'ERROR';
						$this->aErrors['ML_HITMEISTER_ERROR_CATEGORY_ATTRIBUTE'] = $key . ML_HITMEISTER_ERROR_CATEGORY_ATTRIBUTE;
						continue;
					}
				}

				$attributes[$key] = $attribute['values'];
			}
		}

		$aRow['CategoryAttributes'] = json_encode($attributes);
		$aRow['ConditionType'] = $aItemDetails['condition_id'];
		$aRow['ShippingTime'] = $aItemDetails['shippingtime'];
		$aRow['Location'] = $aItemDetails['deliverycountry'];
		$aRow['Comment'] = $aItemDetails['comment'];

		return $aRow;
	}

	public function saveSingleProductProperties($iProductId, $aItemDetails, $prepareType) {
		//No SingleProductSave at this Time so use Multi
		$this->saveMultipleProductProperties(array($iProductId), $aItemDetails, $prepareType);
	}

	public function saveMultipleProductProperties($iProductIds, $aItemDetails, $prepareType) {
		if ($prepareType === 'match') {
			$this->insertMatchProduct($aItemDetails);
			return;
		}
		
		$preparedTs = date('Y-m-d H:i:s');
		foreach ($iProductIds as $iProductId) {
			$aRow = $this->preparePropertiesRow($iProductId, $aItemDetails);
			$aRow['PreparedTs'] = $preparedTs;
			$this->insertPrepareData($aRow);
		}
	}
	
	private function insertMatchProduct($itemDetails) {
		foreach ($itemDetails['model'] as $pId => $productModel) {

			$productId = $itemDetails['match'][$pId];

			if ($productId === 'false') {
				continue;
			}

			$matchedProduct = array(
				'mpID'				=> $this->mpId,
				'products_id'		=> $pId,
				'products_model'	=> $productModel,
				'Title'				=> $itemDetails['title'][$productId],
				'EAN'				=> $itemDetails['ean'][$productId],
				'ConditionType'		=> $itemDetails['unit']['condition_id'],
				'ShippingTime'		=> $itemDetails['unit']['shippingtime'],
				'Location'			=> $itemDetails['unit']['deliverycountry'],
				'Comment'			=> $itemDetails['unit']['comment'],
				'PrepareType'		=> 'Match',
				'Verified'			=> 'OK',
				'PreparedTs'		=> date('Y-m-d H:i:s'),
			);

			MagnaDB::gi()->insert(TABLE_MAGNA_HITMEISTER_PREPARE, $matchedProduct, true);
		}
	}
}
