<?php

/* -----------------------------------------------------------------------------------------
   $Id: checkout_process.php 13470 2021-03-15 14:24:14Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_process.php,v 1.128 2003/05/28); www.oscommerce.com
   (c) 2003 nextcommerce (checkout_process.php,v 1.30 2003/08/24); www.nextcommerce.org
   (c) 2006 XT-Commerce (checkout_process.php 1277 2005-10-01)

   Released under the GNU General Public License
    ----------------------------------------------------------------------------------------
   Third Party contribution:

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

// stock decrement for downloads
defined('STOCK_LIMITED_DOWNLOADS') or define('STOCK_LIMITED_DOWNLOADS', 'false');

// include needed functions
require_once(DIR_FS_INC . 'xtc_calculate_tax.inc.php');
require_once(DIR_FS_INC . 'xtc_address_label.inc.php');
require_once(DIR_FS_INC . 'ip_clearing.inc.php');

// initialize smarty
$smarty = new Smarty();

require(DIR_WS_INCLUDES . 'checkout_requirements.php');

// load selected payment module
require_once(DIR_WS_CLASSES . 'payment.php');
if (isset($_SESSION['credit_covers'])) {
    $_SESSION['payment'] = ''; //ICW added for CREDIT CLASS
}
$payment_modules = new payment($_SESSION['payment']);

// if no shipping method has been selected, redirect the customer to the shipping page
if (!isset($_SESSION['shipping'])) {
    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
}

// load the selected shipping module
require_once(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']);

require_once(DIR_WS_CLASSES . 'order.php');
$order = new order();

// load the before_process function from the payment modules
$payment_modules->before_process();

require_once(DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total();
$order_totals = $order_total_modules->process();

// check if tmp order id exists
if (isset($_SESSION['tmp_oID']) && is_numeric($_SESSION['tmp_oID'])) {
    $tmp = false;
    $insert_id = $_SESSION['tmp_oID'];
} else {
  // check if tmp order need to be created
    if (isset(${$_SESSION['payment']}->form_action_url) && ${$_SESSION['payment']}->tmpOrders) {
        $tmp = true;
        $orders_status_id = ${$_SESSION['payment']}->tmpStatus;
    } else {
        $tmp = false;
        $orders_status_id = $order->info['order_status'];
    }

    if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
        $discount = $_SESSION['customers_status']['customers_status_ot_discount'];
    } else {
        $discount = '0.00';
    }

    $sql_data_array = array(
    'customers_id' => $_SESSION['customer_id'],
    'customers_name' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
    'customers_firstname' => $order->customer['firstname'],
    'customers_lastname' => $order->customer['lastname'],
    'customers_gender' => $order->customer['gender'],
    'customers_cid' => $order->customer['csID'],
    'customers_vat_id' => $_SESSION['customer_vat_id'],
    'customers_company' => $order->customer['company'],
    'customers_status' => $_SESSION['customers_status']['customers_status_id'],
    'customers_status_name' => $_SESSION['customers_status']['customers_status_name'],
    'customers_status_image' => $_SESSION['customers_status']['customers_status_image'],
    'customers_status_discount' => $discount,
    'customers_street_address' => $order->customer['street_address'],
    'customers_suburb' => $order->customer['suburb'],
    'customers_city' => $order->customer['city'],
    'customers_postcode' => $order->customer['postcode'],
    'customers_state' => ((isset($order->customer['state'])) ? $order->customer['state'] : ''),
    'customers_country' => $order->customer['country']['title'],
    'customers_telephone' => $order->customer['telephone'],
    'customers_email_address' => $order->customer['email_address'],
    'customers_country_iso_code_2' => $order->customer['country']['iso_code_2'],
    'customers_address_format_id' => $order->customer['format_id'],

    'delivery_name' => $order->delivery['firstname'] . ' ' . $order->delivery['lastname'],
    'delivery_firstname' => $order->delivery['firstname'],
    'delivery_lastname' => $order->delivery['lastname'],
    'delivery_gender' => $order->delivery['gender'],
    'delivery_company' => $order->delivery['company'],
    'delivery_street_address' => $order->delivery['street_address'],
    'delivery_suburb' => $order->delivery['suburb'],
    'delivery_city' => $order->delivery['city'],
    'delivery_postcode' => $order->delivery['postcode'],
    'delivery_state' => ((isset($order->delivery['state'])) ? $order->delivery['state'] : ''),
    'delivery_country' => $order->delivery['country']['title'],
    'delivery_country_iso_code_2' => $order->delivery['country']['iso_code_2'],
    'delivery_address_format_id' => $order->delivery['format_id'],

    'billing_name' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],
    'billing_firstname' => $order->billing['firstname'],
    'billing_lastname' => $order->billing['lastname'],
    'billing_gender' => $order->billing['gender'],
    'billing_company' => $order->billing['company'],
    'billing_street_address' => $order->billing['street_address'],
    'billing_suburb' => $order->billing['suburb'],
    'billing_city' => $order->billing['city'],
    'billing_postcode' => $order->billing['postcode'],
    'billing_state' => ((isset($order->billing['state'])) ? $order->billing['state'] : ''),
    'billing_country' => $order->billing['country']['title'],
    'billing_country_iso_code_2' => $order->billing['country']['iso_code_2'],
    'billing_address_format_id' => $order->billing['format_id'],

    'payment_method' => $order->info['payment_method'],
    'payment_class' => $order->info['payment_class'],
    'shipping_method' => $order->info['shipping_method'],
    'shipping_class' => $order->info['shipping_class'],
    'date_purchased' => 'now()',
    'orders_status' => $orders_status_id,
    'currency' => $order->info['currency'],
    'currency_value' => $order->info['currency_value'],
    'account_type' => $_SESSION['account_type'],
    'conversion_type' => 1,
    'customers_ip' => ip_clearing($_SESSION['tracking']['ip']),
    'language' => $_SESSION['language'],
    'languages_id' => (int)$_SESSION['languages_id'],
    'comments' => $order->info['comments'],
    );

  // refID
    $refID = '';
    if (isset($_SESSION['tracking']['refID'])) {
        $refID = $_SESSION['tracking']['refID'];
    } else {
        $campaign_query = xtc_db_query("SELECT cp.campaigns_refID
                                      FROM " . TABLE_CUSTOMERS . " c
                                      JOIN " . TABLE_CAMPAIGNS . " cp
                                           ON cp.campaigns_id = c.refferers_id
                                     WHERE c.customers_id = '" . (int)$_SESSION['customer_id'] . "'");
        if (xtc_db_num_rows($campaign_query) > 0) {
            $campaign = xtc_db_fetch_array($campaign_query);
            $refID = $campaign['campaigns_refID'];
        }
    }

    if ($refID != '') {
        $sql_data_array['campaign'] = $refID;
    }

  // check if late or direct sale
    $customers_logon_query = xtc_db_query("SELECT customers_info_number_of_logons
                                           FROM " . TABLE_CUSTOMERS_INFO . "
                                          WHERE customers_info_id  = '" . (int)$_SESSION['customer_id'] . "'");
    $customers_logon = xtc_db_fetch_array($customers_logon_query);
    if ($customers_logon['customers_info_number_of_logons'] > 1) {
        $sql_data_array['conversion_type'] = 2;
    }

    xtc_db_perform(TABLE_ORDERS, $sql_data_array);
    $insert_id = xtc_db_insert_id();
    $_SESSION['tmp_oID'] = $insert_id;

    for ($i = 0, $n = sizeof($order_totals); $i < $n; $i++) {
        $sql_data_array = array(
        'orders_id' => $insert_id,
        'title' => $order_totals[$i]['title'],
        'text' => $order_totals[$i]['text'],
        'value' => $order_totals[$i]['value'],
        'class' => $order_totals[$i]['code'],
        'sort_order' => $order_totals[$i]['sort_order']
        );
        xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
    }

  /* magnalister v1.0.1 */
    if (function_exists('magnaExecute')) {
        magnaExecute('magnaInsertOrderDetails', array('oID' => $insert_id), array('order_details.php'));
    }
    if (function_exists('magnaExecute')) {
        magnaExecute('magnaInventoryUpdate', array('action' => 'inventoryUpdateOrder'), array('inventoryUpdate.php'));
    }
  /* END magnalister */

    $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';

    $sql_data_array = array(
    'orders_id' => $insert_id,
    'orders_status_id' => $orders_status_id,
    'date_added' => 'now()',
    'customer_notified' => $customer_notification,
    'comments' => $order->info['comments']
    );
    xtc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

    $_SESSION['disable_products'] = array();
    for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
      // Stock Update
        $stock_set = '';
        if (STOCK_LIMITED == 'true') {
            if (DOWNLOAD_ENABLED == 'true' && STOCK_LIMITED_DOWNLOADS == 'false') {
                $add_stock_query_raw = '';
                $products_attributes = $order->products[$i]['attributes'];
                if (is_array($products_attributes)) {
                    $add_stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
                }
                $stock_query_raw = "SELECT products_quantity,
                                   pad.products_attributes_filename
                              FROM " . TABLE_PRODUCTS . " p
                         LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                   ON p.products_id = pa.products_id
                                      " . $add_stock_query_raw . "
                         LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                   ON pa.products_attributes_id = pad.products_attributes_id
                             WHERE p.products_id = '" . xtc_get_prid($order->products[$i]['id']) . "'";
                // Will work with only one option for downloadable products
                // otherwise, we have to build the query dynamically with a loop
                $stock_query = xtc_db_query($stock_query_raw);
            } else {
                $stock_query = xtc_db_query("SELECT products_quantity
                                       FROM " . TABLE_PRODUCTS . "
                                      WHERE products_id = '" . xtc_get_prid($order->products[$i]['id']) . "'");
            }
            if (xtc_db_num_rows($stock_query) > 0) {
                $stock_values = xtc_db_fetch_array($stock_query);
              // do not decrement quantities if products_attributes_filename exists
                if ((DOWNLOAD_ENABLED != 'true') || (!$stock_values['products_attributes_filename'])) {
                    $stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
                } else {
                    $stock_left = $stock_values['products_quantity'];
                }

                $stock_set = " products_quantity = '" . $stock_left . "', ";

                if (($stock_left < 1) && (STOCK_CHECKOUT_UPDATE_PRODUCTS_STATUS == 'true')) {
                    $_SESSION['disable_products'][] = xtc_get_prid($order->products[$i]['id']);
                }
            }
        }

      // update product
        xtc_db_query("UPDATE " . TABLE_PRODUCTS . "
                     SET " . $stock_set . "
                         products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . "
                   WHERE products_id = '" . xtc_get_prid($order->products[$i]['id']) . "'");

        $sql_data_array = array(
        'orders_id' => $insert_id,
        'products_id' => xtc_get_prid($order->products[$i]['id']),
        'products_model' => $order->products[$i]['model'],
        'products_ean' => $order->products[$i]['ean'],
        'products_name' => $order->products[$i]['name'],
        'products_price' => $order->products[$i]['price'],
        'products_price_origin' => $order->products[$i]['price_origin'],
        'products_shipping_time' => strip_tags($order->products[$i]['shipping_time']),
        'products_discount_made' => $order->products[$i]['discount_allowed'],
        'final_price' => $order->products[$i]['final_price'],
        'products_tax' => $order->products[$i]['tax'],
        'products_quantity' => $order->products[$i]['qty'],
        'allow_tax' => $_SESSION['customers_status']['customers_status_show_price_tax'],
        'products_order_description' => $order->products[$i]['order_description'],
        'products_weight' => $order->products[$i]['weight'],
        );

        foreach (auto_include(DIR_FS_CATALOG . 'includes/extra/checkout/checkout_process_products/', 'php') as $file) {
            require($file);
        }
        xtc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
        $order_products_id = xtc_db_insert_id();

      // update specials quantity
        $specials_query = xtc_db_query("SELECT products_id,
                                           specials_quantity
                                      FROM " . TABLE_SPECIALS . "
                                     WHERE products_id = '" . xtc_get_prid($order->products[$i]['id']) . "'
                                           " . SPECIALS_CONDITIONS);
        if (xtc_db_num_rows($specials_query)) {
            $specials = xtc_db_fetch_array($specials_query);
            if ($specials['specials_quantity'] != 0) {
                $specials_quantity = ($specials['specials_quantity'] - $order->products[$i]['qty']);

                $stock_set = '';
                if ($specials_quantity < 1) {
                    $stock_set = " status = '0', ";
                }

                xtc_db_query("UPDATE " . TABLE_SPECIALS . "
                         SET " . $stock_set . "
                             specials_quantity = '" . $specials_quantity . "'
                       WHERE products_id = '" . xtc_get_prid($order->products[$i]['id']) . "' ");
            }
        }

        $order_total_modules->update_credit_account($i); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM

        $attributes_exist = '0';
        $products_ordered_attributes = '';
        if (isset($order->products[$i]['attributes'])) {
            $attributes_exist = '1';
            $order->products[$i]['attributes'] = array_values($order->products[$i]['attributes']); // reset keys for $j
            for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) {
                // update attribute stock
                $update_attr_stock = false;
                if (
                    STOCK_LIMITED == 'true'
                    && isset($order->products[$i]['attributes'][$j]['value_id'])
                    && isset($order->products[$i]['attributes'][$j]['option_id'])
                ) {
                    $update_attr_stock = true;
                    if (DOWNLOAD_ENABLED == 'true' && STOCK_LIMITED_DOWNLOADS == 'false') {
                        $attr_stock_query = xtc_db_query("SELECT pad.products_attributes_filename
                                                FROM " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                                JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                                     ON pa.products_attributes_id=pad.products_attributes_id
                                               WHERE pa.products_id = '" . xtc_get_prid($order->products[$i]['id']) . "'
                                                 AND pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
                                                 AND pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'");
                        $update_attr_stock = ((xtc_db_num_rows($attr_stock_query) > 0) ? false : true);
                    }
                }

                // update attribute stock
                if ($update_attr_stock === true) {
                    xtc_db_query("UPDATE " . TABLE_PRODUCTS_ATTRIBUTES . "
                           SET attributes_stock = attributes_stock - '" . $order->products[$i]['qty'] . "'
                         WHERE products_id = '" . xtc_get_prid($order->products[$i]['id']) . "'
                           AND options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
                           AND options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
                         ");
                }

                // attributes
                $sql_data_array = array(
                'orders_id' => $insert_id,
                'orders_products_id' => $order_products_id,
                'products_options' => $order->products[$i]['attributes'][$j]['option'],
                'products_options_values' => $order->products[$i]['attributes'][$j]['value'],
                'attributes_model' => $order->products[$i]['attributes'][$j]['model'],
                'attributes_ean' => $order->products[$i]['attributes'][$j]['ean'],
                'options_values_price' => $order->products[$i]['attributes'][$j]['price'],
                'price_prefix' => $order->products[$i]['attributes'][$j]['prefix'],
                'orders_products_options_id' => $order->products[$i]['attributes'][$j]['option_id'],
                'orders_products_options_values_id' => $order->products[$i]['attributes'][$j]['value_id'],
                );

                foreach (auto_include(DIR_FS_CATALOG . 'includes/extra/checkout/checkout_process_attributes/', 'php') as $file) {
                    require($file);
                }
                xtc_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

                // attributes download
                if (DOWNLOAD_ENABLED == 'true') {
                    $attributes_dl_query = xtc_db_query("SELECT pad.products_attributes_maxdays,
                                                      pad.products_attributes_maxcount,
                                                      pad.products_attributes_filename
                                                 FROM " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                                   ON pa.products_attributes_id = pad.products_attributes_id
                                                WHERE pa.products_id = '" . $order->products[$i]['id'] . "'
                                                  AND pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
                                                  AND pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
                                             ");
                    $attributes_dl_array = xtc_db_fetch_array($attributes_dl_query);
                    if (isset($attributes_dl_array['products_attributes_filename']) && xtc_not_null($attributes_dl_array['products_attributes_filename'])) {
                          $sql_data_array = array(
                            'orders_id' => $insert_id,
                            'orders_products_id' => $order_products_id,
                            'orders_products_filename' => $attributes_dl_array['products_attributes_filename'],
                            'download_maxdays' => $attributes_dl_array['products_attributes_maxdays'],
                            'download_count' => $attributes_dl_array['products_attributes_maxcount'],
                            'download_key' => md5($insert_id . $order_products_id . $_SESSION['customer_id'] . $order->customer['email_address'] . $attributes_dl_array['products_attributes_filename'])
                          );

                          foreach (auto_include(DIR_FS_CATALOG . 'includes/extra/checkout/checkout_process_download/', 'php') as $file) {
                              require($file);
                          }
                          xtc_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
                    }
                }
            }
        }
    }

    foreach (auto_include(DIR_FS_CATALOG . 'includes/extra/checkout/checkout_process_order/', 'php') as $file) {
        require($file);
    }

  // redirect to payment service
    if ($tmp) {
        $payment_modules->payment_action();
    }
}

if (!$tmp) {
  // disable products
    if (count($_SESSION['disable_products']) > 0) {
        foreach ($_SESSION['disable_products'] as $products_id) {
            xtc_db_query("UPDATE " . TABLE_PRODUCTS . "
                       SET products_status = '0'
                     WHERE products_id = '" . $products_id . "'");
        }
    }

  // apply customers gv
    $order_total_modules->apply_credit();

  // load the before_send_order function from the payment modules
    $payment_modules->before_send_order();

  // send order mail
    include('send_order.php');

  // load the after_process function from the payment modules
    $payment_modules->after_process();

  // reset shopping cart
    $_SESSION['cart']->reset(true);

  // unregister session variables used during checkout
    unset($_SESSION['sendto']);
    unset($_SESSION['billto']);
    unset($_SESSION['shipping']);
    unset($_SESSION['payment']);
    unset($_SESSION['comments']);
    unset($_SESSION['last_order']);
    unset($_SESSION['tmp_oID']);
    unset($_SESSION['cc']);

    $last_order = $insert_id;

  //GV Code Start
    if (isset($_SESSION['credit_covers'])) {
        unset($_SESSION['credit_covers']);
    }
    $order_total_modules->clear_posts();

    foreach (auto_include(DIR_FS_CATALOG . 'includes/extra/checkout/checkout_process_end/', 'php') as $file) {
        require($file);
    }

    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));
}
