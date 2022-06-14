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

$queries = array();
$functions = array();

$queries[] = "CREATE TABLE IF NOT EXISTS `".TABLE_MAGNA_RICARDO_PROPERTIES."` (
  `mpID` int(8) NOT NULL,
  `products_id` int(11) NOT NULL,
  `products_model` varchar(64) NOT NULL,
  `MarketplaceCategories` text NOT NULL,
  `TopMarketplaceCategory` varchar(20) NOT NULL,
  `TitleDe` varchar(40),
  `TitleFr` varchar(40),
  `SubtitleDe` varchar(60),
  `SubtitleFr` varchar(60),
  `DescriptionDe` text,
  `DescriptionFr` text,
  `PictureUrl` varchar(400),
  `ArticleCondition` tinyint,
  `BuyingMode` char(10),
  `StartDate` date,
  `EndTime` time,
  `Duration` tinyint,
  `MaxRelistCount` int,
  `Warranty` bit,
  `WarrantyDescriptionDe` text,
  `WarrantyDescriptionFr` text,
  `PaymentDetails` int,
  `PaymentdetailsDescriptionDe` text,
  `PaymentdetailsDescriptionFr` text,
  `ShippingDetails` tinyint,
  `ShippingCost` decimal(15, 4),
  `PackageSize` tinyint,
  `ShippingDescriptionDe` text,
  `ShippingDescriptionFr` text,
  `BuyNowPrice` decimal(15, 4),
  `StartPrice` decimal(15, 4),
  `Increment` decimal(15, 4),
  `Availability` tinyint,
  `FirstPromotion` smallint,
  `SecondPromotion` smallint,
  `LangDe` varchar(20),
  `LangFr` varchar(20),
  `Verified` enum('OK','ERROR','OPEN','EMPTY') NOT NULL DEFAULT 'OPEN',
  `PreparedTS` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`mpID`, `products_id`, `products_model`)
) ENGINE=MyISAM";