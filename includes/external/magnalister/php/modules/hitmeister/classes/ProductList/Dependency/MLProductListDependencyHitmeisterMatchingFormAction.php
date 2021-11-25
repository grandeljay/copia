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
 * (c) 2010 - 2014 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */
require_once DIR_MAGNALISTER_INCLUDES.'lib/classes/ProductList/Dependency/MLProductListDependency.php';
class MLProductListDependencyHitmeisterMatchingFormAction extends MLProductListDependency {
	public function getActionBottomLeftTemplate(){
		return 'hitmeistermatchingformleft';
	}
	
	public function getActionBottomRightTemplate(){
		return 'hitmeistermatchingformright';
	}
	
	public function getHeaderTemplate() {
		return 'hitmeistermatchingform';
	}


	public function getDefaultConfig() {
		return array(
			'selectionname' => 'general',
		);
	}
	
	public function executeAction() {
		$aRequest = $this->getActionRequest();
		if (isset($aRequest['unmatching'])) {
			$this->unmatching();
		}
		return $this;
	}
	
	protected function unmatching(){
		$pIDs = MagnaDB::gi()->fetchArray('
			SELECT pID FROM '.TABLE_MAGNA_SELECTION.'
			 WHERE mpID=\''.$this->getMagnaSession('mpID').'\' AND
				   selectionname=\''.$this->getConfig('selectionname').'\' AND
				   session_id=\''.session_id().'\'
		', true);
		if (!empty($pIDs)) {
			foreach ($pIDs as $pID) {
				$where = (getDBConfigValue('general.keytype', '0') == 'artNr')
					? array ('products_model' => MagnaDB::gi()->fetchOne('
								SELECT products_model
								  FROM '.TABLE_PRODUCTS.'
								 WHERE products_id='.$pID
							))
					: array ('products_id'    => $pID);
				$where['mpID'] = $this->getMagnaSession('mpID');
				$where['PrepareType'] = 'Match';

				MagnaDB::gi()->delete(TABLE_MAGNA_HITMEISTER_PREPARE, $where);
				MagnaDB::gi()->delete(TABLE_MAGNA_SELECTION, array(
					'pID' => $pID,
					'mpID' => $this->getMagnaSession('mpID'),
					'selectionname' => $this->getConfig('selectionname'),
					'session_id' => session_id()
				));
			}
			if ( MLProduct::gi()->hasMasterItems()) {
				// delete dummy master, if it dont have matched variant
				$sKeyType = 'products_'.((getDBConfigValue('general.keytype', '0') == 'artNr') ? 'model' : 'id');
				foreach (MagnaDB::gi()->fetchArray(eecho("
					SELECT DISTINCT m.products_id
					FROM ".TABLE_PRODUCTS." p
					INNER JOIN ".TABLE_PRODUCTS." m on p.products_master_model = m.products_model
					WHERE p.products_id in('".implode("', '",$pIDs)."')
				", false), true) as $iMaster) {
					$aMaster = MLProduct::gi()->setLanguage(getDBConfigValue('hitmeister.lang', $this->getMagnaSession('mpID'), $_SESSION['magna']['selected_language']))->getProductById($iMaster);
					$aVariants = array();
					foreach ($aMaster['Variations'] as $aVariant) {
						$aVariants[] = $aVariant[(($sKeyType == 'products_model') ? 'MarketplaceSku' : 'VariationId')];
					}
					if(
						empty($aVariants) 
						|| 0 == MagnaDb::gi()->fetchOne("SELECT COUNT(".$sKeyType.") FROM ".TABLE_MAGNA_HITMEISTER_PREPARE." WHERE mpID='".$this->getMagnaSession('mpID')."' AND ".$sKeyType." in('".implode("', '", $aVariants)."') AND PrepareType=\'Match\'")
					) {
						MagnaDB::gi()->delete(TABLE_MAGNA_HITMEISTER_PREPARE, array(
							'mpID' => $this->getMagnaSession('mpID'),
							$sKeyType => $aMaster['Products'.(($sKeyType == 'products_model') ? 'Model' : 'Id' )],
							'PrepareType' => 'Match'
						));
					}
				}
			}
		}
	}
	
}
