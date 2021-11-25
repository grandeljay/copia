# -----------------------------------------------------------------------------------------
#  $Id: update_2.0.5.0_to_2.0.5.1.sql 12688 2020-04-09 17:09:51Z Tomcraft $
#
#  modified eCommerce Shopsoftware
#  http://www.modified-shop.org
#
#  Copyright (c) 2009 - 2013 [www.modified-shop.org]
#  -----------------------------------------------------------------------------------------

#Tomcraft - 2018-06-11 - changed database_version
INSERT INTO `database_version` (`version`) VALUES ('MOD_2.0.5.1');

#GTB - 2019-11-18 - Force Cookie Usage, see: https://trac.modified-shop.org/changeset/12419
UPDATE `configuration` SET `configuration_value` = 'True' WHERE `configuration_key` = 'SESSION_FORCE_COOKIE_USE';

#Tomcraft - 2020-03-10 - removed blz update again due to r12625, so the database structure update will not add the field again
ALTER TABLE `admin_access` DROP `blz_update`;

#Tomcraft - 2020-03-10 - removed start again due to r12626, so the database structure update will not add the field again
ALTER TABLE `admin_access` DROP `start`;

#Tomcraft - 2020-03-12 - Extend customers & products discount fields for 100% discount
ALTER TABLE `customers_status` MODIFY `customers_status_discount` DECIMAL(5,2) DEFAULT '0.00';
ALTER TABLE `customers_status` MODIFY `customers_status_ot_discount` DECIMAL(5,2) DEFAULT '0.00';
ALTER TABLE `orders` MODIFY `customers_status_discount` DECIMAL(5,2);
ALTER TABLE `orders_products` MODIFY `products_discount_made` DECIMAL(5,2) DEFAULT NULL;
ALTER TABLE `products` MODIFY `products_discount_allowed` DECIMAL(5,2) NOT NULL DEFAULT '0.00';

#GTB - 2020-03-24 - update campaigns
ALTER TABLE `orders` CHANGE `refferers_id` `campaign` VARCHAR(32) NOT NULL;
ALTER TABLE `customers` MODIFY `refferers_id` INT(11);

#GTB - 2020-04-07 - delete obsolete configuration
DELETE FROM `configuration` WHERE `configuration_key` = 'CONFIG_CALCULATE_IMAGE_SIZE';

# Keep an empty line at the end of this file for the db_updater to work properly