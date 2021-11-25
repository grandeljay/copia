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
 * $Id: checkin.php 1174 2011-07-30 17:49:04Z derpapst $
 *
 * (c) 2011 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class HoodPrepare extends MagnaCompatibleBase {

	protected $prepareSettings = array();

	public function __construct(&$params) {
		parent::__construct($params);

		$this->prepareSettings['selectionName'] = 'prepare';
		$this->resources['url']['mode'] = $this->prepareSettings['selectionName'];
	}
	
	protected function saveMatching() {
		if (!array_key_exists('savePrepareData', $_POST)) {
			return;
		}
		
		//echo print_m($_POST, '$_POST');
		
		require_once(DIR_MAGNALISTER_MODULES . 'hood/classes/HoodProductSaver.php');
		require_once(DIR_MAGNALISTER_MODULES . 'hood/checkin/HoodCheckinSubmit.php');
		
		$itemDetails = $_POST;
		unset($itemDetails['savePrepareData']);
		#echo print_m($itemDetails, '$itemDetails');
		
		$hoodSaver = new HoodProductSaver($this->resources['session']);
		
		$pIDs = MagnaDB::gi()->fetchArray('
			SELECT pID FROM ' . TABLE_MAGNA_SELECTION . '
			 WHERE mpID="' . $this->mpID . '" AND
				   selectionname="' . $this->prepareSettings['selectionName'] . '" AND
				   session_id="' . session_id() . '"
		', true);
		
		if (1 == count($pIDs)) {
			$hoodSaver->saveSingleProductProperties($pIDs[0], $itemDetails);
		} else if (!empty($pIDs)) {
			$hoodSaver->saveMultipleProductProperties($pIDs, $itemDetails);
		}
		
		$ecs = new HoodCheckinSubmit(array(
			'selectionName' => $this->prepareSettings['selectionName'],
			'marketplace' => 'hood',
		));
		
		#echo print_m($ecs->verifyOneItem(), '$ecs->verifyOneItem()');
		$verified = $ecs->verifyOneItem(false);
		if ('SUCCESS' == $verified['STATUS']) {
			MagnaDB::gi()->delete(TABLE_MAGNA_SELECTION, array(
				'mpID' => $this->mpID,
				'selectionname' => $this->prepareSettings['selectionName'],
				'session_id' => session_id()
			));
			if (isset($verified['CONFIRMATIONS']) && is_array($verified['CONFIRMATIONS'])) {
				foreach ($verified['CONFIRMATIONS'] as $value) {
					echo '
						<div class="hood successBox">'.sprintf(ML_HOOD_LABEL_ADDITEM_COSTS, $value['Costs']).'</div>';
					break;
				}
			}
			
		} else if ('ERROR' == $verified['STATUS']) {
			# noch mal in der Maske bleiben
			$_POST['prepare'] = 'prepare';
	
			/* Letzte Exception holen */
			$ex = $ecs->getLastException();
			if (is_object($ex) && ($errors = $ex->getErrorArray())) {
				$ex->setCriticalStatus(false);
				foreach ($errors['ERRORS'] as $error) {
					echo '
						<div class="hood errorBox">
							<span class="error">' . sprintf(ML_HOOD_LABEL_HOODERROR, $error['ERRORCODE']) . '</span>:
							'.fixHTMLUTF8Entities($error['ERRORMESSAGE']).'
						</div>';
				}
			}
		}
		//echo print_m(json_indent($ecs->getLastRequest()));
	}
	
	protected function deleteMatching() {
		if (!(array_key_exists('unprepare', $_POST)) || empty($_POST['unprepare'])) {
			return;
		}
		$pIDs = MagnaDB::gi()->fetchArray('
			SELECT pID FROM '.TABLE_MAGNA_SELECTION.'
			 WHERE mpID="'.$this->mpID.'" AND
			       selectionname="'.$this->prepareSettings['selectionName'].'" AND
			       session_id="'.session_id().'"
		', true);
		if (empty($pIDs)) {
			return;
		}
		
		foreach ($pIDs as $pID) {
			$where = (getDBConfigValue('general.keytype', '0') == 'artNr')
				? array ('products_model' => MagnaDB::gi()->fetchOne('
							SELECT products_model
							  FROM '.TABLE_PRODUCTS.'
							 WHERE products_id='.$pID
						))
				: array ('products_id' => $pID);
			$where['mpID'] = $this->mpID;
			
			MagnaDB::gi()->delete(TABLE_MAGNA_HOOD_PROPERTIES, $where);
			MagnaDB::gi()->delete(TABLE_MAGNA_SELECTION, array(
				'pID' => $pID,
				'mpID' => $this->mpID,
				'selectionname' => $this->prepareSettings['selectionName'],
				'session_id' => session_id()
			));
		}
		unset($_POST['unprepare']);
	}
	
	protected function resetShopData() {
		if (!(array_key_exists('reset_description', $_POST)) || empty($_POST['reset_description'])) {
			return;
		}
		$pIDs = MagnaDB::gi()->fetchArray('
			SELECT pID FROM '.TABLE_MAGNA_SELECTION.'
			 WHERE mpID="'.$this->mpID.'" AND
			       selectionname="'.$this->prepareSettings['selectionName'].'" AND
			       session_id="'.session_id().'"
		', true);
		if (empty($pIDs)) {
			return;
		}
		
		require_once(DIR_MAGNALISTER_MODULES . 'hood/classes/HoodProductSaver.php');
		$hoodSaver = new HoodProductSaver($this->resources['session']);
		
		foreach ($pIDs as $pID) {
			$hoodSaver->resetProductProperties($pID);
			
			MagnaDB::gi()->delete(TABLE_MAGNA_SELECTION, array(
				'pID' => $pID,
				'mpID' => $this->mpID,
				'selectionname' => $this->prepareSettings['selectionName'],
				'session_id' => session_id()
			));
		}
		
		unset($_POST['reset_description']);
	}
	
	protected function processMatching() {
		if (($class = $this->loadResource('prepare', 'PrepareView')) === false) {
			if ($this->isAjax) {
				echo '{"error": "This is not supported"}';
			} else {
				echo 'This is not supported';
			}
			return;
		}
	
		$params = array();
		foreach (array('mpID', 'marketplace', 'marketplaceName', 'resources') as $attr) {
			if (isset($this->$attr)) {
				$params[$attr] = &$this->$attr;
			}
		}

		$cMDiag = new $class($params);

		if ($this->isAjax) {
			echo $cMDiag->renderAjax();
		} else {
			$html = $cMDiag->process();
			echo $html;
		}
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
		$pV = new $class(
			null,
			$this->prepareSettings,
			isset($_GET['sorting'])   ? $_GET['sorting']   : false,
			isset($_POST['tfSearch']) ? $_POST['tfSearch'] : ''
		);
		if ($this->isAjax) {
			echo $pV->renderAjaxReply();
		} else {
			echo $pV->printForm();
		}
	}
	
	protected function processProductList() {
		if (($sClass = $this->loadResource('prepare', 'PrepareProductList')) === false) {
			if ($this->isAjax) {
				echo '{"error": "This is not supported"}';
			} else {
				echo 'This is not supported';
			}
			return;
		}
		$o = new $sClass();
		echo $o;
	}

	public function process() {
		$this->saveMatching();
		if (isset($_POST['prepare']) || (isset($_GET['where']) && ($_GET['where'] == 'prepareView'))) {
			$this->processMatching();
		} else {
			if (defined('MAGNA_DEV_PRODUCTLIST') && MAGNA_DEV_PRODUCTLIST === true ) {
				$this->processProductList();
			} else {
				$this->deleteMatching();
				$this->resetShopData();
				$this->processSelection();
			}
		}
	}

}
