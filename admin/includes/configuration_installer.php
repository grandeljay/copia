<?php
/* -----------------------------------------------------------------------------------------
   $Id: configuration_installer.php 13409 2021-02-08 17:16:46Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2012 by www.rpa-com.de

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

$cfg_install = false;
$cfg_update = false;
$cfg_group_install = false;
$cfg_group_update = false;
$values = array();
$values_update = array();
$values_group = array();
$values_group_update = array();

//##############################//

//configuration_group_id 1 --- "Mein Shop"
  $values[] = "(NULL, 'CHECKOUT_USE_PRODUCTS_SHORT_DESCRIPTION', 'true', '1', '40', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'CHECKOUT_USE_PRODUCTS_DESCRIPTION_FALLBACK_LENGTH', '300', '1', '41', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'CHECKOUT_SHOW_PRODUCTS_IMAGES', 'true', '1', '42', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'USE_SHORT_DATE_FORMAT', 'true', '1', '50', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  //$values[] = "(NULL, 'CHECKOUT_SHOW_PRODUCTS_IMAGES_STYLE', 'max-width:90px;', '1', '42', NULL, NOW(), NULL, NULL);";
  //$values[] = "(NULL, 'IBN_BILLNR', '1', '1', '99', NULL, NOW(), NULL, NULL);"; //modified 1.07
  //$values[] = "(NULL, 'IBN_BILLNR_FORMAT', '{n}-{d}-{m}-{y}', '1', '99', NULL, NOW(), NULL, NULL);"; //modified 1.07
  $values[] = "(NULL, 'USE_BROWSER_LANGUAGE', 'false', '1', '11', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";

  $values_update[] = array (
                           'values' => "configuration_group_id = '8'",
                           'configuration_key' => 'EXPECTED_PRODUCTS_SORT'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '8'",
                           'configuration_key' => 'EXPECTED_PRODUCTS_FIELD'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '4'",
                           'configuration_key' => 'STORE_COUNTRY'
                           );
  $values_update[] = array (
                           'values' => " sort_order = '5'",
                           'configuration_key' => 'STORE_ZONE'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '3'",
                           'configuration_key' => 'STORE_NAME_ADDRESS'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '6'",
                           'configuration_key' => 'STORE_OWNER_EMAIL_ADDRESS'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '7'",
                           'configuration_key' => 'EMAIL_FROM'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '1000', sort_order = '11'",
                           'configuration_key' => 'PRICE_PRECISION'
                           );

//configuration_group_id 2 --- "Minimum Werte"
  $values[] = "(NULL, 'POLICY_MIN_LOWER_CHARS', '1', '2', '12', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POLICY_MIN_UPPER_CHARS', '1', '2', '12', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POLICY_MIN_NUMERIC_CHARS', '1', '2', '12', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POLICY_MIN_SPECIAL_CHARS', '1', '2', '12', NULL, NOW(), NULL, NULL);";

  $values_update[] = array (
                           'values' => "configuration_group_id = '2'",
                           'configuration_key' => 'ENTRY_STATE_MIN_LENGTH'
                           );

//configuration_group_id 3 --- "Maximalwerte"
  $values[] = "(NULL, 'MAX_DISPLAY_PRODUCTS_CATEGORY', '10', '3', '23', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MAX_DISPLAY_ADVANCED_SEARCH_RESULTS', '10', '3', '24', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MAX_DISPLAY_PRODUCTS_HISTORY', '6', '3', '25', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MAX_DISPLAY_BESTSELLERS_DAYS', '100', '3', '15', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MAX_DISPLAY_ALSO_PURCHASED_ORDERS', '100', '3', '16', NULL, NOW(), NULL, NULL);";

//configuration_group_id 4 --- "Bild Optionen"
  $values[] = "(NULL, 'PRODUCT_IMAGE_NO_ENLARGE_UNDER_DEFAULT', 'false', '4', '2', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'PRODUCT_IMAGE_SHOW_NO_IMAGE', 'true', '4', '2', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'CATEGORIES_IMAGE_SHOW_NO_IMAGE', 'false', '4', '2', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'MANUFACTURER_IMAGE_SHOW_NO_IMAGE', 'false', '4', '2', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'PRODUCT_IMAGE_MINI_WIDTH', '80', '4', '3', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'PRODUCT_IMAGE_MINI_HEIGHT', '80', '4', '4', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'PRODUCT_IMAGE_MINI_MERGE', '', '4', '15', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'PRODUCT_IMAGE_MIDI_WIDTH', '160', '4', '5', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'PRODUCT_IMAGE_MIDI_HEIGHT', '160', '4', '6', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'PRODUCT_IMAGE_MIDI_MERGE', '', '4', '16', NULL, NOW(), NULL, NULL);";

  $values[] = "(NULL, 'CATEGORIES_IMAGE_WIDTH', '200', '4', '31', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'CATEGORIES_IMAGE_HEIGHT', '200', '4', '32', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'CATEGORIES_IMAGE_MOBILE_WIDTH', '200', '4', '33', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'CATEGORIES_IMAGE_MOBILE_HEIGHT', '200', '4', '34', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'CATEGORIES_IMAGE_LIST_WIDTH', '200', '4', '35', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'CATEGORIES_IMAGE_LIST_HEIGHT', '200', '4', '36', NULL, NOW(), NULL, NULL);";

  $values[] = "(NULL, 'MANUFACTURER_IMAGE_WIDTH', '200', '4', '51', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MANUFACTURER_IMAGE_HEIGHT', '200', '4', '52', NULL, NOW(), NULL, NULL);";

  $values[] = "(NULL, 'BANNERS_IMAGE_WIDTH', '200', '4', '60', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'BANNERS_IMAGE_HEIGHT', '200', '4', '61', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'BANNERS_IMAGE_MOBILE_WIDTH', '200', '4', '62', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'BANNERS_IMAGE_MOBILE_HEIGHT', '200', '4', '63', NULL, NOW(), NULL, NULL);";

  $values_update[] = array (
                           'values' => "sort_order = '1'",
                           'configuration_key' => 'IMAGE_QUALITY'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '1'",
                           'configuration_key' => 'IMAGE_MANIPULATOR'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '2'",
                           'configuration_key' => 'MO_PICS'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '7'",
                           'configuration_key' => 'PRODUCT_IMAGE_THUMBNAIL_WIDTH'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '8'",
                           'configuration_key' => 'PRODUCT_IMAGE_THUMBNAIL_HEIGHT'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '2'",
                           'configuration_key' => 'PRODUCT_IMAGE_NO_ENLARGE_UNDER_DEFAULT'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '2'",
                           'configuration_key' => 'PRODUCT_IMAGE_SHOW_NO_IMAGE'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '26'",
                           'configuration_key' => 'PRODUCT_IMAGE_POPUP_MERGE'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '30'",
                           'configuration_key' => 'CATEGORIES_IMAGE_SHOW_NO_IMAGE'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '50'",
                           'configuration_key' => 'MANUFACTURER_IMAGE_SHOW_NO_IMAGE'
                           );

//configuration_group_id 5 --- "Kundendetails"
  $values[] = "(NULL, 'ACCOUNT_TELEPHONE_OPTIONAL', 'false', '5', '70', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'GUEST_ACCOUNT_EDIT', 'false', '5', '120', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";

//configuration_group_id 6 --- "Modul Optionen"
  //$values[] = "(NULL, 'COMPRESS_STYLESHEET_TIME', '', '6', '100', NULL, NOW(), NULL, NULL);"; // Tomcraft - 2016-06-06 - Obsolete since r7607
  $values[] = "(NULL, 'NEWSFEED_LAST_READ', '', '6', '100', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'NEWSFEED_LAST_UPDATE', '', '6', '100', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'NEWSFEED_LAST_UPDATE_TRY', '', '6', '100', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MODULE_CATEGORIES_INSTALLED', '', '6', '0', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MODULE_CHECKOUT_INSTALLED', '', '6', '0', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MODULE_MAIN_INSTALLED', '', '6', '0', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MODULE_ORDER_INSTALLED', '', '6', '0', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MODULE_PRODUCT_INSTALLED', '', '6', '0', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MODULE_SHOPPING_CART_INSTALLED', '', '6', '0', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MODULE_XTCPRICE_INSTALLED', '', '6', '0', NULL, NOW(), NULL, NULL);";

//configuration_group_id 7 --- "Versandoptionen"
  //$values[] = "(NULL, 'SHIPPING_DEFAULT_TAX_CLASS_METHOD', '1', 7, 7, NULL, NOW(), 'xtc_get_default_tax_class_method_name', 'xtc_cfg_pull_down_default_tax_class_methods(');"; //modified 1.07
  $values[] = "(NULL, 'SHOW_SHIPPING_EXCL', 'true', '7', '6', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'CHECK_CHEAPEST_SHIPPING_MODUL', 'false', '7', '8', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'SHOW_SELFPICKUP_FREE', 'false', '7', '9', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'SHOW_SHIPPING_MODULE_TITLE', 'standard', '7', '10', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'shipping_default\', \'shipping_title\', \'shipping_custom\'), ');";
  $values[] = "(NULL, 'CUSTOM_SHIPPING_TITLE', 'DE::Versandkosten||EN::Shipping costs', '7', '11', NULL, NOW(), NULL, 'xtc_cfg_input_email_language;CUSTOM_SHIPPING_TITLE');";
  $values[] = "(NULL, 'CAPITALIZE_ADDRESS_FORMAT', 'false', '7', '15', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";

  $values_update[] = array (
                           'values' => "set_function = 'xtc_cfg_select_content(\'SHIPPING_INFOS\','",
                           'configuration_key' => 'SHIPPING_INFOS'
                           );

//configuration_group_id 8 --- "Artikel Listen Optionen"
  $values[] = "(NULL, 'SHOW_BUTTON_BUY_NOW', 'false', '8', '2', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  //$values[] = "(NULL, 'USE_PAGINATION_LIST', 'false', '8', '8', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');"; // Tomcraft - 2017-07-12 - Not used anymore since r10840, see: http://trac.modified-shop.org/ticket/1238
  $values[] = "(NULL, 'CATEGORIES_SHOW_PRODUCTS_SUBCATS', 'false', '8', '10', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'DISPLAY_FILTER_INDEX', '3,12,27,all', '8', '100', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'DISPLAY_FILTER_SPECIALS', '3,12,27,all', '8', '101', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'DISPLAY_FILTER_PRODUCTS_NEW', '3,12,27,all', '8', '102', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'DISPLAY_FILTER_ADVANCED_SEARCH_RESULT', '4,12,32,all', '8', '103', NULL, NOW(), NULL, NULL);";

//configuration_group_id 9 --- "Lagerverwaltungs Optionen"
  $values[] = "(NULL, 'STOCK_CHECKOUT_UPDATE_PRODUCTS_STATUS', 'false', '9', '20', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'STOCK_CHECK_SPECIALS', 'false', '9', '21', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'ATTRIBUTES_VALID_CHECK', 'true', '9', '22', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'STOCK_LIMITED_DOWNLOADS', 'false', '9', '4', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";

  $values_update[] = array (
                           'values' => "sort_order = '5'",
                           'configuration_key' => 'STOCK_ALLOW_CHECKOUT'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '6'",
                           'configuration_key' => 'STOCK_MARK_PRODUCT_OUT_OF_STOCK'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '7'",
                           'configuration_key' => 'STOCK_REORDER_LEVEL'
                           );

//configuration_group_id 10 --- "Logging Optionen"
  $values[] = "(NULL, 'STORE_PAGE_PARSE_TIME_THRESHOLD', '1.0', '10', '2', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'STORE_DB_SLOW_QUERY', 'false', '10', '6', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'STORE_DB_SLOW_QUERY_TIME', '1.0', '10', '7', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'DISPLAY_ERROR_REPORTING', 'none', '10', '8', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'none\', \'admin\', \'all\'),');";

  $values_update[] = array (
                           'values' => "configuration_group_id = '10', set_function = 'xtc_cfg_select_option(array(\'none\', \'admin\', \'all\'),'",
                           'configuration_key' => 'DISPLAY_PAGE_PARSE_TIME'
                           );

//configuration_group_id 11 --- "Cache Optionen"
  $values[] = "(NULL, 'DB_CACHE_TYPE', 'files', '11', '7', NULL, NOW(), NULL, 'xtc_cfg_pull_down_cache_type(\'DB_CACHE_TYPE\',');";

//configuration_group_id 12 --- "Email Optionen"
  $values[] = "(NULL, 'USE_SENDMAIL_OPTIONS', 'true', 12, 2, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'SMTP_SECURE', 'none', 12, 8, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'none\', \'ssl\', \'tls\'),');";
  $values[] = "(NULL, 'SMTP_AUTO_TLS', 'false', 12, 8, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'SMTP_DEBUG', '0', 12, 8, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'),');";
  $values[] = "(NULL, 'EMAIL_SQL_ERRORS', 'false', '12', '14', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'EMAIL_BILLING_ATTACHMENTS', '', '12', '39', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'SHOW_IMAGES_IN_EMAIL', 'false', '12', '15', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'SHOW_IMAGES_IN_EMAIL_DIR', 'thumbnail', '12', '16', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'thumbnail\', \'info\'),');";
  $values[] = "(NULL, 'SHOW_IMAGES_IN_EMAIL_STYLE', 'max-width:90px;max-height:120px;', '12', '17', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'SEND_EMAILS_DOUBLE_OPT_IN', 'true', '12', '14', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'SEND_MAIL_ACCOUNT_CREATED', 'false', '12', '14', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'ORDER_EMAIL_SEND_COPY_TO_ADMIN', 'true', '12', '14', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'STATUS_EMAIL_SENT_COPY_TO_ADMIN', 'false', '12', '14', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'EMAIL_WORD_WRAP', '50', '12', '18', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'EMAIL_ARCHIVE_ADDRESS', '', '12', '40', NULL, NOW(), NULL, 'xtc_cfg_input_email_language;EMAIL_ARCHIVE_ADDRESS');";
  //$values[] = "(NULL, 'EMAIL_SIGNATURE_ID', '', '12', '19', NULL, NOW(), NULL, 'xtc_cfg_select_content(\'EMAIL_SIGNATURE_ID\',');"; // Tomcraft - 2015-09-23 - Moved to update_1.0.6.0_to_2.0.0.0.sql for dynamic update

  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;CONTACT_US_EMAIL_ADDRESS'",
                           'configuration_key' => 'CONTACT_US_EMAIL_ADDRESS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;CONTACT_US_NAME'",
                           'configuration_key' => 'CONTACT_US_NAME'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;CONTACT_US_REPLY_ADDRESS'",
                           'configuration_key' => 'CONTACT_US_REPLY_ADDRESS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;CONTACT_US_REPLY_ADDRESS_NAME'",
                           'configuration_key' => 'CONTACT_US_REPLY_ADDRESS_NAME'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;CONTACT_US_EMAIL_SUBJECT'",
                           'configuration_key' => 'CONTACT_US_EMAIL_SUBJECT'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;CONTACT_US_FORWARDING_STRING'",
                           'configuration_key' => 'CONTACT_US_FORWARDING_STRING'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_SUPPORT_ADDRESS'",
                           'configuration_key' => 'EMAIL_SUPPORT_ADDRESS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_SUPPORT_NAME'",
                           'configuration_key' => 'EMAIL_SUPPORT_NAME'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_SUPPORT_REPLY_ADDRESS'",
                           'configuration_key' => 'EMAIL_SUPPORT_REPLY_ADDRESS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_SUPPORT_REPLY_ADDRESS_NAME'",
                           'configuration_key' => 'EMAIL_SUPPORT_REPLY_ADDRESS_NAME'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_SUPPORT_SUBJECT'",
                           'configuration_key' => 'EMAIL_SUPPORT_SUBJECT'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_SUPPORT_FORWARDING_STRING'",
                           'configuration_key' => 'EMAIL_SUPPORT_FORWARDING_STRING'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_BILLING_ADDRESS'",
                           'configuration_key' => 'EMAIL_BILLING_ADDRESS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_BILLING_NAME'",
                           'configuration_key' => 'EMAIL_BILLING_NAME'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_BILLING_REPLY_ADDRESS'",
                           'configuration_key' => 'EMAIL_BILLING_REPLY_ADDRESS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_BILLING_REPLY_ADDRESS_NAME'",
                           'configuration_key' => 'EMAIL_BILLING_REPLY_ADDRESS_NAME'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_BILLING_SUBJECT'",
                           'configuration_key' => 'EMAIL_BILLING_SUBJECT'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_BILLING_FORWARDING_STRING'",
                           'configuration_key' => 'EMAIL_BILLING_FORWARDING_STRING'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_BILLING_SUBJECT_ORDER'",
                           'configuration_key' => 'EMAIL_BILLING_SUBJECT_ORDER'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_input_email_language;EMAIL_BILLING_ATTACHMENTS'",
                           'configuration_key' => 'EMAIL_BILLING_ATTACHMENTS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '12', set_function = 'xtc_cfg_password_field;SMTP_PASSWORD'",
                           'configuration_key' => 'SMTP_PASSWORD'
                           );

//configuration_group_id 13 --- "Download Optionen"
  $values_update[] = array (
                           'values' => "configuration_group_id = '13', set_function = 'xtc_cfg_multi_checkbox(\'xtc_get_orders_status\', \'chr(44)\','",
                           'configuration_key' => 'DOWNLOAD_MIN_ORDERS_STATUS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '13', set_function = 'xtc_cfg_checkbox_unallowed_module(\'payment\', \'DOWNLOAD_UNALLOWED_PAYMENT\','",
                           'configuration_key' => 'DOWNLOAD_UNALLOWED_PAYMENT'
                           );
  $values[] = "(NULL, 'DOWNLOAD_MULTIPLE_ATTRIBUTES_ALLOWED', 'false', '13', '6', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'DOWNLOAD_SHOW_LANG_DROPDOWN', 'true', '13', '7', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";

//configuration_group_id 14 --- "GZIP Kompression"
  $values[] = "(NULL, 'COMPRESS_HTML_OUTPUT', 'true', 14, 3, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'COMPRESS_STYLESHEET', 'true', 14, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'COMPRESS_JAVASCRIPT', 'true', 14, 5, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";

//configuration_group_id 15 --- "Sessions"
  $values[] = "(NULL, 'SESSION_LIFE_CUSTOMERS', '1440', '15', '20', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'SESSION_LIFE_ADMIN', '7200', '15', '21', NULL, NOW(), NULL, NULL);";

  $values_update[] = array (
                           'values' => "configuration_group_id = '15'",
                           'configuration_key' => 'SESSION_RECREATE'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '6', configuration_value = 'False'",
                           'configuration_key' => 'SESSION_CHECK_SSL_SESSION_ID'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '6', configuration_value = 'False'",
                           'configuration_key' => 'SESSION_CHECK_USER_AGENT'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '6', configuration_value = 'False'",
                           'configuration_key' => 'SESSION_CHECK_IP_ADDRESS'
                           );

//configuration_group_id 16 --- "Metatags Suchmaschinen"
  $values[] = "(NULL, 'DISPLAY_BREADCRUMB_OPTION', 'name', '16', '15', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'name\', \'model\'),');";
  $values[] = "(NULL, 'META_MAX_KEYWORD_LENGTH', '18', '16', '1', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'META_DESCRIPTION_LENGTH', '320', '16', '2', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'META_PRODUCTS_KEYWORDS_LENGTH', '255', '16', '2', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'META_KEYWORDS_LENGTH', '255', '16', '2', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'META_TITLE_LENGTH', '70', '16', '2', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'META_STOP_WORDS', '#german:\r\nab,aber,abgerufen,abgerufene,abgerufener,abgerufenes,acht,alle,allein,allem,allen,aller,allerdings,allerlei,alles,allgemein,allm�hlich,allzu,als,alsbald,also,am,an,ander,andere,anderem,anderen,anderer,andererseits,anderes,anderm,andern,andernfalls,anders,anerkannt,anerkannte,anerkannter,anerkanntes,anfangen,anfing,angefangen,angesetze,angesetzt,angesetzten,angesetzter,ansetzen,anstatt,arbeiten,auch,auf,aufgeh�rt,aufgrund,aufh�ren,aufh�rte,aufzusuchen,aus,ausdr�cken,ausdr�ckt,ausdr�ckte,ausgenommen,ausser,ausserdem,author,autor,au�en,au�er,au�erdem,au�erhalb,bald,bearbeite,bearbeiten,bearbeitete,bearbeiteten,bedarf,bedurfte,bed�rfen,befragen,befragte,befragten,befragter,begann,beginnen,begonnen,behalten,behielt,bei,beide,beiden,beiderlei,beides,beim,beinahe,beitragen,beitrugen,bekannt,bekannte,bekannter,bekennen,benutzt,bereits,berichten,berichtet,berichtete,berichteten,besonders,besser,bestehen,besteht,betr�chtlich,bevor,bez�glich,bietet,bin,bis,bisher,bislang,bist,bleiben,blieb,bloss,blo�,brachte,brachten,brauchen,braucht,bringen,br�uchte,bsp.,bzw,b�den,ca.,da,dabei,dadurch,daf�r,dagegen,daher,dahin,damals,damit,danach,daneben,dank,danke,danken,dann,dannen,daran,darauf,daraus,darf,darfst,darin,darum,darunter,dar�ber,dar�berhinaus,das,dass,dasselbe,davon,davor,dazu,da�,dein,deine,deinem,deinen,deiner,deines,dem,demnach,demselben,den,denen,denn,dennoch,denselben,der,derart,derartig,derem,deren,derer,derjenige,derjenigen,derselbe,derselben,derzeit,des,deshalb,desselben,dessen,desto,deswegen,dich,die,diejenige,dies,diese,dieselbe,dieselben,diesem,diesen,dieser,dieses,diesseits,dinge,dir,direkt,direkte,direkten,direkter,doch,doppelt,dort,dorther,dorthin,drauf,drei,drei�ig,drin,dritte,drunter,dr�ber,du,dunklen,durch,durchaus,durfte,durften,d�rfen,d�rfte,eben,ebenfalls,ebenso,ehe,eher,eigenen,eigenes,eigentlich,ein,einba�n,eine,einem,einen,einer,einerseits,eines,einfach,einf�hren,einf�hrte,einf�hrten,eingesetzt,einig,einige,einigem,einigen,einiger,einigerma�en,einiges,einmal,eins,einseitig,einseitige,einseitigen,einseitiger,einst,einstmals,einzig,ende,entsprechend,entweder,er,erg�nze,erg�nzen,erg�nzte,erg�nzten,erhalten,erhielt,erhielten,erh�lt,erneut,erst,erste,ersten,erster,er�ffne,er�ffnen,er�ffnet,er�ffnete,er�ffnetes,es,etc,etliche,etwa,etwas,euch,euer,eure,eurem,euren,eurer,eures,fall,falls,fand,fast,ferner,finden,findest,findet,folgende,folgenden,folgender,folgendes,folglich,fordern,fordert,forderte,forderten,fortsetzen,fortsetzt,fortsetzte,fortsetzten,fragte,frau,frei,freie,freier,freies,fuer,f�nf,f�r,gab,ganz,ganze,ganzem,ganzen,ganzer,ganzes,gar,gbr,geb,geben,geblieben,gebracht,gedurft,geehrt,geehrte,geehrten,geehrter,gefallen,gefiel,gef�lligst,gef�llt,gegeben,gegen,gehabt,gehen,geht,gekommen,gekonnt,gemacht,gemocht,gem�ss,genommen,genug,gern,gesagt,gesehen,gestern,gestrige,getan,geteilt,geteilte,getragen,gewesen,gewisserma�en,gewollt,geworden,ggf,gib,gibt,gleich,gleichwohl,gleichzeitig,gl�cklicherweise,gmbh,gratulieren,gratuliert,gratulierte,gute,guten,g�ngig,g�ngige,g�ngigen,g�ngiger,g�ngiges,g�nzlich,hab,habe,haben,haette,halb,hallo,hast,hat,hatte,hatten,hattest,hattet,heraus,herein,heute,heutige,hier,hiermit,hiesige,hin,hinein,hinten,hinter,hinterher,hoch,hundert,h�tt,h�tte,h�tten,h�chstens,ich,igitt,ihm,ihn,ihnen,ihr,ihre,ihrem,ihren,ihrer,ihres,im,immer,immerhin,important,in,indem,indessen,info,infolge,innen,innerhalb,ins,insofern,inzwischen,irgend,irgendeine,irgendwas,irgendwen,irgendwer,irgendwie,irgendwo,ist,ja,je,jede,jedem,jeden,jedenfalls,jeder,jederlei,jedes,jedoch,jemand,jene,jenem,jenen,jener,jenes,jenseits,jetzt,j�hrig,j�hrige,j�hrigen,j�hriges,kam,kann,kannst,kaum,kein,keine,keinem,keinen,keiner,keinerlei,keines,keineswegs,klar,klare,klaren,klares,klein,kleinen,kleiner,kleines,koennen,koennt,koennte,koennten,komme,kommen,kommt,konkret,konkrete,konkreten,konkreter,konkretes,konnte,konnten,k�nn,k�nnen,k�nnt,k�nnte,k�nnten,k�nftig,lag,lagen,langsam,lassen,laut,lediglich,leer,legen,legte,legten,leicht,leider,lesen,letze,letzten,letztendlich,letztens,letztes,letztlich,lichten,liegt,liest,links,l�ngst,l�ngstens,mache,machen,machst,macht,machte,machten,mag,magst,mal,man,manche,manchem,manchen,mancher,mancherorts,manches,manchmal,mann,margin,mehr,mehrere,mein,meine,meinem,meinen,meiner,meines,meist,meiste,meisten,meta,mich,mindestens,mir,mit,mithin,mochte,morgen,morgige,muessen,muesst,muesste,muss,musst,musste,mussten,mu�,mu�t,m�chte,m�chten,m�chtest,m�gen,m�glich,m�gliche,m�glichen,m�glicher,m�glicherweise,m�ssen,m�sste,m�ssten,m��t,m��te,nach,nachdem,nacher,nachhinein,nacht,nahm,nat�rlich,neben,nebenan,nehmen,nein,neu,neue,neuem,neuen,neuer,neues,neun,nicht,nichts,nie,niemals,niemand,nimm,nimmer,nimmt,nirgends,nirgendwo,noch,nun,nur,nutzen,nutzt,nutzung,n�chste,n�mlich,n�tigenfalls,n�tzt,ob,oben,oberhalb,obgleich,obschon,obwohl,oder,oft,ohne,per,pfui,pl�tzlich,pro,reagiere,reagieren,reagiert,reagierte,rechts,regelm��ig,rief,rund,sage,sagen,sagt,sagte,sagten,sagtest,sang,sangen,schlechter,schlie�lich,schnell,schon,schreibe,schreiben,schreibens,schreiber,schwierig,sch�tzen,sch�tzt,sch�tzte,sch�tzten,sechs,sect,sehe,sehen,sehr,sehrwohl,seht,sei,seid,sein,seine,seinem,seinen,seiner,seines,seit,seitdem,seite,seiten,seither,selber,selbst,senke,senken,senkt,senkte,senkten,setzen,setzt,setzte,setzten,sich,sicher,sicherlich,sie,sieben,siebte,siehe,sieht,sind,singen,singt,so,sobald,soda�,soeben,sofern,sofort,sog,sogar,solange,solch,solche,solchem,solchen,solcher,solches,soll,sollen,sollst,sollt,sollte,sollten,solltest,somit,sondern,sonst,sonstwo,sooft,soviel,soweit,sowie,sowohl,spielen,sp�ter,startet,startete,starteten,statt,stattdessen,steht,steige,steigen,steigt,stets,stieg,stiegen,such,suchen,s�mtliche,tages,tat,tats�chlich,tats�chlichen,tats�chlicher,tats�chliches,tausend,teile,teilen,teilte,teilten,titel,total,trage,tragen,trotzdem,trug,tr�gt,tun,tust,tut,txt,t�t,ueber,um,umso,unbedingt,und,ungef�hr,unm�glich,unm�gliche,unm�glichen,unm�glicher,unn�tig,uns,unse,unsem,unsen,unser,unsere,unserem,unseren,unserer,unseres,unserm,unses,unten,unter,unterbrach,unterbrechen,unterhalb,unwichtig,usw,vergangen,vergangene,vergangener,vergangenes,vermag,vermutlich,verm�gen,verrate,verraten,verriet,verrieten,version,versorge,versorgen,versorgt,versorgte,versorgten,versorgtes,ver�ffentlichen,ver�ffentlicher,ver�ffentlicht,ver�ffentlichte,ver�ffentlichten,ver�ffentlichtes,viel,viele,vielen,vieler,vieles,vielleicht,vielmals,vier,vollst�ndig,vom,von,vor,voran,vorbei,vorgestern,vorher,vorne,vor�ber,v�llig,wachen,waere,wann,war,waren,warst,warum,was,weder,weg,wegen,weil,weiter,weitere,weiterem,weiteren,weiterer,weiteres,weiterhin,wei�,welche,welchem,welchen,welcher,welches,wem,wen,wenig,wenige,weniger,wenigstens,wenn,wenngleich,wer,werde,werden,werdet,weshalb,wessen,wichtig,wie,wieder,wieso,wieviel,wiewohl,will,willst,wir,wird,wirklich,wirst,wo,wodurch,wogegen,woher,wohin,wohingegen,wohl,wohlweislich,wolle,wollen,wollt,wollte,wollten,wolltest,wolltet,womit,woraufhin,woraus,worin,wurde,wurden,w�hrend,w�hrenddessen,w�r,w�re,w�ren,w�rde,w�rden,z.B.,zahlreich,zehn,zeitweise,ziehen,zieht,zog,zogen,zu,zudem,zuerst,zufolge,zugleich,zuletzt,zum,zumal,zur,zur�ck,zusammen,zuviel,zwanzig,zwar,zwei,zwischen,zw�lf,�hnlich,�bel,�ber,�berall,�berallhin,�berdies,�bermorgen,�brig,�brigens\r\n\r\n#english:\r\na\'s,able,about,above,abroad,according,accordingly,across,actually,adj,after,afterwards,again,against,ago,ahead,ain\'t,all,allow,allows,almost,alone,along,alongside,already,also,although,always,am,amid,amidst,among,amongst,an,and,another,any,anybody,anyhow,anyone,anything,anyway,anyways,anywhere,apart,appear,appreciate,appropriate,are,aren\'t,around,as,aside,ask,asking,associated,at,available,away,awfully,back,backward,backwards,be,became,because,become,becomes,becoming,been,before,beforehand,begin,behind,being,believe,below,beside,besides,best,better,between,beyond,both,brief,but,by,c\'mon,c\'s,came,can,can\'t,cannot,cant,caption,cause,causes,certain,certainly,changes,clearly,co,co.,com,come,comes,concerning,consequently,consider,considering,contain,containing,contains,corresponding,could,couldn\'t,course,currently,dare,daren\'t,definitely,described,despite,did,didn\'t,different,directly,do,does,doesn\'t,doing,don\'t,done,down,downwards,during,each,edu,eg,eight,eighty,either,else,elsewhere,end,ending,enough,entirely,especially,et,etc,even,ever,evermore,every,everybody,everyone,everything,everywhere,ex,exactly,example,except,fairly,far,farther,few,fewer,fifth,first,five,followed,following,follows,for,forever,former,formerly,forth,forward,found,four,from,further,furthermore,get,gets,getting,given,gives,go,goes,going,gone,got,gotten,greetings,had,hadn\'t,half,happens,hardly,has,hasn\'t,have,haven\'t,having,he,he\'d,he\'ll,he\'s,hello,help,hence,her,here,here\'s,hereafter,hereby,herein,hereupon,hers,herself,hi,him,himself,his,hither,hopefully,how,howbeit,however,hundred,i\'d,i\'ll,i\'m,i\'ve,ie,if,ignored,immediate,in,inasmuch,inc,inc.,indeed,indicate,indicated,indicates,inner,inside,insofar,instead,into,inward,is,isn\'t,it,it\'d,it\'ll,it\'s,its,itself,just,k,keep,keeps,kept,know,known,knows,last,lately,later,latter,latterly,least,less,lest,let,let\'s,like,liked,likely,likewise,little,look,looking,looks,low,lower,ltd,made,mainly,make,makes,many,may,maybe,mayn\'t,me,mean,meantime,meanwhile,merely,might,mightn\'t,mine,minus,miss,more,moreover,most,mostly,mr,mrs,much,must,mustn\'t,my,myself,name,namely,nd,near,nearly,necessary,need,needn\'t,needs,neither,never,neverf,neverless,nevertheless,new,next,nine,ninety,no,no-one,nobody,non,none,nonetheless,noone,nor,normally,not,nothing,notwithstanding,novel,now,nowhere,obviously,of,off,often,oh,ok,okay,old,on,once,one,one\'s,ones,only,onto,opposite,or,other,others,otherwise,ought,oughtn\'t,our,ours,ourselves,out,outside,over,overall,own,particular,particularly,past,per,perhaps,placed,please,plus,possible,presumably,probably,provided,provides,que,quite,qv,rather,rd,re,really,reasonably,recent,recently,regarding,regardless,regards,relatively,respectively,right,round,said,same,saw,say,saying,says,second,secondly,see,seeing,seem,seemed,seeming,seems,seen,self,selves,sensible,sent,serious,seriously,seven,several,shall,shan\'t,she,she\'d,she\'ll,she\'s,should,shouldn\'t,since,six,so,some,somebody,someday,somehow,someone,something,sometime,sometimes,somewhat,somewhere,soon,sorry,specified,specify,specifying,still,sub,such,sup,sure,t\'s,take,taken,taking,tell,tends,th,than,thank,thanks,thanx,that,that\'ll,that\'s,that\'ve,thats,the,their,theirs,them,themselves,then,thence,there,there\'d,there\'ll,there\'re,there\'s,there\'ve,thereafter,thereby,therefore,therein,theres,thereupon,these,they,they\'d,they\'ll,they\'re,they\'ve,thing,things,think,third,thirty,this,thorough,thoroughly,those,though,three,through,throughout,thru,thus,till,to,together,too,took,toward,towards,tried,tries,truly,try,trying,twice,two,un,under,underneath,undoing,unfortunately,unless,unlike,unlikely,until,unto,up,upon,upwards,us,use,used,useful,uses,using,usually,v,value,various,versus,very,via,viz,vs,want,wants,was,wasn\'t,way,we,we\'d,we\'ll,we\'re,we\'ve,welcome,well,went,were,weren\'t,what,what\'ll,what\'s,what\'ve,whatever,when,whence,whenever,where,where\'s,whereafter,whereas,whereby,wherein,whereupon,wherever,whether,which,whichever,while,whilst,whither,who,who\'d,who\'ll,who\'s,whoever,whole,whom,whomever,whose,why,will,willing,wish,with,within,without,won\'t,wonder,would,wouldn\'t,yes,yet,you,you\'d,you\'ll,you\'re,you\'ve,your,yours,yourself,yourselves,zero', '16', '16', NULL, NOW(), NULL, 'xtc_cfg_textarea(');";
  $values[] = "(NULL, 'META_GO_WORDS', '', '16', '17', NULL, NOW(), NULL, 'xtc_cfg_textarea(');";
  $values[] = "(NULL, 'META_CAT_SHOP_TITLE', 'false', '16', '18', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'META_PROD_SHOP_TITLE', 'false', '16', '19', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'META_CONTENT_SHOP_TITLE', 'false', '16', '20', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'META_SPECIALS_SHOP_TITLE', 'false', '16', '21', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'META_NEWS_SHOP_TITLE', 'false', '16', '22', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'META_SEARCH_SHOP_TITLE', 'false', '16', '23', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'META_OTHER_SHOP_TITLE', 'false', '16', '24', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'META_GOOGLE_VERIFICATION_KEY', '', '16', '25', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'META_BING_VERIFICATION_KEY', '', '16', '26', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'SEO_URL_MOD_CLASS', 'seo_url_shopstat', '16', '13', NULL, NOW(), NULL, 'xtc_cfg_select_mod_seo_url(');";

//configuration_group_id 17 --- "Zusatzmodule"
  $values_group[] = "(17,'Additional Modules','Additional Modules',17,1);";
  $values[] = "(NULL, 'SAVE_IP_LOG', 'false', 17, 11, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\', \'xxx\'),');";
  //$values[] = "(NULL, 'SHIPPING_STATUS_INFOS', '', 17, 14, NULL, NOW(), NULL, 'xtc_cfg_select_content(\'SHIPPING_STATUS_INFOS\',');"; // Tomcraft - 2015-09-23 - Moved to update_1.0.6.0_to_2.0.0.0.sql for dynamic update
  $values[] = "(NULL, 'MODULE_SMALL_BUSINESS', 'false', 17, 14, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'WYSIWYG_SKIN', 'moonocolor', 17, 2, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'moono\', \'moonocolor\', \'moono-lisa\'),');";
  $values[] = "(NULL, 'CHECK_FIRST_PAYMENT_MODUL', 'false', '17', '24', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'DISPLAY_PRIVACY_CHECK', 'true', '17', '19', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'DISPLAY_PRIVACY_ON_CHECKOUT', 'false', '17', '18', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'DISPLAY_REVOCATION_VIRTUAL_ON_CHECKOUT', 'false', '17', '21', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'MODULE_BANNER_MANAGER_STATUS', 'true', '17', '26', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'MODULE_NEWSLETTER_STATUS', 'true', '17', '27', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'MODULE_NEWSLETTER_VOUCHER_AMOUNT', '0', '17', '28', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MODULE_NEWSLETTER_DISCOUNT_COUPON', '', '17', '29', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'DISPLAY_HEADQUARTER_ON_CHECKOUT', 'true', '17', '12', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'SIGN_CONDITIONS_ON_CHECKOUT', 'false', '17', '9', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";
  $values[] = "(NULL, 'ACTIVATE_CROSS_SELLING', 'true', '17', '17', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'), ');";

  $values_update[] = array (
                           'values' => "set_function = 'xtc_cfg_select_content(\'REVOCATION_ID\','",
                           'configuration_key' => 'REVOCATION_ID'
                           );

  $values_update[] = array (
                           'values' => "set_function = 'xtc_cfg_select_content(\'SHIPPING_STATUS_INFOS\','",
                           'configuration_key' => 'SHIPPING_STATUS_INFOS'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '1'",
                           'configuration_key' => 'USE_WYSIWYG'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '2'",
                           'configuration_key' => 'WYSIWYG_SKIN'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '3'",
                           'configuration_key' => 'ACTIVATE_GIFT_SYSTEM'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '4'",
                           'configuration_key' => 'SECURITY_CODE_LENGTH'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '5'",
                           'configuration_key' => 'NEW_SIGNUP_GIFT_VOUCHER_AMOUNT'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '6'",
                           'configuration_key' => 'NEW_SIGNUP_DISCOUNT_COUPON'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '7'",
                           'configuration_key' => 'ACTIVATE_SHIPPING_STATUS'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '8'",
                           'configuration_key' => 'DISPLAY_CONDITIONS_ON_CHECKOUT'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '9'",
                           'configuration_key' => 'SIGN_CONDITIONS_ON_CHECKOUT'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '10'",
                           'configuration_key' => 'SHOW_IP_LOG'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '11'",
                           'configuration_key' => 'SAVE_IP_LOG'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '12'",
                           'configuration_key' => 'DISPLAY_HEADQUARTER_ON_CHECKOUT'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '13'",
                           'configuration_key' => 'GROUP_CHECK'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '14'",
                           'configuration_key' => 'MODULE_SMALL_BUSINESS'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '15'",
                           'configuration_key' => 'ACTIVATE_NAVIGATOR'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '16'",
                           'configuration_key' => 'QUICKLINK_ACTIVATED'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '17'",
                           'configuration_key' => 'ACTIVATE_REVERSE_CROSS_SELLING'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '18'",
                           'configuration_key' => 'DISPLAY_PRIVACY_ON_CHECKOUT'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '17', sort_order = '19'",
                           'configuration_key' => 'DISPLAY_PRIVACY_CHECK'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '20'",
                           'configuration_key' => 'DISPLAY_REVOCATION_ON_CHECKOUT'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '21'",
                           'configuration_key' => 'DISPLAY_REVOCATION_VIRTUAL_ON_CHECKOUT'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '22'",
                           'configuration_key' => 'REVOCATION_ID'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '23'",
                           'configuration_key' => 'SHIPPING_STATUS_INFOS'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '24'",
                           'configuration_key' => 'CHECK_FIRST_PAYMENT_MODUL'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '25'",
                           'configuration_key' => 'INVOICE_INFOS'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '26'",
                           'configuration_key' => 'MODULE_BANNER_MANAGER_STATUS'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '27'",
                           'configuration_key' => 'MODULE_NEWSLETTER_STATUS'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '28'",
                           'configuration_key' => 'MODULE_NEWSLETTER_VOUCHER_AMOUNT'
                           );
  $values_update[] = array (
                           'values' => "sort_order = '29'",
                           'configuration_key' => 'MODULE_NEWSLETTER_DISCOUNT_COUPON'
                           );
  $values_update[] = array (
                           'values' => "set_function = 'xtc_cfg_select_option(array(\'moono\', \'moonocolor\', \'moono-lisa\'),'",
                           'configuration_key' => 'WYSIWYG_SKIN'
                           );

//configuration_group_id 18 --- "UST-ID"

//configuration_group_id 19 --- "Google Conversionr"
  $values[] = "(NULL, 'GOOGLE_CONVERSION_LABEL', 'Purchase', '19', '4', NULL, NOW(), NULL, NULL);";

//configuration_group_id 20 --- "Import/export"
  $values[] = "(NULL, 'CSV_CATEGORY_DEFAULT', '0', '20', '4', NULL, NOW(), NULL, 'xtc_cfg_get_category_tree(');";
  $values[] = "(NULL, 'CSV_CAT_DEPTH', '4', '20', '5', NULL, NOW(), NULL, NULL);";
//configuration_group_id 21 --- "Afterbuy"
  //$values[] = "(NULL, 'AFTERBUY_DEALERS', '3', '21', '7', NULL , NOW(), NULL , NULL);";
  //$values[] = "(NULL, 'AFTERBUY_IGNORE_GROUPE', '', '21', '8', NULL , NOW(), NULL , NULL);";

//configuration_group_id 22 --- "Such-Optionen"
  $values[] = "(NULL, 'SEARCH_MIN_LENGTH', '3', '22', '1', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'SEARCH_IN_MANU', 'true', 22, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');"; 
  $values[] = "(NULL, 'SEARCH_IN_FILTER', 'true', 22, 5, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');"; 
  $values[] = "(NULL, 'SEARCH_AC_STATUS', 'true', 22, 10, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');"; 
  $values[] = "(NULL, 'SEARCH_AC_CATEGORIES', 'true', 22, 10, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');"; 
  $values[] = "(NULL, 'SEARCH_AC_MIN_LENGTH', '3', '22', '11', NULL, NOW(), NULL, NULL);";
  //$values[] = "(NULL, 'SEARCH_HIGHLIGHT', 'true', 22, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";   //modified 2.10
  //$values[] = "(NULL, 'SEARCH_HIGHLIGHT_STYLE', 'color:#000;background-color:#eee;border:dotted #000 1px;', 22, 5, NULL, NOW(), NULL, NULL);"; //modified 2.10

//configuration_group_id 23 --- "Econda Tracking"
  $values_group[] = "(23,'Econda Tracking','Econda Tracking System',23,1);";

//configuration_group_id 24 --- "google analytics, motamo & facebook tracking"
  $values_group[] = "(24,'Motamo &amp; Google Analytics Tracking','Settings for Motamo &amp; Google Analytics Tracking',24,1);";

  $values[] = "(NULL, 'TRACKING_COUNT_ADMIN_ACTIVE', 'false', 24, 1, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'TRACKING_GOOGLEANALYTICS_ACTIVE', 'false', 24, 2, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'TRACKING_GOOGLEANALYTICS_ID','UA-XXXXXXX-X', 24, 3, NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'TRACKING_GOOGLEANALYTICS_UNIVERSAL', 'false', 24, 3, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'TRACKING_GOOGLEANALYTICS_DOMAIN','auto', 24, 3, NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'TRACKING_GOOGLE_LINKID', 'false', 24, 3, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'TRACKING_GOOGLE_DISPLAY', 'false', 24, 3, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'TRACKING_GOOGLE_ECOMMERCE', 'false', 24, 3, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'TRACKING_GOOGLEANALYTICS_GTAG', 'false', 24, 3, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";

  $values[] = "(NULL, 'TRACKING_PIWIK_ACTIVE', 'false', 24, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'TRACKING_PIWIK_LOCAL_PATH','www.example.com/matomo', 24, 5, NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'TRACKING_PIWIK_ID','1', 24, 6, NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'TRACKING_PIWIK_GOAL','1', 24, 7, NULL, NOW(), NULL, NULL);";

  $values[] = "(NULL, 'TRACKING_FACEBOOK_ACTIVE', 'false', 24, 8, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'TRACKING_FACEBOOK_ID','', 24, 9, NULL, NOW(), NULL, NULL);";

//configuration_group_id 25 --- "captcha"
  $values_group[] = "(25,'Captcha','Captcha Configuration',25,1);";
  $values[] = "(NULL, 'MODULE_CAPTCHA_ACTIVE', 'newsletter,contact,password', 25, 1, NULL, NOW(), NULL, 'xtc_cfg_multi_checkbox(array(\'newsletter\' => \'Newsletter\', \'contact\' => \'Contact\', \'password\' => \'Password\', \'reviews\' => \'Reviews\', \'create_account\' => \'Registration\'), \',\',');";
  $values[] = "(NULL, 'MODULE_CAPTCHA_LOGGED_IN', 'False', 25, 2, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'True\', \'False\'),');";
  $values[] = "(NULL, 'CAPTCHA_MOD_CLASS', 'modified_captcha', '25', '3', NULL, NOW(), NULL, 'xtc_cfg_select_mod_captcha(');";
  $values[] = "(NULL, 'MODULE_CAPTCHA_LOGIN_NUM', '2', 25, 4, NULL, NOW(), NULL, NULL);";

//configuration_group_id 31 --- "Moneybookers"
  $values_group[] = "(31,'Moneybookers','Moneybookers System',31,1);";

//configuration_group_id 40 --- "Popup window configuration"
  $values_group[] = "(40,'Popup Window Configuration','Popup Window Parameters',40,1);";

  $values[] = "(NULL, 'POPUP_SHIPPING_LINK_PARAMETERS', '&KeepThis=true&TB_iframe=true&height=400&width=600', '40', '10', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POPUP_SHIPPING_LINK_CLASS', 'thickbox', '40', '11', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POPUP_CONTENT_LINK_PARAMETERS', '&KeepThis=true&TB_iframe=true&height=400&width=600', '40', '20', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POPUP_CONTENT_LINK_CLASS', 'thickbox', '40', '21', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POPUP_PRODUCT_LINK_PARAMETERS', '&KeepThis=true&TB_iframe=true&height=450&width=750', '40', '30', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POPUP_PRODUCT_LINK_CLASS', 'thickbox', '40', '31', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POPUP_COUPON_HELP_LINK_PARAMETERS', '&KeepThis=true&TB_iframe=true&height=400&width=600', '40', '40', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POPUP_COUPON_HELP_LINK_CLASS', 'thickbox', '40', '41', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POPUP_PRODUCT_PRINT_SIZE', 'width=640, height=600', '40', '60', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'POPUP_PRINT_ORDER_SIZE', 'width=640, height=600', '40', '70', NULL, NOW(), NULL, NULL);";

//configuration_group_id 1000 --- "Adminbereich"
  $values_group[] = "(1000,'Adminarea Options','Adminarea Configuration', 1000,1);";

  $values[] = "(NULL, 'USE_ADMIN_FIXED_TOP', 'false', '1000', '23', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'USE_ADMIN_FIXED_SEARCH', 'false', '1000', '24', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'ADMIN_SEARCH_IN_ATTR', 'false', '1000', '25', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');"; 
  $values[] = "(NULL, 'ADMIN_START_TAB_SELECTED', 'whos_online', '1000', '24', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'whos_online\', \'orders\', \'customers\', \'sales_report\', \'blog\'),');";
  $values[] = "(NULL, 'ADMIN_SEARCH_IN_DESC', 'false', '1000', '25', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'USE_ADMIN_THUMBS_IN_LIST', 'true', '1000', '32', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'USE_ADMIN_THUMBS_IN_LIST_STYLE', 'max-width:40px;max-height:40px;', '1000', '33', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'MAX_DISPLAY_ORDER_RESULTS', '30', '1000', '-1', NULL , NOW(), NULL , NULL);";
  $values[] = "(NULL, 'MAX_DISPLAY_LIST_PRODUCTS', '50', '1000', '51', NULL , NOW(), NULL , NULL);";
  $values[] = "(NULL, 'MAX_DISPLAY_LIST_CUSTOMERS', '100', '1000', '-1', NULL , NOW(), NULL , NULL);";
  $values[] = "(NULL, 'WHOS_ONLINE_TIME_LAST_CLICK', '900', '1000', '60', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'WHOS_ONLINE_IP_WHOIS_SERVICE', 'http://www.utrace.de/?query=', '1000', '62', NULL, NOW(), NULL, NULL);"; 
  $values[] = "(NULL, 'CONFIRM_SAVE_ENTRY', 'true', '1000', '70', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'MAX_DISPLAY_COUPON_RESULTS', '30', '1000', '-1', NULL , NOW(), NULL , NULL);";
  $values[] = "(NULL, 'MIN_GROUP_PRICE_STAFFEL', '2', '1000', '34', NULL , NOW(), NULL , NULL);";
  $values[] = "(NULL, 'ORDER_STATUSES_FOR_SALES_STATISTICS', '3', 1000, 100, NULL, NOW(), NULL, 'xtc_cfg_multi_checkbox(\'order_statuses\', \',\',');";
  $values[] = "(NULL, 'USE_ATTRIBUTES_IFRAME', 'true', '1000', '110', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'NEW_ATTRIBUTES_STYLING', 'true', '1000', '112', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'NEW_SELECT_CHECKBOX', 'true', '1000', '113', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'CSRF_TOKEN_SYSTEM', 'true', '1000', '114', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'ADMIN_HEADER_X_FRAME_OPTIONS', 'true', '1000', '115', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');";
  $values[] = "(NULL, 'ATTRIBUTE_MODEL_DELIMITER', '<br />', '1000', '116', NULL, NOW(), NULL, NULL);";
  $values[] = "(NULL, 'ORDER_STATUSES_DISPLAY_DEFAULT', '', 1000, 90, NULL, NOW(), NULL, 'xtc_cfg_multi_checkbox(\'order_statuses\', \',\',');";
  $values_update[] = array (
                           'values' => "configuration_group_id = '1000', sort_order = '-1'",
                           'configuration_key' => 'MAX_DISPLAY_ORDER_RESULTS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '1000', sort_order = '26'",
                           'configuration_key' => 'USE_ADMIN_LANG_TABS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '1000', sort_order = '-1'",
                           'configuration_key' => 'MAX_DISPLAY_LIST_CUSTOMERS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '1000', sort_order = '-1'",
                           'configuration_key' => 'MAX_DISPLAY_COUPON_RESULTS'
                           );
  $values_update[] = array (
                           'values' => "configuration_group_id = '1000', sort_order = '-1'",
                           'configuration_key' => 'MAX_DISPLAY_ORDER_RESULTS'
                           );

//##############################//

$cfg_installer_fileemtime = filemtime(DIR_WS_INCLUDES.'configuration_installer.php');

if (!defined('CFG_INTSTALLER_FILEEMTIME') || CFG_INTSTALLER_FILEEMTIME != $cfg_installer_fileemtime) {
    if (!defined('CFG_INTSTALLER_FILEEMTIME')) {
        $cfg_data_array = array(
            'configuration_key' => 'CFG_INTSTALLER_FILEEMTIME',
            'configuration_value' => $cfg_installer_fileemtime,
            'configuration_group_id' => '1000',
            'sort_order' => '-1',
            'last_modified' => 'now()',
            'date_added' => 'now()'
            );
        xtc_db_perform(TABLE_CONFIGURATION,$cfg_data_array);   
    } else {
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " 
                         SET configuration_value = '" . xtc_db_input($cfg_installer_fileemtime) . "', 
                             last_modified = NOW()
                       WHERE configuration_key = 'CFG_INTSTALLER_FILEEMTIME'
                     ");
    }

    //install configuration group
    $cfg_group_install = insert_into_config_group_table($values_group);

    //update configuration group
    $cfg_group_update = update_config_group_table($values_group_update);

    //install configuration
    $cfg_install = insert_into_config_table($values);

    //update configuration
    $cfg_update = update_config_table($values_update);

    //redirect
    if ($cfg_install || $cfg_group_install || $cfg_update || $cfg_group_update) {
      xtc_redirect(xtc_href_link(FILENAME_CONFIGURATION, 'gID=' . (int)$_GET['gID']));
    }
}

//---------- FUNCTIONS ----------//

  /**
   * insert_into_config_table()
   *
   * @param string $values
   * @return boolean
   */
function insert_into_config_table($values)
{
  global $messageStack;
  //print_r($values);
  $install = false;
  foreach($values as $value) {
    $cfg_arr = explode(',', $value);
    $cfg_key = str_replace("'", '',$cfg_arr[1]); // Hochkommata entfernen
    $result_cfg = xtc_db_query("SELECT * FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = '" . trim($cfg_key) . "' LIMIT 1");
    if (xtc_db_num_rows($result_cfg) == 0) {
      $insert_into = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id ,configuration_key ,configuration_value ,configuration_group_id ,sort_order ,last_modified ,date_added ,use_function ,set_function) VALUES ";
      $value = encode_utf8($value);
      if( xtc_db_query($insert_into.$value)){
        $messageStack->add_session('OK: INSERT INTO '.TABLE_CONFIGURATION.' '.encode_htmlentities($value), 'success');
        $install = true;
      } else {
        $messageStack->add_session('ERROR: INSERT INTO '.TABLE_CONFIGURATION.' '.encode_htmlentities($value), 'error');
      }
    }
  }
  return $install;
}

  /**
   * update_config_table()
   *
   * @param array $values
   * @return boolean
   */
function update_config_table($values)
{
  global $messageStack;

  $install = false;
  foreach($values as $value) {
    //don't update configuration_value
    if (strpos($value['values'], 'configuration_value') === false) {
 
      $cfg_values = rtrim($value['values'],',');
      $cfg_key = trim($value['configuration_key']);
      
      //only update if values are different       
      $check = str_replace("),'","|#|", $cfg_values);
      $check = str_replace(array(", \'",",\'",",'"),"|##|", $check);     
      $check = str_replace('use_function', 'IFNULL(use_function', $check);
      $check = str_replace('set_function', 'IFNULL(set_function', $check);
      $check = " AND (" . str_replace(array("=", ","),array("!=", " OR "),$check); 
      if (strpos($check, 'IFNULL') !== false) {
        $check .= '|###| TRUE)';
      }
      $check .= ')';
      $check = str_replace(array("|##|","|#|"), array(", \'","),'"), $check);
      $check = str_replace("\', \')", "\',')", $check); 
      $check = str_replace("\'|###|", "',", $check); 
      $check = str_replace("|###|", ",", $check); 
      
      $result_cfg = xtc_db_query("SELECT * FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = '" . $cfg_key ."' ". trim($check)." LIMIT 1");
      if (xtc_db_num_rows($result_cfg) != 0) {
        $update = "UPDATE ".TABLE_CONFIGURATION." SET ".$cfg_values." , last_modified = NOW() WHERE configuration_key = '" . $cfg_key . "'";

        if( xtc_db_query($update)){
          $messageStack->add_session('OK: '.encode_htmlentities($update), 'success');
          $install = true;
        } else {
          $messageStack->add_session('ERROR: '.encode_htmlentities($update), 'error');
        }
      }
    }
  }
  return $install;
}

  /**
   * insert_into_config_group_table()
   *
   * @param string $values_group
   * @return boolean
   */
function insert_into_config_group_table($values_group)
{
  global $messageStack;
  $install = false;
  foreach($values_group as $value) {
    $cfg_arr = explode(',', $value);
    $cfg_id = str_replace(array("(","'"), '',$cfg_arr[0]);
    $query = "SELECT * FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_id = '".$cfg_id ."' LIMIT 1";
    $result_cfg_query = xtc_db_query($query);
    if (xtc_db_num_rows($result_cfg_query) == 0) {
      $insert_into = "INSERT INTO ".TABLE_CONFIGURATION_GROUP ." VALUES ";
      if (xtc_db_query($insert_into.$value)) {
        $messageStack->add_session('OK: INSERT INTO '.TABLE_CONFIGURATION_GROUP.' '.encode_htmlentities($value), 'success');
        $install = true;
      } else {
        $messageStack->add_session('ERROR: INSERT INTO '.TABLE_CONFIGURATION_GROUP.' '.encode_htmlentities($value), 'error');
      }
    }
  }
  return $install;
}

  /**
   * update_config_group_table()
   *
   * @param array $values_group
   * @return boolean
   */
function update_config_group_table($values_group)
{
  global $messageStack;
  $install = false;
  foreach($values_group as $value) {
    $cfg_values = rtrim($value['values'],',');
    $cfg_id = $value['configuration_group_id'];
    //only update if values are different
    $check = " AND (" . str_replace(array("=",","),array("!="," OR "),$cfg_values). ")";
    $query = "SELECT * FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_id = '".$cfg_id . "'". $check." LIMIT 1";
    $result_cfg_query = xtc_db_query($query);
    if (xtc_db_num_rows($result_cfg_query) != 0) {      
      $update = "UPDATE ".TABLE_CONFIGURATION_GROUP." SET ".$cfg_values." WHERE configuration_group_id = '" . $cfg_id . "'";
      if (xtc_db_query($update)) {
        $messageStack->add_session('OK: '.encode_htmlentities($update), 'success');
        $install = true;
      } else {
        $messageStack->add_session('ERROR: '.encode_htmlentities($update), 'error');
      }
    }
  }
  return $install;
}