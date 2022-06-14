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
 * $Id: modules.php 5082 2015-01-27 15:58:22Z Soprex $
 *
 * (c) 2010 - 2012 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */

/* Available modules accessable as pages */
$_modules = array(
	'amazon' => array(
		'title' => ML_MODULE_AMAZON,
		'logo' => 'amazon',
		'displayAlways' => true,
		'requiredConfigKeys' => array (
			'amazon.firstactivation',
			'amazon.username', 
			'amazon.password', 
			'amazon.merchantid', 
			'amazon.marketplaceid', 
			'amazon.lang',
			'amazon.internationalShipping', 
			'amazon.mwstfallback', 
			/*//{search: 1427198983}
			'amazon.mwst.shipping', 
			 //*/
			'amazon.quantity.type', 
			'amazon.leadtimetoship', 
			'amazon.price.addkind', 
			'amazon.import', 
			'amazon.orderstatus.open', 
			'amazon.orderstatus.fba', 
			'amazon.orderstatus.sync', 
			'amazon.orderstatus.shipped', 
			'amazon.orderstatus.carrier.default', 
			'amazon.orderstatus.cancelled', 
			'amazon.stocksync.tomarketplace', 
			'amazon.stocksync.frommarketplace', 
			'amazon.mail.send'
			//'amazon.CustomerGroup', /* gibt es nicht in osCommerce */
		),
		'pages' => array (
			'prepare' => array (
				'title' => ML_AMAZON_PRODUCT_PREPARE,
				'views' => array (
					'apply' => ML_AMAZON_NEW_ITMES,
					'match' => ML_AMAZON_PRODUCT_MATCHING,
				)
			),
			#'apply' => ML_AMAZON_NEW_ITMES,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
				),
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'prepare',
			'subsystem' => 'Amazon',
			'currency' => '__depends__',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'ebay' => array (
		'title' => ML_MODULE_EBAY,
		'logo' => 'ebay',
		'displayAlways' => true,
		'requiredConfigKeys' => array (
			'ebay.firstactivation',
			'ebay.token',
			'ebay.lang',
		),
		'pages' => array (
			'prepare' => ML_GENERIC_PREPARE,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
				)
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'prepare',
			'subsystem' => 'eBay',
			'currency' => '__depends__',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'yatego' => array(
		'title' => ML_MODULE_YATEGO,
		'logo' => 'yatego',
		'displayAlways' => false,
		'referer' => array('yatego.com'),
		'requiredConfigKeys' => array (
			'yatego.firstactivation',
			'yatego.username',
			'yatego.password',
			'yatego.lang',
			'yatego.shipping.country',
			'yatego.shipping.method',
			'yatego.shipping.cost',
			'yatego.quantity.type',
			'yatego.quantity.value',
			'yatego.stocksync.frommarketplace',
			'yatego.stocksync.tomarketplace',
			'yatego.import',
			//'yatego.CustomerGroup', /* gibt es nicht in osCommerce */
			'yatego.orderstatus.open',
			//'yatego.orderstatus.cancelled',
			//'yatego.orderstatus.shipped',
			/*//{search: 1427198983}
			'yatego.mwst.shipping',
			//*/			
			'yatego.mail.send',
		),
		'pages' => array (
			'catmatch' => ML_YATEGO_CATEGORY_MATCHING,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
					'failed' => ML_GENERIC_FAILED
				)
			),
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'checkin',
			'subsystem' => 'Yatego',
			'currency' => 'EUR',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'meinpaket' => array(
		'title' => ML_MODULE_MEINPAKET,
		'logo' => 'meinpaket',
		'displayAlways' => true,
		'referer' => array('meinpaket.de'),
		'requiredConfigKeys' => array (
			'meinpaket.username',
			'meinpaket.password',
			'meinpaket.lang',
			'meinpaket.quantity.type',
			'meinpaket.quantity.value',
			'meinpaket.stocksync.frommarketplace',
			'meinpaket.stocksync.tomarketplace',
			'meinpaket.import',
			'meinpaket.orderstatus.open',
			'meinpaket.mwst.fallback',
			/*//{search: 1427198983}
			'meinpaket.mwst.shipping',
			//*/
			'meinpaket.orderstatus.shipped',
			'meinpaket.orderstatus.sync',
			'meinpaket.orderstatus.cancelled.customerrequest',
			'meinpaket.orderstatus.cancelled.outofstock',
			'meinpaket.orderstatus.cancelled.damagedgoods',
			'meinpaket.orderstatus.cancelled.dealerrequest',
		),
		'pages' => array (
			'prepare' => array (
				'title' => ML_GENERIC_PREPARE,
				'views' => array (
					'apply' => ML_AMAZON_NEW_ITMES,
					'varmatch' => ML_MEINPAKET_VARIANT_MATCHING,
				),
			),
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
				),
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'prepare',
			'subsystem' => 'Meinpaket',
			'currency' => 'EUR',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'hitmeister' => array(
		'title' => ML_MODULE_HITMEISTER,
		'logo' => 'hitmeister',
		'displayAlways' => false,
		'requiredConfigKeys' => array (
			'hitmeister.firstactivation',
			'hitmeister.ident',
			'hitmeister.accesskey',
			'hitmeister.lang',
			'hitmeister.shippingtime',
			'hitmeister.itemcondition',
			'hitmeister.itemcountry',
			'hitmeister.import',
		),
		'pages' => array (
			'prepare' => ML_GENERIC_PREPARE,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
//					'failed' => ML_GENERIC_FAILED
				)
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'prepare',
			'subsystem' => 'Hitmeister',
			'currency' => 'EUR',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'guenstiger' => array(
		'title' => ML_MODULE_GUENSTIGER,
		'logo' => 'guenstiger',
		'displayAlways' => false,
		'referer' => array('guenstiger.de'),
		'requiredConfigKeys' => array (
			'guenstiger.lang',
			'guenstiger.inventorysync',
			'guenstiger.shipping.country',
			'guenstiger.shipping.method',
			'guenstiger.shipping.cost',
		),
		'pages' => array (
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
					'failed' => ML_GENERIC_FAILED
				)
			),
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'subsystem' => 'ComparisonShopping',
			'currency' => 'EUR',
			'hasOrderImport' => false,
		),
		'type' => 'marketplace',
	),
	'getdeal' => array(
		'title' => ML_MODULE_GETDEAL,
		'logo' => 'getdeal',
		'displayAlways' => false,
		'referer' => array('getdeal.de'),
		'requiredConfigKeys' => array (
			'getdeal.lang',
			'getdeal.inventorysync',
			'getdeal.shipping.country',
			'getdeal.shipping.method',
			'getdeal.shipping.cost',
		),
		'pages' => array (
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
					'failed' => ML_GENERIC_FAILED
				)
			),
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'subsystem' => 'ComparisonShopping',
			'currency' => 'EUR',
			'hasOrderImport' => false,
		),
		'type' => 'marketplace',
	),	
	'idealo' => array(
		'title' => ML_MODULE_IDEALO,
		'logo' => 'idealo',
		'displayAlways' => false,
		'referer' => array('idealo.de'),
		'requiredConfigKeys' => array (
			'idealo.lang',
			'idealo.inventorysync',
			'idealo.shipping.country',
			'idealo.shipping.method',
			'idealo.shipping.cost',
		),
		'pages' => array (
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
					'failed' => ML_GENERIC_FAILED
				)
			),
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'subsystem' => 'ComparisonShopping',
			'currency' => 'EUR',
			'hasOrderImport' => false,
		),
		'type' => 'marketplace',
	),
	'kelkoo' => array(
		'title' => ML_MODULE_KELKOO,
		'logo' => 'kelkoo',
		'displayAlways' => false,
		'referer' => array('kelkoo.de'),
		'requiredConfigKeys' => array (
			'kelkoo.lang',
			'kelkoo.inventorysync',
			'kelkoo.shipping.country',
			'kelkoo.shipping.method',
			'kelkoo.shipping.cost',
		),
		'pages' => array (
			//'prepare' => ML_GENERIC_PREPARE,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
					'failed' => ML_GENERIC_FAILED
				)
			),
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'subsystem' => 'ComparisonShopping',
			'currency' => 'EUR',
			'hasOrderImport' => false,
		),
		'type' => 'marketplace',
	),
	'preissuchmaschine' => array(
		'title' => ML_MODULE_PREISSUCHMASCHINE,
		'logo' => 'preissuchmaschine',
		'displayAlways' => false,
		'referer' => array('preissuchmaschine.de', 'preissuchmaschine.ch'),
		'requiredConfigKeys' => array (
			'preissuchmaschine.lang',
			'preissuchmaschine.inventorysync',
			'preissuchmaschine.shipping.country',
			'preissuchmaschine.shipping.method',
			'preissuchmaschine.shipping.cost',
		),
		'pages' => array (
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
					'failed' => ML_GENERIC_FAILED
				)
			),
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'subsystem' => 'ComparisonShopping',
			'currency' => 'EUR',
			'hasOrderImport' => false,
		),
		'type' => 'marketplace',
	),
	'billiger' => array(
		'title' => ML_MODULE_BILLIGER,
		'logo' => 'billiger',
		'displayAlways' => false,
		'referer' => array('billiger.de'),
		'requiredConfigKeys' => array (
			'billiger.lang',
			'billiger.inventorysync',
			'billiger.shipping.country',
			'billiger.shipping.method',
			'billiger.shipping.cost',
		),
		'pages' => array (
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
					'failed' => ML_GENERIC_FAILED
				)
			),
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'subsystem' => 'ComparisonShopping',
			'currency' => 'EUR',
			'hasOrderImport' => false,
		),
		'type' => 'marketplace',
	),
	'daparto' => array(
		'title' => ML_MODULE_DAPARTO,
		'logo' => 'daparto',
		'displayAlways' => false,
		'referer' => array('daparto.de'),
		'requiredConfigKeys' => array (
			'daparto.tecdoc',
			'daparto.condition',
			'daparto.lang',
			'daparto.inventorysync',
			'daparto.shipping.country',
			'daparto.shipping.method',
			'daparto.shipping.cost',
		),
		'pages' => array (
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
					'failed' => ML_GENERIC_FAILED
				)
			),
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'subsystem' => 'ComparisonShopping',
			'currency' => 'EUR',
			'hasOrderImport' => false,
		),
		'type' => 'marketplace',
	),
	'laary' => array (
		'title' => ML_MODULE_LAARY,
		'logo' => 'laary',
		'displayAlways' => false,
		'requiredConfigKeys' => array (
			'laary.username',
			'laary.password',
			'laary.mpusername',
			'laary.mppassword',
			'laary.checkin.region',
			'laary.import',
		),
		'pages' => array (
			'catmatch' => ML_MEINPAKET_CATEGORY_MATCHING,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
				)
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'checkin',
			'subsystem' => 'Laary',
			'currency' => 'EUR',
			'hasOrderImport' => false,
		),
		'type' => 'marketplace',
	),
	'tradoria' => array (
		'title' => 'Rakuten',
		'logo' => 'rakuten',
		'displayAlways' => false,
		'requiredConfigKeys' => array (
			'tradoria.apikey',
			'tradoria.mpusername',
			'tradoria.mppassword',
			'tradoria.import',
		),
		'pages' => array (
			'catmatch' => ML_MEINPAKET_CATEGORY_MATCHING,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
				)
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'catmatch',
			'subsystem' => 'Tradoria',
			'currency' => 'EUR',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'lafeo' => array (
		'title' => 'lafeo',
		'logo' => 'lafeo',
		'displayAlways' => false,
		'requiredConfigKeys' => array (
			'lafeo.apikey',
			'lafeo.mpusername',
			'lafeo.mppassword',
			'lafeo.import',
		),
		'pages' => array (
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
				)
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'checkin',
			'subsystem' => 'lafeo',
			'currency' => 'EUR',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'hood' => array (
		'title' => ML_MODULE_HOOD,
		'logo' => 'hood',
		'displayAlways' => false,
		'requiredConfigKeys' => array (
			'hood.mpusername',
			'hood.mppassword',
			'hood.apikey',
		),
		'pages' => array (
			'prepare' => ML_GENERIC_PREPARE,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED
				)
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'prepare',
			'subsystem' => 'hood',
			'currency' => 'EUR',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'twenga' => array(
		'title' => ML_MODULE_TWENGA,
		'logo' => 'twenga',
		'displayAlways' => false,
		'referer' => array('twenga.de'),
		'requiredConfigKeys' => array (
			'twenga.lang',
			'twenga.inventorysync',
			'twenga.shipping.country',
			'twenga.shipping.method',
			'twenga.shipping.cost',
		),
		'pages' => array (
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED,
					'failed' => ML_GENERIC_FAILED
				)
			),
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'subsystem' => 'ComparisonShopping',
			'currency' => 'EUR',
			'hasOrderImport' => false,
		),
		'type' => 'marketplace',
	),
	'dawanda' => array (
		'title' => ML_MODULE_DAWANDA,
		'logo' => 'dawanda',
		'displayAlways' => false,
		'requiredConfigKeys' => array (
			'dawanda.mpusername',
			'dawanda.mppassword',
			'dawanda.apikey',
		),
		'pages' => array (
			'prepare' => ML_GENERIC_PREPARE,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED
				)
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'prepare',
			'subsystem' => 'DaWanda',
			'currency' => 'EUR',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'bepado' => array (
		'title' => 'bepado',
		'logo' => 'bepado',
		'displayAlways' => false,
		'requiredConfigKeys' => array (
			'bepado.access.MPUsername',
			'bepado.access.MPPassword',
			'bepado.access.ShopId',
			'bepado.access.ApiKey',
			'bepado.access.FtpUsername',
			'bepado.access.FtpPassword',
		),
		'pages' => array (
			'prepare' => ML_GENERIC_PREPARE,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED
				)
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'prepare',
			'subsystem' => 'bepado',
			'currency' => 'EUR',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'ricardo' => array (
		'title' => 'ricardo',
		'logo' => 'ricardo',
		'displayAlways' => false,
		'requiredConfigKeys' => array (
			'ricardo.access.MPUSERNAME',
			'ricardo.access.MPPASSWORD',
			'ricardo.access.LANG'
		),
		'pages' => array (
			'prepare' => ML_GENERIC_PREPARE,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED
				)
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'prepare',
			'subsystem' => 'ricardo',
			'currency' => 'CHF',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'check24' => array (
		'title' => 'check24',
		'logo' => 'check24',
		'displayAlways' => false,
		'requiredConfigKeys' => array (
			'check24.access.MPUSERNAME',
			'check24.access.MPPASSWORD',
			'check24.access.PORT',
			'check24.access.FTPSERVER',
		),
		'pages' => array (
			'prepare' => ML_GENERIC_PREPARE,
			'checkin' => ML_GENERIC_CHECKIN,
			'listings' => array (
				'title' => ML_GENERIC_LISTINGS,
				'views' => array (
					'inventory' => ML_GENERIC_INVENTORY,
					'deleted' => ML_GENERIC_DELETED
				)
			),
			'errorlog' => ML_GENERIC_ERRORLOG,
			'conf' => ML_GENERIC_CONFIGURATION,
		),
		'settings' => array (
			'defaultpage' => 'prepare',
			'subsystem' => 'check24',
			'currency' => 'EUR',
			'hasOrderImport' => true,
		),
		'type' => 'marketplace',
	),
	'more' => array (
		'title' => '&hellip;',
		'displayAlways' => true,
		'subtitle' => ML_LABEL_MORE_MODULES,
		'type' => 'system',
	),
	'configuration' => array (
		'title' => ML_MODULE_GLOBAL_CONFIG,
		'displayAlways' => true,
		'type' => 'system',
	),
	'statistics' => array (
		'title' => ML_MODULE_STATISTICS,
		'displayAlways' => true,
		'type' => 'system',
	),
	'guide' => array (
		'title' => ML_MODULE_GUIDE,
		#'label' => ML_MODULE_GUIDE,
		#'logo' => 'guide',
		'displayAlways' => true,
		'type' => 'system',
	),
);
