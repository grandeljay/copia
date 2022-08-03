<?php
/*
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
 * (c) 2010 - 2021 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */

require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/MLProductList.php');
require_once(DIR_MAGNALISTER_MODULES.'otto/OttoHelper.php');

abstract class MLProductListOttoAbstract extends MLProductList {
    /**
     * @var array
     */
    protected $aPrepareData = array();

    protected function getOttoPrice() {
        return $this->getPrice()
            ->setPrice($this->getPrice()->getPrice())
            ->format();
    }

    protected function getPrepareData($aRow, $sFieldName = null) {
        if (!isset($this->aPrepareData[$aRow['products_id']])) {
            $this->aPrepareData[$aRow['products_id']] = MagnaDB::gi()->fetchRow("
				SELECT *
				  FROM ".TABLE_MAGNA_OTTO_PREPARE."
				 WHERE ".((getDBConfigValue('general.keytype', '0') == 'artNr')
                    ? 'products_model=\''.MagnaDB::gi()->escape($aRow['products_model']).'\''
                    : 'products_id=\''.$aRow['products_id'].'\''
                )."
				       AND mpID = '".$this->aMagnaSession['mpID']."'
			");
        }
        if ($sFieldName === null) {
            return $this->aPrepareData[$aRow['products_id']];
        } else {
            return isset($this->aPrepareData[$aRow['products_id']][$sFieldName]) ? $this->aPrepareData[$aRow['products_id']][$sFieldName] : null;
        }
    }

    protected function getQuantityForOtto($aRow) {
        return OttoHelper::getQuantityForOtto($aRow['products_quantity'], $this->aMagnaSession['mpID']);
    }
}
