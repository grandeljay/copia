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

define('ML_LOG_INVENTORY_CHANGE', true);

require_once(DIR_MAGNALISTER_CALLBACK.'callbackFunctions.php');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');

function magnaAutosyncInventories() {
	global $_MagnaShopSession, $magnaConfig;

	/* {Hook} "PreSyncInventory": Runs before synchronization from shop to the marketplaces starts.
	    Useful e.g. if you have an external data source for stock keeping.
	    You can fill the correct product's quantities into the shop's tables before synchronizing to the marketplaces.
	*/
	if (($hp = magnaContribVerify('PreSyncInventory', 1)) !== false) {
	    require($hp);
	}

	$verbose = isset($_GET['MLDEBUG']) && ($_GET['MLDEBUG'] == 'true');

	if ($verbose) {
		echo '#######################################'."\n##\n".
			 '## '.(defined('ML_LABEL_SYNC_INVENTORY_LOG') 
					? ML_LABEL_SYNC_INVENTORY_LOG 
					: 'Begin of protocoll: InventorySync Shop > Marketplace'
		);
		if (isset($_GET['continue'])) {
			echo (defined('ML_LABEL_SYNC_CONTINUE_MODE')
				? ' ('.ML_LABEL_SYNC_CONTINUE_MODE.')'
				: ' (in continue mode)'
			);
		}
	 	echo "\n##\n".'#######################################'."\n";
		$_timer = microtime(true);
	}
	
	MagnaDB::gi()->logQueryTimes(false);
	MagnaConnector::gi()->setTimeOutInSeconds(600);
	
	$modules = magnaGetInvolvedMarketplaces();
	foreach ($modules as $marketplace) {
		$mpIDs = magnaGetInvolvedMPIDs($marketplace);
		if (empty($mpIDs)) {
			//if (function_exists('ml_debug_out')) ml_debug_out('Skip[2] ('.$marketplace.' not booked)'."\n");
			continue;
		}
		foreach ($mpIDs as $mpID) {
			@set_time_limit(60 * 10); // 10 minutes per module
			
			$funcName = false;
			$className = false;

			$funcFile = DIR_MAGNALISTER_MODULES.$marketplace.'/'.$marketplace.'Functions.php';
			$classFile = DIR_MAGNALISTER_MODULES.strtolower($marketplace).'/crons/'.ucfirst($marketplace).'SyncInventory.php';
	
			if (file_exists($classFile)) {
				require_once($classFile);
				$className = ucfirst($marketplace).'SyncInventory';
				if (!class_exists($className)) {
					if ($verbose) echo 'Class '.$className.' not found.'."\n";
					continue;
				}
			} else if (file_exists($funcFile)) {
				require_once($funcFile);
				$funcName = 'autoupdate'.ucfirst($marketplace).'Inventory';
				
				if (!function_exists($funcName)) {
					if ($verbose) echo 'Function '.$funcName.' not found.'."\n";
					continue;
				}
			} else {
				if ($verbose) echo 'No sync functions available for '.$marketplace.' ('.$mpID.').'."\n";
				continue;
			}

			if (!array_key_exists('db', $magnaConfig) || 
			    !array_key_exists($mpID, $magnaConfig['db'])
			) {
				loadDBConfig($mpID);
			}
			#echo print_m("MP: $marketplace  MPID: $mpID");

			if ($className !== false) {
				if (function_exists('ml_debug_out')) ml_debug_out("\n\n\n#####\n## Sync $marketplace ($mpID) with class $className\n##\n");
				$ic = new $className($mpID, $marketplace);
				$ic->process();
			} else {
				if (function_exists('ml_debug_out')) ml_debug_out("\n\n\n#####\n## Sync $marketplace ($mpID) with function $funcName\n##\n");
				$funcName($mpID);
			}
		}
		#echo print_m($mpIDs, $marketplace);
	}
	
	MagnaConnector::gi()->resetTimeOut();
	MagnaDB::gi()->logQueryTimes(true);
	
	if ($verbose) {
		echo "\n\nComplete (".microtime2human(microtime(true) - $_timer).").\n";
		die();
	}
}
