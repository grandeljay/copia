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
 * (c) 2010 - 2019 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */

require_once(DIR_MAGNALISTER_MODULES.'googleshopping/classes/MLProductListGoogleshoppingAbstract.php');

class GoogleshoppingMatchingProductList extends MLProductListGoogleshoppingAbstract {
    public function __construct() {
        $this->aListConfig[] = array(
            'head' => array(
                'attributes' => 'class="matched"',
                'content' => 'ML_MAGNACOMPAT_LABEL_PREPARED'
            ),
            'field' => array(
                'preparestatusindicator'
            )
        );

        parent::__construct();
        $this
            ->addDependency('MLProductListDependencyGoogleshoppingMatchingFormAction', array('selectionname' => $this->getSelectionName()))
            ->addDependency('MLProductListDependencyGoogleshoppingPrepareStatusFilter');
    }

    /**
     * removing items which are in propertiestable
     */
    protected function buildQuery() {
        $sKeyType = (getDBConfigValue('general.keytype', '0') == 'artNr') ? 'products_model' : 'products_id';
        $aHitmeisterProperties = MagnaDB::gi()->fetchArray("
			SELECT DISTINCT ".$sKeyType."
			FROM ".TABLE_MAGNA_HITMEISTER_PREPARE."
			WHERE mpID = '".$this->aMagnaSession['mpID']."'
				AND PrepareType='apply'
		", true);

        parent::buildQuery()->oQuery->where(
            "p.".$sKeyType." NOT IN ('".implode('\' , \'', $aHitmeisterProperties)."')
		"
        );
        return $this;
    }

    protected function getSelectionName() {
        return 'match';
    }
}
