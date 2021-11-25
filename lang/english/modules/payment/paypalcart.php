<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypalcart.php 11030 2017-12-08 07:50:06Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


$lang_array = array(
  'MODULE_PAYMENT_PAYPALCART_TEXT_TITLE' => 'PayPal Express',
  'MODULE_PAYMENT_PAYPALCART_TEXT_INFO' => '<img src="https://www.paypal.com/de_DE/DE/i/logo/lockbox_150x47.gif" />',
  'MODULE_PAYMENT_PAYPALCART_TEXT_DESCRIPTION' => 'PayPal Express Checkout - the PayPal button in the shopping cart and on the article page for maximum conversion.<br/>You can find more information about PayPal Express Shortcut <a target="_blank" href="https://www.paypal.com/de/webapps/mpp/express-checkout">here</a>.',
  'MODULE_PAYMENT_PAYPALCART_ALLOWED_TITLE' => 'Allowed zones',
  'MODULE_PAYMENT_PAYPALCART_ALLOWED_DESC' => 'Please enter the zones <b>separately</b> which should be allowed to use this module (e.g. AT,DE (leave empty if you want to allow all zones))',
  'MODULE_PAYMENT_PAYPALCART_STATUS_TITLE' => 'Enable PayPal Express',
  'MODULE_PAYMENT_PAYPALCART_STATUS_DESC' => 'Do you want to accept PayPal Express payments?',
  'MODULE_PAYMENT_PAYPALCART_SORT_ORDER_TITLE' => 'Sort order',
  'MODULE_PAYMENT_PAYPALCART_SORT_ORDER_DESC' => 'Sort order of the view. Lowest numeral will be displayed first',
  'MODULE_PAYMENT_PAYPALCART_ZONE_TITLE' => 'Payment zone',
  'MODULE_PAYMENT_PAYPALCART_ZONE_DESC' => 'If a zone is choosen, the payment method will be valid for this zone only.',
  'MODULE_PAYMENT_PAYPALCART_LP' => '<br /><br /><a target="_blank" href="http://www.paypal.com/de/webapps/mpp/referral/paypal-business-account2?partner_id=EHALBVD4M2RQS"><strong>Create PayPal account now.</strong></a>',

  'MODULE_PAYMENT_PAYPALCART_TEXT_EXTENDED_DESCRIPTION' => '<strong><font color="red">ATTENTION:</font></strong> Please setup PayPal configuration under "Partner Modules" -> "PayPal" -> <a href="'.xtc_href_link('paypal_config.php').'"><strong>"PayPal Configuration"</strong></a>!',

  'MODULE_PAYMENT_PAYPALCART_TEXT_ERROR_HEADING' => 'Note',
  'MODULE_PAYMENT_PAYPALCART_TEXT_ERROR_MESSAGE' => 'PayPal payment has been canceled',

  'TEXT_PAYPAL_CART_ACCOUNT_CREATED' => 'We have created a customer account with your PayPal E-Mail address. You can request the password for your new customer account later using the "Forgotten Password" function.',
);


foreach ($lang_array as $key => $val) {
  defined($key) or define($key, $val);
}
?>