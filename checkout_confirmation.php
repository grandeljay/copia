<?php

/* -----------------------------------------------------------------------------------------
   $Id: checkout_confirmation.php 13182 2021-01-18 09:02:07Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_confirmation.php,v 1.137 2003/05/07); www.oscommerce.com
   (c) 2003 nextcommerce (checkout_confirmation.php,v 1.21 2003/08/17); www.nextcommerce.org
   (c) 2006 XT-Commerce (checkout_confirmation.php 1277 2005-10-01)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   agree_conditions_1.01          Autor:  Thomas Plänkers (webmaster@oscommerce.at)

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c) Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// use always session_id from URL for payment providers
define('SESSION_FORCE_COOKIE_USE', 'False');

include('includes/application_top.php');

// create smarty elements
$smarty = new Smarty();

// include needed functions
require_once(DIR_FS_INC . 'xtc_collect_posts.inc.php');
require_once(DIR_FS_INC . 'xtc_calculate_tax.inc.php');
require_once(DIR_FS_INC . 'xtc_display_tax_value.inc.php');

require(DIR_WS_INCLUDES . 'checkout_requirements.php');

if (isset($_POST['payment'])) {
    $_SESSION['payment'] = xtc_db_prepare_input($_POST['payment']);
}

if (isset($_POST['comments_added']) && $_POST['comments_added'] != '') {
    $_SESSION['comments'] = xtc_db_prepare_input($_POST['comments']);
}

if (isset($_POST['cot_gv'])) {
    $_SESSION['cot_gv'] = $_POST['cot_gv'];
}

// if conditions are not accepted, redirect the customer to the payment method selection page
if (SIGN_CONDITIONS_ON_CHECKOUT == 'true') {
    if ((!isset($_POST['conditions']) || $_POST['conditions'] == false) && !isset($_GET['conditions'])) {
        $error = str_replace('\n', '<br />', ERROR_CONDITIONS_NOT_ACCEPTED);
        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode($error), 'SSL', true, false));
    }
}

if (DISPLAY_PRIVACY_ON_CHECKOUT == 'true' && DISPLAY_PRIVACY_CHECK == 'true') {
    if ((!isset($_POST['privacy']) || $_POST['privacy'] == false) && !isset($_GET['conditions'])) {
        $error = str_replace('\n', '<br />', ERROR_PRIVACY_NOTICE_NOT_ACCEPTED);
        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode($error), 'SSL', true, false));
    }
}

$content_type = $_SESSION['cart']->get_content_type();
if (
    DISPLAY_REVOCATION_VIRTUAL_ON_CHECKOUT == 'true'
    && ($_SESSION['cart']->content_type == 'virtual'
        || $_SESSION['cart']->content_type == 'mixed')
) {
    if ((!isset($_POST['revocation']) || $_POST['revocation'] == false) && !isset($_GET['conditions'])) {
        $error = str_replace('\n', '<br />', ERROR_REVOCATION_NOT_ACCEPTED);
        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode($error), 'SSL', true, false));
    }
}

if (
    ACTIVATE_GIFT_SYSTEM == 'true'
    && isset($_GET['action'])
    && $_GET['action'] == 'check_gift_checkout'
) {
    xtc_collect_posts();
}

// load the selected payment module
require_once(DIR_WS_CLASSES . 'payment.php');
if (
    isset($_SESSION['credit_covers'])
    || (isset($_SESSION['cot_gv']) && !isset($_SESSION['payment']))
    || (isset($_SESSION['cot_gv']) && isset($_POST['credit_order_total']) && $_SESSION['cot_gv'] >= $_POST['credit_order_total'])
) {
    $_SESSION['payment'] = 'no_payment'; // GV Code Start/End ICW added for CREDIT CLASS
}

if (!isset($_SESSION['payment'])) {
    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
}

$payment_modules = new payment($_SESSION['payment']);

// GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
require_once(DIR_WS_CLASSES . 'order_total.php');
require_once(DIR_WS_CLASSES . 'order.php');
$order = new order();

$payment_modules->update_status();

// GV Code Start
$order_total_modules = new order_total();
$order_total_modules->collect_posts();
$order_total_modules->pre_confirmation_check();
// GV Code End

// GV Code line changed
if (
    (is_array($payment_modules->modules)
     && sizeof($payment_modules->modules) > 0
     && !isset($_SESSION['credit_covers'])
     && (!isset(${$_SESSION['payment']}) || !is_object(${$_SESSION['payment']})))
    ||
    (isset(${$_SESSION['payment']})
     && is_object(${$_SESSION['payment']})
     && ${$_SESSION['payment']}->enabled == false)
    ||
    (isset($_SESSION['cot_gv'])
     && $_SESSION['cot_gv'] > 0
     && $xtPrice->xtcFormat($order->info['total'], false) > $_SESSION['cot_gv']
     && $_SESSION['payment'] == 'no_payment')
) {
    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
}

// include boxes
require(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

if (ACTIVATE_GIFT_SYSTEM == 'true') {
    include(DIR_WS_MODULES . 'gift_cart.php');
}

if (is_array($payment_modules->modules)) {
    $payment_modules->pre_confirmation_check();
}

// load the selected shipping module
require_once(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']);

if (MODULE_ORDER_TOTAL_INSTALLED) {
    $order_total_modules->process();
    $total_block = $order_total_modules->output();
    $smarty->assign('TOTAL_BLOCK', $total_block);
    $smarty->assign('TOTAL_BLOCK_ARRAY', $order_total_modules->output_array());
}

if (SHOW_IP_LOG == 'true') {
  // include needed functions
    require_once(DIR_FS_INC . 'ip_clearing.inc.php');
    $smarty->assign('IP_LOG', 'true');
    $smarty->assign('CUSTOMERS_IP', ip_clearing($_SESSION['tracking']['ip']));
}

//allow duty-note in checkout_confirmation
$smarty->assign('DELIVERY_DUTY_INFO', $main->getDeliveryDutyInfo($order->delivery['country']['iso_code_2']));

if ($_SESSION['shipping'] !== false) {
    $smarty->assign('DELIVERY_LABEL', xtc_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'));
    $smarty->assign('SHIPPING_ADDRESS_EDIT', xtc_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'));
}
if (!isset($_SESSION['credit_covers']) || $_SESSION['credit_covers'] != '1') {
    $smarty->assign('BILLING_LABEL', xtc_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'));
    $smarty->assign('BILLING_ADDRESS_EDIT', xtc_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL'));
}
$smarty->assign('PRODUCTS_EDIT', xtc_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));

if ($_SESSION['sendto'] != false) {
    if ($order->info['shipping_method']) {
      //shipping method
        $shipping_class = explode('_', $order->info['shipping_class']);
        if ($order->info['shipping_class'] != '' && $shipping_class[0] != 'free') {
            include_once(DIR_FS_CATALOG . 'lang/' . $_SESSION['language'] . '/modules/shipping/' . $shipping_class[0] . '.php');
            $shipping_method = constant(strtoupper('MODULE_SHIPPING_' . $shipping_class[0] . '_TEXT_TITLE'));
        } else {
            include_once(DIR_FS_CATALOG . 'lang/' . $_SESSION['language'] . '/modules/order_total/ot_shipping.php');
            $shipping_method = FREE_SHIPPING_TITLE;
        }
        $smarty->assign('SHIPPING_METHOD', $shipping_method);
        $smarty->assign('SHIPPING_CLASS', $order->info['shipping_class']);

        $smarty->assign('SHIPPING_EDIT', xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
}

//new output array, set in includes/classes/order.php function cart
$smarty->assign('PRODUCTS_ARRAY', $order->products);

$smarty->assign('ORDER_TAX_GROUPS', sizeof($order->info['tax_groups']));

if ($order->info['payment_method'] != 'no_payment' && $order->info['payment_method'] != '') {
    $smarty->assign('PAYMENT_METHOD', $payment_modules::payment_title($order->info['payment_method']));
    $smarty->assign('PAYMENT_EDIT', xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}

$no_payment = false;
if ($_SESSION['cart']->show_total() <= 0 && count($order->totals) == 0) {
    $no_payment = true;
    $smarty->clear_assign('PAYMENT_EDIT');
};

if ($no_payment === false && isset($_SESSION['credit_covers']) && $order->info['payment_method'] == 'no_payment') {
    include_once(DIR_WS_LANGUAGES . '/' . $_SESSION['language'] . '/modules/order_total/ot_gv.php');
    $smarty->assign('PAYMENT_METHOD', constant('MODULE_ORDER_TOTAL_GV_TITLE'));
}

if (is_array($payment_modules->modules) && ($confirmation = $payment_modules->confirmation())) { // $confirmation['title'];
    $smarty->assign('PAYMENT_INFORMATION', (isset($confirmation['fields']) ? $confirmation['fields'] : ''));
}

if (xtc_not_null($order->info['comments'])) {
    $smarty->assign('ORDER_COMMENTS', nl2br(encode_htmlspecialchars($order->info['comments'])) . xtc_draw_hidden_field('comments', $order->info['comments']));
}

if (isset(${$_SESSION['payment']}->form_action_url) && (!isset(${$_SESSION['payment']}->tmpOrders) || !${$_SESSION['payment']}->tmpOrders)) {
    $form_action_url = ${$_SESSION['payment']}->form_action_url;
} else {
    $form_action_url = xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
}
$smarty->assign('CHECKOUT_FORM', xtc_draw_form('checkout_confirmation', $form_action_url, 'post', 'name="checkout_confirmation"'));
$smarty->assign('MODULE_BUTTONS', (is_array($payment_modules->modules) ? $payment_modules->process_button() : ''));
$smarty->assign('CHECKOUT_BUTTON', xtc_image_submit('button_confirm_order.gif', IMAGE_BUTTON_CONFIRM_ORDER, (($_SESSION['payment'] == 'payone_cc') ? 'onclick="return payoneCheck();"' : '') . ' id="button_checkout_confirmation"') . '</form>' . "\n");

//express checkout
if (defined('MODULE_CHECKOUT_EXPRESS_STATUS') && MODULE_CHECKOUT_EXPRESS_STATUS == 'true') {
    if (isset($_POST['express'])) {
        $check_query = xtc_db_query("SELECT *
                                   FROM " . TABLE_CUSTOMERS_CHECKOUT . "
                                  WHERE customers_id = '" . (int) $_SESSION['customer_id'] . "'");

        $sql_data_array = array('customers_id' => (int)$_SESSION['customer_id'],
                            'checkout_shipping_address' => $_SESSION['sendto'],
                            'checkout_payment' => $_SESSION['payment'],
                            'checkout_payment_address' => $_SESSION['billto'],
                            );
        if (
            isset($_SESSION['shipping'])
            && is_array($_SESSION['shipping'])
            && array_key_exists('id', $_SESSION['shipping'])
        ) {
            $sql_data_array['checkout_shipping'] = $_SESSION['shipping']['id'];
        }
        if (xtc_db_num_rows($check_query) < 1) {
            xtc_db_perform(TABLE_CUSTOMERS_CHECKOUT, $sql_data_array);
        } else {
            unset($sql_data_array['customers_id']);
            xtc_db_perform(TABLE_CUSTOMERS_CHECKOUT, $sql_data_array, 'update', "customers_id = '" . (int)$_SESSION['customer_id'] . "'");
        }
        $smarty->assign('success_message', SUCCESS_CHECKOUT_EXPRESS_UPDATED);
    }
  // disable some modules, because needed action on checkout_payment
    $disallowed_payment = array(
    'banktransfer',
    'paypalplus',
    'payone_installment',
    'payone_otrans',
    );
    if ($no_payment === false && !in_array($_SESSION['payment'], $disallowed_payment)) {
        $smarty->assign('FORM_ACTION', xtc_draw_form('customers_express', xtc_href_link(FILENAME_CHECKOUT_CONFIRMATION, 'conditions=on', 'SSL'), 'post', 'name="customers_express"') . xtc_draw_hidden_field('express', 'on'));
        $smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_save.gif', IMAGE_BUTTON_UPDATE));
        if (MODULE_CHECKOUT_EXPRESS_CONTENT != '') {
            $smarty->assign('EXPRESS_LINK', $main->getContentLink(MODULE_CHECKOUT_EXPRESS_CONTENT, MORE_INFO, 'SSL'));
        }
        $smarty->assign('FORM_END', '</form>');
        $smarty->assign('EXPRESS', true);
    }
}

if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
    $shop_content_link = '';
    if (DISPLAY_REVOCATION_ON_CHECKOUT == 'true') {
        $shop_revocation_data = $main->getContentData(REVOCATION_ID);
        $shop_revocation_link = $main->getContentLink(REVOCATION_ID, MORE_INFO, 'SSL');
        $smarty->assign('REVOCATION', $shop_revocation_data['content_text']);
        $smarty->assign('REVOCATION_TITLE', $shop_revocation_data['content_heading']);
        $smarty->assign('REVOCATION_LINK', $shop_revocation_link);
        $shop_revocation_link = sprintf(TEXT_REVOCATION_CHECKOUT, $shop_revocation_link);
    }

    $shop_content_data = $main->getContentData(3);
    $shop_content_link = $main->getContentLink(3, MORE_INFO, 'SSL');
    $smarty->assign('AGB_TITLE', $shop_content_data['content_heading']);
    $smarty->assign('AGB_LINK', $shop_content_link);

    $shop_content_link .= $shop_revocation_link;
    $smarty->assign('TEXT_AGB_CHECKOUT', sprintf(TEXT_AGB_CHECKOUT, $shop_content_link, $main->getContentLink(2, MORE_INFO, 'SSL')));
}

$store_owner = STORE_NAME;
if (defined('DISPLAY_HEADQUARTER_ON_CHECKOUT') && DISPLAY_HEADQUARTER_ON_CHECKOUT == 'true') {
    $store_owner = explode("\n", STORE_OWNER . "\n" . STORE_NAME_ADDRESS);
    for ($i = 0, $n = count($store_owner); $i < $n; $i++) {
        if (trim($store_owner[$i]) == '') {
            unset($store_owner[$i]);
        } else {
            $store_owner[$i] = trim($store_owner[$i]);
        }
    }
    $store_owner = implode(', ', $store_owner);
}
$smarty->assign('HEADQUARTER', $store_owner);

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION, xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION);

require(DIR_WS_INCLUDES . 'header.php');

if ($order->content_type == 'virtual' || ($order->content_type == 'virtual_weight') || ($_SESSION['cart']->count_contents_virtual() == 0)) {
    $_SESSION['NO_SHIPPING'] = true;
    $smarty->assign('NO_SHIPPING', $_SESSION['NO_SHIPPING']);
}
$backlink = xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL');
$smarty->assign('BUTTON_BACK', '<a href="' . $backlink . '">' . xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>');
$smarty->assign('BUTTON_BACK_LINK', $backlink);

$smarty->assign('language', $_SESSION['language']);
$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/checkout_confirmation.html');
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined('RM')) {
    $smarty->load_filter('output', 'note');
}
$smarty->display(CURRENT_TEMPLATE . '/index.html');

include('includes/application_bottom.php');
