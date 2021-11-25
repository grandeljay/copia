# -----------------------------------------------------------------------------------------
#  $Id: update_2.0.0.0_to_2.0.1.0.sql 10760 2017-06-07 10:33:38Z Tomcraft $
#
#  modified eCommerce Shopsoftware
#  http://www.modified-shop.org
#
#  Copyright (c) 2009 - 2013 [www.modified-shop.org]
#  -----------------------------------------------------------------------------------------

#Tomcraft - 2016-04-27 - changed database_version
ALTER TABLE `database_version` ADD `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ;
INSERT INTO `database_version` (`version`) VALUES ('MOD_2.0.1.0');

#GTB - 2016-04-07 - remove old admin access
ALTER TABLE admin_access DROP cache;
ALTER TABLE admin_access DROP define_language;
ALTER TABLE admin_access DROP module_paypal_install;
ALTER TABLE admin_access DROP popup_image;
ALTER TABLE admin_access DROP sofortueberweisung_install;
DELETE FROM admin_access WHERE customers_id = 'groups';
INSERT INTO `admin_access` (`customers_id`, `configuration`, `modules`, `countries`, `currencies`, `zones`, `geo_zones`, `tax_classes`, `tax_rates`, `accounting`, `backup`, `server_info`, `whos_online`, `languages`, `orders_status`, `shipping_status`, `module_export`, `customers`, `create_account`, `customers_status`, `customers_group`, `orders`, `campaigns`, `print_packingslip`, `print_order`, `popup_memo`, `coupon_admin`, `listproducts`, `listcategories`, `products_tags`, `gv_queue`, `gv_mail`, `gv_sent`, `gv_customers`, `validproducts`, `validcategories`, `mail`, `categories`, `new_attributes`, `products_attributes`, `manufacturers`, `reviews`, `specials`, `products_expected`, `stats_products_expected`, `stats_products_viewed`, `stats_products_purchased`, `stats_customers`, `stats_sales_report`, `stats_stock_warning`, `stats_campaigns`, `banner_manager`, `banner_statistics`, `module_newsletter`, `start`, `content_manager`, `content_preview`, `credits`, `orders_edit`, `csv_backend`, `products_vpe`, `cross_sell_groups`, `filemanager`, `econda`, `cleverreach`, `shop_offline`, `blz_update`, `removeoldpics`, `janolaw`, `haendlerbund`, `safeterms`, `check_update`, `easymarketing`, `it_recht_kanzlei`, `payone_config`, `payone_logs`, `protectedshops`, `parcel_carriers`, `supermailer`, `shopgate`, `newsfeed`, `logs`, `shipcloud`, `trustedshops`) VALUES ('groups', 8, 8, 7, 7, 7, 7, 7, 7, 2, 5, 5, 5, 7, 8, 8, 8, 2, 2, 2, 2, 2, 8, 2, 2, 2, 6, 6, 6, 3, 6, 6, 6, 6, 6, 6, 2, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 1, 5, 5, 1, 2, 5, 8, 8, 3, 9, 9, 8, 5, 5, 9, 9, 9, 1, 9, 9, 9, 9, 9, 5, 9, 9, 1, 5, 9, 9);

#GTB - 2016-05-04 - add date_added for orders_tracking
ALTER TABLE orders_tracking ADD date_added DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER parcel_id;
INSERT INTO `carriers` (`carrier_name`, `carrier_tracking_link`, `carrier_sort_order`, `carrier_date_added`) VALUES ('POST', 'https://www.deutschepost.de/sendung/simpleQueryResult.html?form.sendungsnummer=$1&form.einlieferungsdatum_tag=$3&form.einlieferungsdatum_monat=$4&form.einlieferungsdatum_jahr=$5', 120, NOW());

#GTB - 2016-05-18 - add states for china
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'BJ','Beijing Municipality');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'TJ','Tianjin Municipality');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'HE','Hebei Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'SX','Shanxi Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'NM','Inner Mongolia Autonomous Region');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'LN','Liaoning Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'JL','Jilin Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'HL','Heilongjiang Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'SH','Shanghai Municipality');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'JS','Jiangsu Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'ZJ','Zhejiang Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'AH','Anhui Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'FJ','Fujian Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'JX','Jiangxi Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'SD','Shandong Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'HA','Henan Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'HB','Hubei Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'HN','Hunan Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'GD','Guangdong Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'GX','Guangxi Zhuang Autonomous Region');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'HI','Hainan Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'CQ','Chongqing Municipality');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'SC','Sichuan Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'GZ','Guizhou Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'YN','Yunnan Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'XZ','Tibet Autonomous Region');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'SN','Shaanxi Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'GS','Gansu Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'QH','Qinghai Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'NX','Ningxia Hui Autonomous Region');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'XJ','Xinjiang Uyghur Autonomous Region');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'HK','Hong Kong Special Administrative Region');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'MC','Macau Special Administrative Region');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,44,'TW','Taiwan Province');

#GTB - 2016-05-18 - add states for argentina
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'CF','Ciudad de Buenos Aires (Distrito Federal)');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'BA','Buenos Aires');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'CT','Catamarca');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'CC','Chaco');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'CH','Chubut');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'CD','C�rdoba');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'CR','Corrientes');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'ER','Entre R�os');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'FO','Formosa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'JY','Jujuy');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'LP','La Pampa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'LR','La Rioja');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'MZ','Mendoza');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'MN','Misiones');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'NQ','Neuqu�n');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'RN','R�o Negro');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'SA','Salta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'SJ','San Juan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'SL','San Luis');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'SC','Santa Cruz');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'SF','Santa Fe');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'SE','Santiago del Estero');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'TF','Tierra del Fuego');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,10,'TM','Tucum�n');

#GTB - 2016-05-18 - add states for indonesia
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'AC','Aceh');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'BA','Bali');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'BB','Babel');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'BT','Banten');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'BE','Bengkulu');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'JT','Jateng');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'KT','Kalteng');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'ST','Sulteng');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'JI','Jatim');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'KI','Kaltim');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'NT','NTT');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'GO','Gorontalo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'JK','DKI');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'JA','Jambi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'LA','Lampung');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'MA','Maluku');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'KU','Kaltara');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'MU','Malut');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'SA','Sulut');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'SU','Sumut');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'PA','Papua');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'RI','Riau');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'KR','Kepri');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'SG','Sultra');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'KS','Kalsel');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'SN','Sulsel');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'SS','Sumsel');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'JB','Jabar');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'KB','Kalbar');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'NB','NTB');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'PB','Papuabarat');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'SR','Sulbar');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'SB','Sumbar');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,100,'YO','DIY');

#GTB - 2016-05-18 - add states for thailand
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'10','Bangkok');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'37','Amnat Charoen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'15','Ang Thong');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'38','Bueng Kan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'31','Buriram');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'24','Chachoengsao');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'18','Chai Nat');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'36','Chaiyaphum');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'22','Chanthaburi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'50','Chiang Mai');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'57','Chiang Rai');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'20','Chonburi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'86','Chumphon');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'46','Kalasin');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'62','Kamphaeng Phet');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'71','Kanchanaburi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'40','Khon Kaen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'81','Krabi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'52','Lampang');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'51','Lamphun');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'42','Loei Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'16','Lopburi Province');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'58','Mae Hong Son');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'44','Maha Sarakham');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'49','Mukdahan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'26','Nakhon Nayok');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'73','Nakhon Pathom');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'48','Nakhon Phanom');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'30','Nakhon Ratchasima');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'60','Nakhon Sawan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'80','Nakhon Si Thammarat');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'55','Nan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'96','Narathiwat');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'39','Nong Bua Lam Phu');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'43','Nong Khai');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'12','Nonthaburi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'13','Pathum Thani');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'94','Pattani');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'82','Phang Nga');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'93','Phatthalung');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'56','Phayao');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'67','Phetchabun');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'76','Phetchaburi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'66','Phichit');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'65','Phitsanulok');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'14','Phra Nakhon Si Ayutthaya');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'54','Phrae');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'83','Phuket');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'25','Prachinburi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'77','Prachuap Khiri Khan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'85','Ranong');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'70','Ratchaburi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'21','Rayong');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'45','Roi Et');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'27','Sa Kaeo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'47','Sakon Nakhon');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'11','Samut Prakan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'74','Samut Sakhon');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'75','Samut Songkhram');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'19','Saraburi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'91','Satun');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'17','Sing Buri');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'33','Sisaket');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'90','Songkhla');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'64','Sukhothai');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'72','Suphan Buri');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'84','Surat Thani');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'32','Surin');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'63','Tak');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'92','Trang');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'23','Trat');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'34','Ubon Ratchathani');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'41','Udon Thani');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'61','Uthai Thani');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'53','Uttaradit');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'95','Yala');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,209,'35','Yasothon');

#GTB - 2016-05-18 - insert kosovo
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id, status, required_zones) VALUES (242,'Kosovo','CS','SCG',1,1,0);
INSERT INTO `zones_to_geo_zones` (`association_id`, `zone_country_id`, `zone_id`, `geo_zone_id`, `last_modified`, `date_added`) VALUES (242, 242, 0, 6, NULL, NOW());

#Tomcraft - 2016-06-06 - Remove obsolete configuration_key COMPRESS_STYLESHEET_TIME (since r7607)
DELETE FROM configuration WHERE configuration_key = 'COMPRESS_STYLESHEET_TIME';

#Tomcraft - 2016-06-07 - insert missing zones_to_geo_zones from r975 for Serbia (ID 240) and Montenegro (ID 241)
INSERT INTO `zones_to_geo_zones` (`association_id`, `zone_country_id`, `zone_id`, `geo_zone_id`, `last_modified`, `date_added`) VALUES (240, 240, 0, 6, NULL, NOW());
INSERT INTO `zones_to_geo_zones` (`association_id`, `zone_country_id`, `zone_id`, `geo_zone_id`, `last_modified`, `date_added`) VALUES (241, 241, 0, 6, NULL, NOW());

#Tomcraft - 2016-06-07 - Display duty info for geo_zone_id 6
UPDATE geo_zones SET geo_zone_info = '1' WHERE geo_zone_id = '6';

#GTB - 2016-06-09 - add index products_tags
ALTER TABLE `products_tags` ADD INDEX idx_options_id (`options_id`);
ALTER TABLE `products_tags` ADD INDEX idx_values_id (`values_id`);

#GTB - 2016-06-17 - extend reviews for status
ALTER TABLE customers_status ADD customers_status_reviews_status INT(1) NOT NULL DEFAULT 1 AFTER customers_status_read_reviews;
ALTER TABLE reviews ADD reviews_status INT(1) NOT NULL DEFAULT 1 AFTER reviews_read;

#GTB - 2016-07-15 - new brute force method
ALTER TABLE banktransfer MODIFY banktransfer_owner_email VARCHAR(255) DEFAULT NULL;
ALTER TABLE campaigns_ip MODIFY user_ip VARCHAR(50) NOT NULL;
ALTER TABLE coupon_email_track MODIFY emailed_to VARCHAR(255) DEFAULT NULL;
ALTER TABLE coupon_gv_queue MODIFY ipaddr VARCHAR(50) NOT NULL DEFAULT '';
ALTER TABLE coupon_redeem_track MODIFY redeem_ip VARCHAR(50) NOT NULL DEFAULT '';
ALTER TABLE customers MODIFY customers_email_address VARCHAR(255) NOT NULL;
ALTER TABLE customers DROP customers_login_tries;
ALTER TABLE customers DROP customers_login_time;
ALTER TABLE customers_ip MODIFY customers_ip VARCHAR(50) NOT NULL DEFAULT '';
DROP TABLE IF EXISTS customers_login;
CREATE TABLE customers_login ( 
  customers_ip varchar(50) DEFAULT NULL, 
  customers_email_address varchar(255) DEFAULT NULL, 
  customers_login_tries int(11) NOT NULL, 
  KEY idx_customers_ip (customers_ip), 
  KEY idx_customers_email_address (customers_email_address) 
); 
ALTER TABLE newsletter_recipients MODIFY customers_email_address VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE newsletter_recipients MODIFY ip_date_added VARCHAR(50) DEFAULT NULL;
ALTER TABLE newsletter_recipients MODIFY ip_date_confirmed VARCHAR(50) DEFAULT NULL;
ALTER TABLE orders MODIFY customers_email_address VARCHAR(255) NOT NULL;
ALTER TABLE orders MODIFY customers_ip VARCHAR(50) NOT NULL;
ALTER TABLE whos_online MODIFY ip_address VARCHAR(50) NOT NULL;

#GTB - 2016-07-20 - change name length
ALTER TABLE orders MODIFY customers_name VARCHAR(128) NOT NULL;
ALTER TABLE orders MODIFY delivery_name VARCHAR(128) NOT NULL;
ALTER TABLE orders MODIFY billing_name VARCHAR(128) NOT NULL;

#GTB - 2016-07-26 - add blacklist_logs
ALTER TABLE admin_access ADD blacklist_logs INT(1) NOT NULL DEFAULT 0 AFTER trustedshops;
UPDATE admin_access SET blacklist_logs = 1 WHERE customers_id = 1 LIMIT 1;
UPDATE admin_access SET blacklist_logs = 5 WHERE customers_id = 'groups' LIMIT 1;

# Keep an empty line at the end of this file for the db_updater to work properly