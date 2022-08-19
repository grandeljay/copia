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

require_once(DIR_MAGNALISTER_MODULES.'otto/OttoHelper.php');
require_once(DIR_MAGNALISTER_MODULES.'otto/prepare/OttoIndependentAttributes.php');

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class OttoPrepare extends MagnaCompatibleBase {

    /**
     * @var array
     */
    protected $prepareSettings = array();

    public function __construct(&$params) {
        if (!empty($_POST['FullSerializedForm'])) {
            $newPost = array();
            parse_str_unlimited($_POST['FullSerializedForm'], $newPost);

            $_POST = array_merge($_POST, $newPost);
        }

        parent::__construct($params);

        $this->prepareSettings['selectionName'] = isset($_GET['view']) ? $_GET['view'] : 'prepare';
        $this->resources['url']['mode'] = 'prepare';
        $this->resources['url']['view'] = $this->prepareSettings['selectionName'];
        if ('apply' == $this->prepareSettings['selectionName']) $this->prepareSettings['selectionName'] = 'prepare';
    }

    public function process() {
#echo print_m($_POST, '$_POST');
#echo print_m($_GET, '$_GET');

        // ajax / LoadMPVariations in prepare item form
        if ((isset($_GET['mode']) && $_GET['mode'] == 'prepare')
            && (isset($_GET['view']) && ($_GET['view'] == 'apply' || $_GET['view'] == 'prepare'))
            && (isset($_GET['kind']) && $_GET['kind'] == 'ajax')
            && (isset($_GET['where']) && $_GET['where'] == 'OttoPrepareView')
            && (isset($_POST['Action']) && $_POST['Action'] == 'LoadMPVariations')
            && (isset($_POST['SelectValue']))) {
            $productModel = OttoHelper::gi()->getProductModel('prepare');
            die(json_encode(OttoHelper::gi()->getMPVariations($_POST['SelectValue'], $productModel, true)));
        }

        // ajax / Load CategoryIndependentAttributes in prepare item form
        if ((isset($_GET['mode']) && $_GET['mode'] == 'prepare')
            && (isset($_GET['view']) && ($_GET['view'] == 'apply' || $_GET['view'] == 'prepare' || $_GET['view'] == 'varmatch'))
            && (isset($_GET['kind']) && $_GET['kind'] == 'ajax')
            && (isset($_GET['where']) && ($_GET['where'] == 'OttoPrepareView' || $_GET['where'] == 'varmatchView'))
            && (isset($_POST['Action']) && $_POST['Action'] == 'LoadCategoryIndependentAttributes')) {
            $independentAttributesClass = new OttoIndependentAttributes;
            $independentAttributes = $independentAttributesClass->getCategoryIndependentAttributes();

            if ($_GET['where'] == 'varmatchView') {
                $model = true;
            } else {
                $model = OttoHelper::gi()->getProductModel('prepare');
            }

            die(json_encode(OttoHelper::gi()->getCategoryIndependentAttributes($independentAttributes, $_POST['SelectValue'], $model, true)));
        }

#echo "<br />\n".__METHOD__.' '.__LINE__."<br />\n";

        $independentShopVariation = false;
        if (isset($_POST['VariationKind']) && $_POST['VariationKind'] === 'IndependentShopVariation') {
            $independentShopVariation = true;
        }

        $this->savePrepare();
        $this->deletePrepare();
#echo "<br />\n".__METHOD__.' '.__LINE__."<br />\n";

        $hasNextPage = isset($_POST['matching_nextpage']) && ctype_digit($_POST['matching_nextpage']);

        if ((isset($_POST['prepare']) ||
                (isset($_GET['where']) && (($_GET['where'] == 'catMatchView') || ($_GET['where'] == 'prepareView') || ($_GET['where'] == 'varmatchView'))) ||
                $hasNextPage) && ($this->getSelectedProductsCount() > 0)
        ) {
#echo "<br />\n".__METHOD__.' '.__LINE__."<br />\n";
            $this->processMatching($independentShopVariation);
        } else {
            if (defined('MAGNA_DEV_PRODUCTLIST') && MAGNA_DEV_PRODUCTLIST === true) {
#echo "<br />\n".__METHOD__.' '.__LINE__."<br />\n";
                $this->processProductList($independentShopVariation);
            } else {
#echo "<br />\n".__METHOD__.' '.__LINE__."<br />\n";
                $this->processSelection();
            }
        }
    }

    protected function savePrepare() {
        if (!array_key_exists('savePrepareData', $_POST)) {
            if (!isset($_POST['Action']) || $_POST['Action'] !== 'SaveMatching' || $_GET['where'] === 'varmatchView') {
                return;
            }
        }

        require_once(DIR_MAGNALISTER_MODULES.'otto/classes/OttoProductSaver.php');
// print_m($_POST, '$_POST');
        $oProductSaver = new OttoProductSaver($this->resources['session']);
        $aProductIDs = MagnaDB::gi()->fetchArray("
			SELECT pID
			  FROM ".TABLE_MAGNA_SELECTION."
			 WHERE     mpID = '".$this->mpID."'
				   AND selectionname = '".$this->prepareSettings['selectionName']."'
				   AND session_id = '".session_id()."'
		", true);

        $isSinglePrepare = 1 == count($aProductIDs);
        //(isset($_POST['ml']) && isset($_POST['ml']['match'])) <-- Attribute
        $shopVariations = $this->saveMatchingAttributes($oProductSaver, $isSinglePrepare);
        $independentShopVariations = $this->saveIndependentMatchingAttributes($oProductSaver, $isSinglePrepare);

        $itemDetails = $_POST;
        $itemDetails['ShopVariation'] = $shopVariations;
        $itemDetails['CategoryIndependentShopVariation'] = json_encode($independentShopVariations);

        if ($isSinglePrepare) {
            $oProductSaver->saveSingleProductProperties($aProductIDs[0], $itemDetails);
        } else if (!empty($aProductIDs)) {
            $oProductSaver->saveMultipleProductProperties($aProductIDs, $itemDetails);
        }

        $savePrepareData = array_key_exists('savePrepareData', $_POST);

        if (count($oProductSaver->aErrors) === 0 || !$savePrepareData) {
            $isAjax = false;
            if (!$savePrepareData) {
                # stay on prepare product form
                $_POST['prepare'] = 'prepare';
                $isAjax = true;
            }
            if (!$isAjax) {
                # prepared successfully, remove from selection
                MagnaDB::gi()->delete(TABLE_MAGNA_SELECTION, array(
                    'mpID' => $this->mpID,
                    'selectionname' => $this->prepareSettings['selectionName'],
                    'session_id' => session_id()
                ));
            }
        } else {
            # stay on prepare product form
            $_POST['prepare'] = 'prepare';

            if ($savePrepareData) {
                foreach ($oProductSaver->aErrors as $sError) {
                    echo '<div class="errorBox">'.$sError.'</div>';
                }
            }
        }
    }

    protected function saveMatchingAttributes($oProductSaver, $isSinglePrepare) {

        if (isset($_POST['Variations'])) {
            parse_str_unlimited($_POST['Variations'], $params);
            $_POST = $params;
        }

        $sIdentifier = $_POST['PrimaryCategory'];
        $matching = isset($_POST['ml']['match']) ? $_POST['ml']['match'] : false;
        $variationThemeAttributes = null;

        if (isset($_POST['variationTheme']) && $_POST['variationTheme'] !== 'null') {
            $variationThemes = json_decode($_POST['variationThemes'], true);
            $variationThemeAttributes = $variationThemes[$_POST['variationTheme']]['attributes'];
        }

        $savePrepare = true;

        $oProductSaver->aErrors = array_merge($oProductSaver->aErrors,
            OttoHelper::gi()->saveMatching($sIdentifier, $matching, $savePrepare, true, $isSinglePrepare, $variationThemeAttributes));

        return json_encode($matching['ShopVariation']);
    }

    protected function saveIndependentMatchingAttributes($oProductSaver, $isSinglePrepare) {
        if (isset($_POST['Variations'])) {
            parse_str_unlimited($_POST['Variations'], $params);
            $_POST = $params;
        }

        $sIdentifier = $_POST['PrimaryCategory'];
        $matching = isset($_POST['ml']['match']) ? $_POST['ml']['match'] : false;
        $variationThemeAttributes = null;

        if (isset($_POST['variationTheme']) && $_POST['variationTheme'] !== 'null') {
            $variationThemes = json_decode($_POST['variationThemes'], true);
            $variationThemeAttributes = $variationThemes[$_POST['variationTheme']]['attributes'];
        }

        $savePrepare = true;

        $oProductSaver->aErrors = array_merge($oProductSaver->aErrors,
            OttoHelper::gi()->saveIndependentMatching($sIdentifier, $matching, $savePrepare, true, $isSinglePrepare, $variationThemeAttributes));

        return $matching['CategoryIndependentShopVariation'];
    }

    protected function deletePrepare() {
        if (!(array_key_exists('unprepare', $_POST)) || empty($_POST['unprepare'])) {
            return;
        }

        $pIDs = MagnaDB::gi()->fetchArray('
			SELECT pID FROM '.TABLE_MAGNA_SELECTION.'
			 WHERE mpID=\''.$this->mpID.'\' AND
			       selectionname=\''.$this->prepareSettings['selectionName'].'\' AND
			       session_id=\''.session_id().'\'
		', true);

        if (empty($pIDs)) {
            return;
        }
        foreach ($pIDs as $pID) {
            $where = (getDBConfigValue('general.keytype', '0') == 'artNr')
                ? array('products_model' => MagnaDB::gi()->fetchOne('
							SELECT products_model
							  FROM '.TABLE_PRODUCTS.'
							 WHERE products_id='.$pID
                ))
                : array('products_id' => $pID);
            $where['mpID'] = $this->mpID;

            MagnaDB::gi()->delete(TABLE_MAGNA_OTTO_PREPARE, $where);
            MagnaDB::gi()->delete(TABLE_MAGNA_SELECTION, array(
                'pID' => $pID,
                'mpID' => $this->mpID,
                'selectionname' => $this->prepareSettings['selectionName'],
                'session_id' => session_id()
            ));
        }
        unset($_POST['unprepare']);
    }

    protected function getSelectedProductsCount() {
        $query = '
			SELECT COUNT(*)
			FROM '.TABLE_MAGNA_SELECTION.' s
			LEFT JOIN '.TABLE_MAGNA_OTTO_PREPARE.' p on p.mpID = s.mpID and p.products_id = s.pID
			WHERE s.mpID = '.$this->mpID.'
			    AND s.selectionname = "'.$this->prepareSettings['selectionName'].'"
			    AND s.session_id = "'.session_id().'"
		';

        if (isset($_POST['match']) && $_POST['match'] === 'notmatched') {
            $query .= ' AND coalesce(p.Verified, "") != "OK"';
        }

#echo print_m($query, __METHOD__.' $query');
        return (int)MagnaDB::gi()->fetchOne($query);
    }

    protected function processMatching($independentShopVariation) {
#echo "<br />\n".__METHOD__."<br />\n";
        /*if ($this->prepareSettings['selectionName'] === 'match') {
            $className = 'MatchingPrepareView';
        } else*/
        if ($this->prepareSettings['selectionName'] === 'varmatch') {
            $className = 'VariationMatching';
        } else {
            $className = 'PrepareView';
        }

        if (($class = $this->loadResource('prepare', $className)) === false) {
            if ($this->isAjax) {
                echo '{"error": "This is not supported"}';
            } else {
                echo 'This is not supported';
            }

            return;
        }

        $params = array();
        foreach (array('mpID', 'marketplace', 'marketplaceName', 'resources', 'prepareSettings') as $attr) {
            if (isset($this->$attr)) {
                $params[$attr] = &$this->$attr;
            }
        }

        /** @var $cMDiag OttoPrepareView | OttoVariationMatching */
        $cMDiag = new $class($params);
        echo $this->isAjax ? $cMDiag->renderAjax($independentShopVariation) : $cMDiag->process();
    }

    protected function processProductList($independentShopVariation) {
        if ($this->prepareSettings['selectionName'] === 'match') {
            $className = 'MatchingProductList';
        } elseif ($this->prepareSettings['selectionName'] === 'varmatch' ||
            $_POST['action'] == 'getGambioBrands' ||
            $_POST['Action'] == 'DBMatchingColumns' ||
            $_POST['action'] == 'getOttoBrands'
        ) {
            $this->processMatching($independentShopVariation);
            return;
        } else {
            $className = 'PrepareProductList';
        }

        if (($sClass = $this->loadResource('prepare', $className)) === false) {
            if ($this->isAjax) {
                echo '{"error": "This is not supported"}';
            } else {
                echo 'This is not supported';
            }
            return;
        }
#echo print_m($sClass, __METHOD__.' '.__LINE__.' $sClass');

        $o = new $sClass();
        echo $o;
    }

    protected function processSelection() {
        if (($class = $this->loadResource('prepare', 'PrepareCategoryView')) === false) {
            if ($this->isAjax) {
                echo '{"error": "This is not supported"}';
            } else {
                echo 'This is not supported';
            }
            return;
        }
#echo print_m($class, __METHOD__.' '.__LINE__.' $class');
        $pV = new $class(null, $this->prepareSettings);
        if ($this->isAjax) {
            echo $pV->renderAjaxReply();
        } else {
            echo $pV->printForm();
        }
    }
}
