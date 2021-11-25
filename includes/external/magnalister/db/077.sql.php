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
 * (c) 2010 - 2015 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */

$queries = array();
$functions = array();

function ml_db_update_createCdiscountPrepareTable()
{
    MagnaDB::gi()->query("
		CREATE TABLE IF NOT EXISTS `" . TABLE_MAGNA_CDISCOUNT_PREPARE . "` (
			`mpID` int(8) NOT NULL,
			`products_id` int(11) NOT NULL,
			`products_model` varchar(64) NOT NULL,
			`EAN` VARCHAR(13) DEFAULT NULL,
			`MarketplaceCategoriesName` TEXT DEFAULT NULL,
			`PrimaryCategory` VARCHAR(30) DEFAULT NULL,
			`TopMarketplaceCategory` VARCHAR(30) DEFAULT NULL,
			`CategoryAttributes` text NOT NULL,
			`Title` varchar(132) DEFAULT NULL,
			`Subtitle` varchar(60) DEFAULT NULL,
			`Description` VARCHAR(420) DEFAULT NULL,
			`PictureUrl` text DEFAULT NULL,
			`ConditionType` VARCHAR(60) DEFAULT NULL,
			`ShippingTimeMin` int(11) NOT NULL,
			`ShippingTimeMax` char(11) NOT NULL,
			`ShippingFeeStandard` char(11) NOT NULL,
			`ShippingFeeExtraStandard` char(11) NOT NULL,
            `ShippingFeeTracked` char(11) NOT NULL,
			`ShippingFeeExtraTracked` char(11) NOT NULL,
            `ShippingFeeRegistered` char(11) NOT NULL,
   			`ShippingFeeExtraRegistered` char(11) NOT NULL,
			`Comment` text DEFAULT NULL,
			`PrepareType` enum('Apply', 'Match') NOT NULL,
			`Verified` enum('OK','ERROR','OPEN','EMPTY') NOT NULL DEFAULT 'OK',
			`PreparedTS` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY (`mpID`,`products_id`,`products_model`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8
	");
}

$functions[] = 'ml_db_update_createCdiscountPrepareTable';

$queries[] = 'CREATE TABLE IF NOT EXISTS `' . TABLE_MAGNA_CDISCOUNT_VARIANTMATCHING . '` (
	`MpId` int(11) NOT NULL,
	`MpIdentifier` varchar(50) NOT NULL,
	`CustomIdentifier` varchar(64) NOT NULL DEFAULT "",
	`ShopVariation` text NOT NULL,
	`IsValid` bit NOT NULL DEFAULT 1,
	`ModificationDate` DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\',
	PRIMARY KEY (`MpId`, `MpIdentifier`, `CustomIdentifier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8';
