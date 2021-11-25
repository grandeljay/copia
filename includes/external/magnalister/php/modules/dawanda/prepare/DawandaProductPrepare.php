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
 * $Id: DawandaProductPrepare.php 3830 2014-05-06 13:00:00Z tim.neumann $
 *
 * (c) 2011 - 2014 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */

class DaWandaProductPrepare {
	protected $aResources;
	protected $sMpId = '';
	protected $sMarketplace = '';
	protected $bIsAjax = false;
	protected $aPrepareSettings = array();

	#protected $oProductSaver = null;

	public function __construct(&$resources) {
		$this->aResources = &$resources;

		$this->sMpId = $this->aResources['session']['mpID'];
		$this->sMarketplace = $this->aResources['session']['currentPlatform'];

		$this->bIsAjax = isset($_GET['kind']) && ($_GET['kind'] == 'ajax');

		$this->aPrepareSettings['selectionName'] = 'prepare';

		#$this->oProductSaver = new DaWandaProductPrepareSaver($this->aResources, $this->aPrepareSettings);
	}
}
