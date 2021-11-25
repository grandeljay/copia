<?php
/* -----------------------------------------------------------------------------------------
   $Id: exclude_payment.php 12545 2020-01-24 08:01:50Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_EXCLUDE_PAYMENT_TEXT_TITLE', 'Payment methods depending on shipping method');
define('MODULE_EXCLUDE_PAYMENT_TEXT_DESCRIPTION', '');
define('MODULE_EXCLUDE_PAYMENT_STATUS_TITLE' , 'Status');
define('MODULE_EXCLUDE_PAYMENT_STATUS_DESC' , 'Enable module?');
define('MODULE_EXCLUDE_PAYMENT_NUMBER_TITLE' , 'Number of shipping methods');
define('MODULE_EXCLUDE_PAYMENT_NUMBER_DESC' , 'Number of delivery options to be configured.');

if (defined('MODULE_EXCLUDE_PAYMENT_NUMBER')) {
  for ($module_exclude_payment_i = 1; $module_exclude_payment_i <= (int)MODULE_EXCLUDE_PAYMENT_NUMBER; $module_exclude_payment_i ++) {
    define('MODULE_EXCLUDE_PAYMENT_SHIPPING_'.$module_exclude_payment_i.'_TITLE' , '<hr noshade>'.$module_exclude_payment_i.'. shipping method');
    define('MODULE_EXCLUDE_PAYMENT_SHIPPING_'.$module_exclude_payment_i.'_DESC' , 'Select the delivery method where you want to exclude a payment method.');
    define('MODULE_EXCLUDE_PAYMENT_PAYMENT_'.$module_exclude_payment_i.'_TITLE' , $module_exclude_payment_i.'. excluded payment method');
    define('MODULE_EXCLUDE_PAYMENT_PAYMENT_'.$module_exclude_payment_i.'_DESC' , 'Select the payment method you want to exclude.');
  }
}
?>