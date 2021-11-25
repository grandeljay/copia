<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypal_module.php 11018 2017-12-06 13:58:54Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


$lang_array = array(
  'TEXT_PAYPAL_MODULE_HEADING_TITLE' => 'PayPal Products',
  
  'TABLE_HEADING_MODULES' => 'Module',
  'TABLE_HEADING_FILENAME' => 'Module name (for internal usage)',
  'TABLE_HEADING_SORT_ORDER' => 'Sorting',
  'TABLE_HEADING_STATUS' => 'Status',
  'TABLE_HEADING_ACTION' => 'Action',

  'TABLE_HEADING_WALL_STATUS' => 'Display at Paymentwall',
  'TABLE_HEADING_WALL_DESCRIPTION' => 'Description',
  
  'TEXT_PAYPAL_MODULE_PROFILE' => 'Profile',
  'TEXT_PAYPAL_NO_PROFILE' => 'no Webprofile',
  'TEXT_PAYPAL_STANDARD_PROFILE' => 'Standard Webprofile',
  
  'TEXT_PAYPAL_MODULE_LINK_SUCCESS' => 'Link at checkout',
  'TEXT_PAYPAL_MODULE_LINK_SUCCESS_INFO' => 'Shall the payment link be displayed in the checkout?',

  'TEXT_PAYPAL_MODULE_LINK_ACCOUNT' => 'Link at account',
  'TEXT_PAYPAL_MODULE_LINK_ACCOUNT_INFO' => 'Shall the payment link be displayed in the account?',

  'TEXT_PAYPAL_MODULE_LINK_PRODUCT' => 'Button at product',
  'TEXT_PAYPAL_MODULE_LINK_PRODUCT_INFO' => 'Shall the PayPal button be displayed in the product details?',

  'TEXT_PAYPAL_MODULE_USE_TABS' => 'Accordion / Tabs',
  'TEXT_PAYPAL_MODULE_USE_TABS_INFO' => 'Does the template use accordion or tabs in the checkout?',

  'TEXT_PAYPAL_MODULE_SHIPPING_COST' => 'provisional shipping costs',
  'TEXT_PAYPAL_MODULE_SHIPPING_COST_INFO' => 'Amount for provisional shipping costs.',

  'TEXT_PAYPAL_MODULE_UPSTREAM_PRODUCT' => 'Show at product',
  'TEXT_PAYPAL_MODULE_UPSTREAM_PRODUCT_INFO' => 'Show details for Installment at product?',

  'TEXT_PAYPAL_MODULE_UPSTREAM_CART' => 'Show at cart',
  'TEXT_PAYPAL_MODULE_UPSTREAM_CART_INFO' => 'Show details for Installment at cart?',

  'TEXT_PAYPAL_MODULE_UPSTREAM_PAYMENT' => 'Show at checkout',
  'TEXT_PAYPAL_MODULE_UPSTREAM_PAYMENT_INFO' => 'Show details for Installment during checkout?',
);


foreach ($lang_array as $key => $val) {
  defined($key) or define($key, $val);
}
?>