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
 * $Id: 001.sql.php 650 2011-01-08 22:30:52Z MaW $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */

# Tabellen fuer das eBay-Modul

$queries = array();
$functions = array();

/* Tabellenstruktur fuer Tabelle `magnalister_ebay_deletedlog` */
$queries[] = '
	CREATE TABLE IF NOT EXISTS `'.TABLE_MAGNA_EBAY_DELETEDLOG.'` (
		`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`products_id` INT NOT NULL ,
		`products_model` VARCHAR( 255 ) NOT NULL ,
		`mpID` INT NOT NULL ,
		`ItemID` VARCHAR( 20 ) NOT NULL ,
		`Price` FLOAT( 9, 2 ) NOT NULL ,
		`timestamp` DATETIME NOT NULL
	) ENGINE = MYISAM ;
';
