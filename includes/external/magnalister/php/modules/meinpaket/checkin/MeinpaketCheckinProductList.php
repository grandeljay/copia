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
 * $Id: CheckinCategoryView.php 1152 2011-07-25 16:34:12Z derpapst $
 *
 * (c) 2011 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */

require_once(DIR_MAGNALISTER_MODULES . 'meinpaket/classes/MLProductListMeinpaketAbstract.php');

class MeinpaketCheckinProductList extends MLProductListMeinpaketAbstract{
	
	protected function getSelectionName() {
		return 'checkin';
	}
	public function __construct() {
		 $this->aListConfig[] = array(
			'head' => array(
				'attributes' => 'class="lowestprice"',
				'content' => 'ML_MEINPAKET_LABEL_CATEGORY',
			),
			'field' => array('meinpaketmpcategory'),
		);
		parent::__construct();
		$this
			->addDependency('MLProductListDependencyCheckinToSummaryAction')
			->addDependency('MLProductListDependencyTemplateSelectionAction')
			->addDependency('MLProductListDependencyLastPreparedFilter', array(
				'propertiestablename' => TABLE_MAGNA_MEINPAKET_PROPERTIES, 
				'propertiestablealias' => 'mcc', 
				'preparedtimestampfield' => 'PreparedTS',
			))
//			->addDependency('MLProductListDependencyManufacturersFilter')// its now in MLProductList as global filter
		;
	}
	
	/**
	 * adding propertiestable for filter
	 */
	protected function buildQuery() {
		parent::buildQuery()->oQuery->join(
			array(
				TABLE_MAGNA_MEINPAKET_PROPERTIES,
					'mcc',
					(
						(getDBConfigValue('general.keytype', '0') == 'artNr')
							? 'p.products_model = mcc.products_model'
							: 'p.products_id = mcc.products_id'
					).
					"
						AND mcc.mpID = '".$this->aMagnaSession['mpID']."'
						AND mcc.MarketplaceCategory <> ''
						AND Verified = 'OK' "
				),
				ML_Database_Model_Query_Select::JOIN_TYPE_INNER
			);
		return $this;
	}

	protected function isPreparedDifferently($aRow) {
		$sPrimaryCategory = $this->getPrepareData($aRow, 'VariationConfiguration');
		if (!empty($sPrimaryCategory)) {
			$sCategoryDetails = $this->getPrepareData($aRow, 'CategoryAttributes');
			$categoryMatching = MeinpaketHelper::gi()->getCategoryMatching($sPrimaryCategory);
			$sCategoryDetails = json_decode($sCategoryDetails, true);
			return MeinpaketHelper::gi()->detectChanges($categoryMatching, $sCategoryDetails);
		}

		return false;
	}

	protected function isDeletedAttributeFromShop($aRow, &$message) {
	    $aVariationConfiguration = $this->getPrepareData($aRow, 'VariationConfiguration');
		if (!empty($aVariationConfiguration)) {
			$matchedAttributes = $this->getPrepareData($aRow, 'CategoryAttributes');
			$matchedAttributes = json_decode($matchedAttributes, true);
			$shopAttributes = MeinpaketHelper::gi()->flatShopVariations();

            if (!is_array($matchedAttributes)) {
                $matchedAttributes = array();
            }

			foreach ($matchedAttributes as $matchedAttribute) {
				if (MeinpaketHelper::gi()->detectIfAttributeIsDeletedOnShop($shopAttributes, $matchedAttribute, $message)) {
					return true;
				}
			}
		}

		return false;
	}
}