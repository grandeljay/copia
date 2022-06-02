<?php
/* -----------------------------------------------------------------------------------------
   $Id: dhl.php 5121 2013-07-18 11:38:19Z Tomcraft $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(dhl.php,v 1.02 2003/02/18 03:37:00); www.oscommerce.com
   (c) 2003	 nextcommerce (dhl.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2006 xt:Commerce; www.xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   dhl_austria_1.02       	Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


define('MODULE_SHIPPING_DHL_TEXT_TITLE', 'DHL Austria');
define('MODULE_SHIPPING_DHL_TEXT_DESCRIPTION', 'DHL WORLDWIDE EXPRESS Austria');
define('MODULE_SHIPPING_DHL_TEXT_WAY', 'Dispatch to');
define('MODULE_SHIPPING_DHL_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_DHL_INVALID_ZONE', 'Unfortunately it is not possible to dispatch into this country');
define('MODULE_SHIPPING_DHL_UNDEFINED_RATE', 'Forwarding expenses cannot be calculated for the moment');

define('MODULE_SHIPPING_DHL_STATUS_TITLE' , 'DHL WORLDWIDE EXPRESS Austria');
define('MODULE_SHIPPING_DHL_STATUS_DESC' , 'Do you want to offer DHL WORLDWIDE EXPRESS Austria shipping?');
define('MODULE_SHIPPING_DHL_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_DHL_HANDLING_DESC' , 'Handlingfee for this shipping method in Euro');
define('MODULE_SHIPPING_DHL_TAX_CLASS_TITLE' , 'Tax Rate');
define('MODULE_SHIPPING_DHL_TAX_CLASS_DESC' , 'Use the following tax class on the shipping fee');
define('MODULE_SHIPPING_DHL_ZONE_TITLE' , 'Shipping Zone');
define('MODULE_SHIPPING_DHL_ZONE_DESC' , 'If a zone is selected, only enable this shipping method for that zone');
define('MODULE_SHIPPING_DHL_SORT_ORDER_TITLE' , 'Sort Order');
define('MODULE_SHIPPING_DHL_SORT_ORDER_DESC' , 'Sort order of display');
define('MODULE_SHIPPING_DHL_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_DHL_ALLOWED_DESC' , 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');

define('MODULE_SHIPPING_DHL_COUNTRIES_1_TITLE' , 'Shipping Zone 0');
define('MODULE_SHIPPING_DHL_COUNTRIES_1_DESC' , 'Domestic Zone');
define('MODULE_SHIPPING_DHL_COST_ECX_1_TITLE' , 'Shipping Table Zone 0 up to 10 kg ECX');
define('MODULE_SHIPPING_DHL_COST_ECX_1_DESC' , 'Shipping Table Zone 0, based on <b>\'ECX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_MDX_1_TITLE' , 'Shipping Table Zone 0 up to 10 kg MDX');
define('MODULE_SHIPPING_DHL_COST_MDX_1_DESC' , 'Shipping Table Zone 0, based on <b>\'MDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_SDX_1_TITLE' , 'Shipping Table Zone 0 up to 10 kg SDX');
define('MODULE_SHIPPING_DHL_COST_SDX_1_DESC' , 'Shipping Table Zone 0, based on <b>\'SDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_STEP_ECX_20_1_TITLE' , 'Extra charge up to 20 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_20_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_ECX_30_1_TITLE' , 'Extra charge up to 30 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_30_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_ECX_50_1_TITLE' , 'Extra charge up to 50 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_50_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_ECX_51_1_TITLE' , 'Extra charge up from 50 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_51_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_1_TITLE' , 'Extra charge up to 20 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_1_TITLE' , 'Extra charge up to 30 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_1_TITLE' , 'Extra charge up to 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_1_TITLE' , 'Extra charge up from 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_1_TITLE' , 'Extra charge up to 20 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_1_TITLE' , 'Extra charge up to 30 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_1_TITLE' , 'Extra charge up to 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_1_TITLE' , 'Extra charge up from 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_1_DESC' , 'Extra charge each additional 0,50 kg in EUR');

define('MODULE_SHIPPING_DHL_COUNTRIES_2_TITLE' , 'Zone 1 Countries');
define('MODULE_SHIPPING_DHL_COUNTRIES_2_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 1 (Enter WORLD for the rest of the world.).');
define('MODULE_SHIPPING_DHL_COST_ECX_2_TITLE' , 'Shipping Table Zone 1 up to 10 kg ECX');
define('MODULE_SHIPPING_DHL_COST_ECX_2_DESC' , 'Shipping Table Zone 1, based on <b>\'ECX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_MDX_2_TITLE' , 'Shipping Table Zone 1 up to 10 kg MDX');
define('MODULE_SHIPPING_DHL_COST_MDX_2_DESC' , 'Shipping Table Zone 1, based on <b>\'MDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_SDX_2_TITLE' , 'Shipping Table Zone 1 up to 10 kg SDX');
define('MODULE_SHIPPING_DHL_COST_SDX_2_DESC' , 'Shipping Table Zone 1, based on <b>\'SDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_STEP_ECX_20_2_TITLE' , 'Extra charge up to 20 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_20_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_ECX_30_2_TITLE' , 'Extra charge up to 30 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_30_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_ECX_50_2_TITLE' , 'Extra charge up to 50 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_50_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_ECX_51_2_TITLE' , 'Extra charge up from 50 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_51_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_2_TITLE' , 'Extra charge up to 20 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_2_TITLE' , 'Extra charge up to 30 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_2_TITLE' , 'Extra charge up to 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_2_TITLE' , 'Extra charge up from 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_2_TITLE' , 'Extra charge up to 20 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_2_TITLE' , 'Extra charge up to 30 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_2_TITLE' , 'Extra charge up to 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_2_TITLE' , 'Extra charge up from 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_2_DESC' , 'Extra charge each additional 0,50 kg in EUR');

define('MODULE_SHIPPING_DHL_COUNTRIES_3_TITLE' , 'Zone 2 Countries');
define('MODULE_SHIPPING_DHL_COUNTRIES_3_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 2 (Enter WORLD for the rest of the world.).');
define('MODULE_SHIPPING_DHL_COST_ECX_3_TITLE' , 'Shipping Table Zone 2 up to 10 kg ECX');
define('MODULE_SHIPPING_DHL_COST_ECX_3_DESC' , 'Shipping Table Zone 2, based on <b>\'ECX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_MDX_3_TITLE' , 'Shipping Table Zone 2 up to 10 kg MDX');
define('MODULE_SHIPPING_DHL_COST_MDX_3_DESC' , 'Shipping Table Zone 2, based on <b>\'MDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_SDX_3_TITLE' , 'Shipping Table Zone 2 up to 10 kg SDX');
define('MODULE_SHIPPING_DHL_COST_SDX_3_DESC' , 'Shipping Table Zone 2, based on <b>\'SDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_STEP_ECX_20_3_TITLE' , 'Extra charge up to 20 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_20_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_ECX_30_3_TITLE' , 'Extra charge up to 30 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_30_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_ECX_50_3_TITLE' , 'Extra charge up to 50 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_50_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_ECX_51_3_TITLE' , 'Extra charge up from 50 kg ECX');
define('MODULE_SHIPPING_DHL_STEP_ECX_51_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_3_TITLE' , 'Extra charge up to 20 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_3_TITLE' , 'Extra charge up to 30 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_3_TITLE' , 'Extra charge up to 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_3_TITLE' , 'Extra charge up from 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_3_TITLE' , 'Extra charge up to 20 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_3_TITLE' , 'Extra charge up to 30 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_3_TITLE' , 'Extra charge up to 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_3_TITLE' , 'Extra charge up from 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_3_DESC' , 'Extra charge each additional 0,50 kg in EUR');

define('MODULE_SHIPPING_DHL_COUNTRIES_4_TITLE' , 'Zone 3 Countries');
define('MODULE_SHIPPING_DHL_COUNTRIES_4_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 3 (Enter WORLD for the rest of the world.).');
define('MODULE_SHIPPING_DHL_COST_DOX_4_TITLE' , 'Shipping Table Zone 3 up to 10 kg DOX');
define('MODULE_SHIPPING_DHL_COST_DOX_4_DESC' , 'Shipping Table Zone 3, based on <b>\'DOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_WPX_4_TITLE' , 'Shipping Table Zone 3 up to 10 kg WPX');
define('MODULE_SHIPPING_DHL_COST_WPX_4_DESC' , 'Shipping Table Zone 3, based on <b>\'WPX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_MDX_4_TITLE' , 'Shipping Table Zone 3 up to 10 kg MDX');
define('MODULE_SHIPPING_DHL_COST_MDX_4_DESC' , 'Shipping Table Zone 3, based on <b>\'MDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_SDX_4_TITLE' , 'Shipping Table Zone 3 up to 10 kg SDX');
define('MODULE_SHIPPING_DHL_COST_SDX_4_DESC' , 'Shipping Table Zone 3, based on <b>\'SDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_4_TITLE' , 'Extra charge up to 20 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_4_TITLE' , 'Extra charge up to 30 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_4_TITLE' , 'Extra charge up to 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_4_TITLE' , 'Extra charge up from 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_4_TITLE' , 'Extra charge up to 20 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_4_TITLE' , 'Extra charge up to 30 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_4_TITLE' , 'Extra charge up to 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_4_TITLE' , 'Extra charge up from 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_4_TITLE' , 'Extra charge up to 20 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_4_TITLE' , 'Extra charge up to 30 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_4_TITLE' , 'Extra charge up to 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_4_TITLE' , 'Extra charge up from 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_4_TITLE' , 'Extra charge up to 20 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_4_TITLE' , 'Extra charge up to 30 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_4_TITLE' , 'Extra charge up to 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_4_TITLE' , 'Extra charge up from 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_4_DESC' , 'Extra charge each additional 0,50 kg in EUR');

define('MODULE_SHIPPING_DHL_COUNTRIES_5_TITLE' , 'Zone 4 Countries');
define('MODULE_SHIPPING_DHL_COUNTRIES_5_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 4 (Enter WORLD for the rest of the world.).');
define('MODULE_SHIPPING_DHL_COST_DOX_5_TITLE' , 'Shipping Table Zone 4 up to 10 kg DOX');
define('MODULE_SHIPPING_DHL_COST_DOX_5_DESC' , 'Shipping Table Zone 4, based on <b>\'DOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_WPX_5_TITLE' , 'Shipping Table Zone 4 up to 10 kg WPX');
define('MODULE_SHIPPING_DHL_COST_WPX_5_DESC' , 'Shipping Table Zone 4, based on <b>\'WPX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_MDX_5_TITLE' , 'Shipping Table Zone 4 up to 10 kg MDX');
define('MODULE_SHIPPING_DHL_COST_MDX_5_DESC' , 'Shipping Table Zone 4, based on <b>\'MDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_SDX_5_TITLE' , 'Shipping Table Zone 4 up to 10 kg SDX');
define('MODULE_SHIPPING_DHL_COST_SDX_5_DESC' , 'Shipping Table Zone 4, based on <b>\'SDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_5_TITLE' , 'Extra charge up to 20 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_5_TITLE' , 'Extra charge up to 30 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_5_TITLE' , 'Extra charge up to 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_5_TITLE' , 'Extra charge up from 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_5_TITLE' , 'Extra charge up to 20 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_5_TITLE' , 'Extra charge up to 30 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_5_TITLE' , 'Extra charge up to 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_5_TITLE' , 'Extra charge up from 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_5_TITLE' , 'Extra charge up to 20 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_5_TITLE' , 'Extra charge up to 30 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_5_TITLE' , 'Extra charge up to 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_5_TITLE' , 'Extra charge up from 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_5_TITLE' , 'Extra charge up to 20 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_5_TITLE' , 'Extra charge up to 30 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_5_TITLE' , 'Extra charge up to 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_5_TITLE' , 'Extra charge up from 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_5_DESC' , 'Extra charge each additional 0,50 kg in EUR');

define('MODULE_SHIPPING_DHL_COUNTRIES_6_TITLE' , 'Zone 5 Countries');
define('MODULE_SHIPPING_DHL_COUNTRIES_6_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 5 (Enter WORLD for the rest of the world.).');
define('MODULE_SHIPPING_DHL_COST_DOX_6_TITLE' , 'Shipping Table Zone 5 up to 10 kg DOX');
define('MODULE_SHIPPING_DHL_COST_DOX_6_DESC' , 'Shipping Table Zone 5, based on <b>\'DOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_WPX_6_TITLE' , 'Shipping Table Zone 5 up to 10 kg WPX');
define('MODULE_SHIPPING_DHL_COST_WPX_6_DESC' , 'Shipping Table Zone 5, based on <b>\'WPX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_6_TITLE' , 'Extra charge up to 20 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_6_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_6_TITLE' , 'Extra charge up to 30 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_6_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_6_TITLE' , 'Extra charge up to 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_6_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_6_TITLE' , 'Extra charge up from 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_6_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_6_TITLE' , 'Extra charge up to 20 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_6_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_6_TITLE' , 'Extra charge up to 30 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_6_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_6_TITLE' , 'Extra charge up to 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_6_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_6_TITLE' , 'Extra charge up from 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_6_DESC' , 'Extra charge each additional 0,50 kg in EUR');

define('MODULE_SHIPPING_DHL_COUNTRIES_7_TITLE' , 'Zone 6 Countries');
define('MODULE_SHIPPING_DHL_COUNTRIES_7_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 6 (Enter WORLD for the rest of the world.).');
define('MODULE_SHIPPING_DHL_COST_DOX_7_TITLE' , 'Shipping Table Zone 6 up to 10 kg DOX');
define('MODULE_SHIPPING_DHL_COST_DOX_7_DESC' , 'Shipping Table Zone 6, based on <b>\'DOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_WPX_7_TITLE' , 'Shipping Table Zone 6 up to 10 kg WPX');
define('MODULE_SHIPPING_DHL_COST_WPX_7_DESC' , 'Shipping Table Zone 6, based on <b>\'WPX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_7_TITLE' , 'Extra charge up to 20 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_7_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_7_TITLE' , 'Extra charge up to 30 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_7_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_7_TITLE' , 'Extra charge up to 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_7_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_7_TITLE' , 'Extra charge up from 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_7_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_7_TITLE' , 'Extra charge up to 20 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_7_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_7_TITLE' , 'Extra charge up to 30 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_7_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_7_TITLE' , 'Extra charge up to 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_7_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_7_TITLE' , 'Extra charge up from 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_7_DESC' , 'Extra charge each additional 0,50 kg in EUR');

define('MODULE_SHIPPING_DHL_COUNTRIES_8_TITLE' , 'Zone 7 Countries');
define('MODULE_SHIPPING_DHL_COUNTRIES_8_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 7 (Enter WORLD for the rest of the world.).');
define('MODULE_SHIPPING_DHL_COST_DOX_8_TITLE' , 'Shipping Table Zone 7 up to 10 kg DOX');
define('MODULE_SHIPPING_DHL_COST_DOX_8_DESC' , 'Shipping Table Zone 7, based on <b>\'DOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_WPX_8_TITLE' , 'Shipping Table Zone 7 up to 10 kg WPX');
define('MODULE_SHIPPING_DHL_COST_WPX_8_DESC' , 'Shipping Table Zone 7, based on <b>\'WPX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_MDX_8_TITLE' , 'Shipping Table Zone 7 up to 10 kg MDX');
define('MODULE_SHIPPING_DHL_COST_MDX_8_DESC' , 'Shipping Table Zone 7, based on <b>\'MDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_SDX_8_TITLE' , 'Shipping Table Zone 7 up to 10 kg SDX');
define('MODULE_SHIPPING_DHL_COST_SDX_8_DESC' , 'Shipping Table Zone 7, based on <b>\'SDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_8_TITLE' , 'Extra charge up to 20 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_8_TITLE' , 'Extra charge up to 30 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_8_TITLE' , 'Extra charge up to 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_8_TITLE' , 'Extra charge up from 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_8_TITLE' , 'Extra charge up to 20 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_8_TITLE' , 'Extra charge up to 30 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_8_TITLE' , 'Extra charge up to 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_8_TITLE' , 'Extra charge up from 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_8_TITLE' , 'Extra charge up to 20 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_8_TITLE' , 'Extra charge up to 30 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_8_TITLE' , 'Extra charge up to 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_8_TITLE' , 'Extra charge up from 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_8_TITLE' , 'Extra charge up to 20 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_8_TITLE' , 'Extra charge up to 30 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_8_TITLE' , 'Extra charge up to 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_8_TITLE' , 'Extra charge up from 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_8_DESC' , 'Extra charge each additional 0,50 kg in EUR');

define('MODULE_SHIPPING_DHL_COUNTRIES_9_TITLE' , 'Zone 8 Countries');
define('MODULE_SHIPPING_DHL_COUNTRIES_9_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 8 (Enter WORLD for the rest of the world.).');
define('MODULE_SHIPPING_DHL_COST_DOX_9_TITLE' , 'Shipping Table Zone 8 up to 10 kg DOX');
define('MODULE_SHIPPING_DHL_COST_DOX_9_DESC' , 'Shipping Table Zone 8, based on <b>\'DOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_WPX_9_TITLE' , 'Shipping Table Zone 8 up to 10 kg WPX');
define('MODULE_SHIPPING_DHL_COST_WPX_9_DESC' , 'Shipping Table Zone 8, based on <b>\'WPX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_MDX_9_TITLE' , 'Shipping Table Zone 8 up to 10 kg MDX');
define('MODULE_SHIPPING_DHL_COST_MDX_9_DESC' , 'Shipping Table Zone 8, based on <b>\'MDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_SDX_9_TITLE' , 'Shipping Table Zone 8 up to 10 kg SDX');
define('MODULE_SHIPPING_DHL_COST_SDX_9_DESC' , 'Shipping Table Zone 8, based on <b>\'SDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_9_TITLE' , 'Extra charge up to 20 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_9_TITLE' , 'Extra charge up to 30 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_9_TITLE' , 'Extra charge up to 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_9_TITLE' , 'Extra charge up from 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_9_TITLE' , 'Extra charge up to 20 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_9_TITLE' , 'Extra charge up to 30 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_9_TITLE' , 'Extra charge up to 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_9_TITLE' , 'Extra charge up from 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_9_TITLE' , 'Extra charge up to 20 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_9_TITLE' , 'Extra charge up to 30 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_9_TITLE' , 'Extra charge up to 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_9_TITLE' , 'Extra charge up from 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_9_TITLE' , 'Extra charge up to 20 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_9_TITLE' , 'Extra charge up to 30 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_9_TITLE' , 'Extra charge up to 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_9_TITLE' , 'Extra charge up from 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_9_DESC' , 'Extra charge each additional 0,50 kg in EUR');

define('MODULE_SHIPPING_DHL_COUNTRIES_10_TITLE' , 'Zone 9 Countries');
define('MODULE_SHIPPING_DHL_COUNTRIES_10_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 9 (Enter WORLD for the rest of the world.).');
define('MODULE_SHIPPING_DHL_COST_DOX_10_TITLE' , 'Shipping Table Zone 9 up to 10 kg DOX');
define('MODULE_SHIPPING_DHL_COST_DOX_10_DESC' , 'Shipping Table Zone 9, based on <b>\'DOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_WPX_10_TITLE' , 'Shipping Table Zone 9 up to 10 kg WPX');
define('MODULE_SHIPPING_DHL_COST_WPX_10_DESC' , 'Shipping Table Zone 9, based on <b>\'WPX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_MDX_10_TITLE' , 'Shipping Table Zone 9 up to 10 kg MDX');
define('MODULE_SHIPPING_DHL_COST_MDX_10_DESC' , 'Shipping Table Zone 9, based on <b>\'MDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_COST_SDX_10_TITLE' , 'Shipping Table Zone 9 up to 10 kg SDX');
define('MODULE_SHIPPING_DHL_COST_SDX_10_DESC' , 'Shipping Table Zone 9, based on <b>\'SDX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_10_TITLE' , 'Extra charge up to 20 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_20_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_10_TITLE' , 'Extra charge up to 30 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_30_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_10_TITLE' , 'Extra charge up to 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_50_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_10_TITLE' , 'Extra charge up from 50 kg DOX');
define('MODULE_SHIPPING_DHL_STEP_DOX_51_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_10_TITLE' , 'Extra charge up to 20 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_20_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_10_TITLE' , 'Extra charge up to 30 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_30_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_10_TITLE' , 'Extra charge up to 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_50_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_10_TITLE' , 'Extra charge up from 50 kg WPX');
define('MODULE_SHIPPING_DHL_STEP_WPX_51_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_10_TITLE' , 'Extra charge up to 20 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_20_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_10_TITLE' , 'Extra charge up to 30 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_30_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_10_TITLE' , 'Extra charge up to 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_50_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_10_TITLE' , 'Extra charge up from 50 kg MDX');
define('MODULE_SHIPPING_DHL_STEP_MDX_51_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_10_TITLE' , 'Extra charge up to 20 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_20_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_10_TITLE' , 'Extra charge up to 30 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_30_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_10_TITLE' , 'Extra charge up to 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_50_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_10_TITLE' , 'Extra charge up from 50 kg SDX');
define('MODULE_SHIPPING_DHL_STEP_SDX_51_10_DESC' , 'Extra charge each additional 0,50 kg in EUR');
?>
