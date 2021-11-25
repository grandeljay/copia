<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypalplus_redirect.php 12388 2019-11-08 09:25:40Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

chdir('../../');
include('includes/application_top.php');

if (!isset($_SESSION['customer_id'])) {
  xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));
}

require (DIR_WS_INCLUDES.'checkout_requirements.php');

// include needed classes
require_once(DIR_FS_EXTERNAL.'paypal/classes/PayPalPayment.php');                                      

// load the selected shipping module
require_once (DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']);

// order
require_once (DIR_WS_CLASSES . 'order.php');
$order = new order();

$found = false;
$selection = get_third_party_payments();
for ($i = 0, $n = sizeof($selection); $i < $n; $i++) {
  if ($selection[$i]['id'] == $_GET['payment']) {
    $_SESSION['payment'] = $selection[$i]['id'];
    $found = true;
  }
}

if ($found === true) {
  xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_CONFIRMATION, 'conditions=true', 'SSL'));
} else {
  xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}
?>