<?php
/* -----------------------------------------------------------------------------------------
   $Id: shipping_estimate.php 13456 2021-03-08 09:18:20Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003 nextcommerce (write_customers_status.php,v 1.8 2003/08/1); www.nextcommerce.org
   (c) 2006 xtCommerce (write_customers_status.php)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------

   based on Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
// 2013-12-31
// http://rpa-com.de -web28- add support for //MAXIMALE VERSANDKOSTEN
// http://neunzehn83.de/blog/2011/03/09/xtc-land-dropdown-im-warenkorb/
// http://www.xtc-modified.org/forum/topic.php?id=9883

if (!defined('SHOW_ALWAYS_LANG_DROPDOWN')) {
  define('SHOW_ALWAYS_LANG_DROPDOWN', true); // true: Zeigt immer das L�nderauswahlfeld an - false: Zeigt L�nderauswahlfeld nur bei nicht eingeloggten Kunden
}

// unset SESSION payment + shipping
unset($_SESSION['shipping']);
unset($_SESSION['payment']);

require_once (DIR_WS_CLASSES.'order.php');
require_once (DIR_WS_CLASSES.'order_total.php');
require_once (DIR_FS_INC.'xtc_get_country_list.inc.php');

$order = new order();
$total_weight = $_SESSION['cart']->show_weight();
$total_count = $_SESSION['cart']->count_contents();

$selected = isset($_SESSION['customer_country_id']) ? $_SESSION['customer_country_id'] : STORE_COUNTRY;
if (!isset($_SESSION['customer_id']) || SHOW_ALWAYS_LANG_DROPDOWN) {
  if (isset($_SESSION['country'])) {
    $selected = $_SESSION['country'];
  }
  $module_smarty->assign('SELECT_COUNTRY', _SHIPPING_TO. xtc_get_country_list(array ('name' => 'country'), (int)$selected, 'onchange="this.form.submit()"'));
  $module_smarty->assign('SELECT_COUNTRY_PLAIN', xtc_get_country_list(array ('name' => 'country'), (int)$selected, 'onchange="this.form.submit()"'));

  $smarty->assign('SELECT_COUNTRY', _SHIPPING_TO. xtc_get_country_list(array ('name' => 'country'), (int)$selected, 'onchange="this.form.submit()"'));
  $smarty->assign('SELECT_COUNTRY_PLAIN', xtc_get_country_list(array ('name' => 'country'), (int)$selected, 'onchange="this.form.submit()"'));
}

if (!isset($order->delivery['country']['iso_code_2']) || $order->delivery['country']['iso_code_2'] == ''  || SHOW_ALWAYS_LANG_DROPDOWN) {
  $delivery_zone_query = xtc_db_query("SELECT countries_id,
                                              countries_iso_code_2,
                                              countries_name
                                         FROM ".TABLE_COUNTRIES."
                                        WHERE countries_id = '". (int)$selected."'
                                     ");
  $delivery_zone = xtc_db_fetch_array($delivery_zone_query);

  $order->delivery['country']['iso_code_2'] = $delivery_zone['countries_iso_code_2'];
  $order->delivery['country']['title'] = $delivery_zone['countries_name'];
  $order->delivery['country']['id'] = $delivery_zone['countries_id'];
  $order->delivery['country_id'] = $delivery_zone['countries_id'];
  $order->delivery['zone_id'] = 0;
}

$order_total_modules = new order_total();
$order_total_modules->collect_posts();
$order_total_modules->pre_confirmation_check();
if (isset($_SESSION['credit_covers'])) {
  unset($_SESSION['credit_covers']);
}

$_SESSION['delivery_zone'] = $order->delivery['country']['iso_code_2'];

if (MODULE_ORDER_TOTAL_INSTALLED) {
  $order_total_array = $order_total_modules->process();
  if (count($order_total_array)) {
    foreach($order_total_array as $key => $entry) {
       if ($entry['code'] == 'ot_subtotal') {
         $ot_subtotal_value = $entry['value'];
         $ot_subtotal_key = $key;
       }
       if ($entry['code'] == 'ot_total') {
         $ot_total_value = $entry['value'];
         $ot_total_key = $key;
       }
       if ($entry['code'] == 'ot_subtotal_no_tax') {
         $ot_subtotal_no_tax_value = $entry['value'];
         $ot_subtotal_no_tax_key = $key;
       }
    }
    //ot_subtotal_no_tax nur anzeigen wenn notwendig
    if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1 
        || (isset($ot_subtotal_no_tax_value) && isset($ot_total_value) && round($ot_subtotal_no_tax_value, 2) == round($ot_total_value, 2))
        )
    {
      if (isset($ot_subtotal_no_tax_key) && isset($order_total_array[$ot_subtotal_no_tax_key])) {
        unset($order_total_array[$ot_subtotal_no_tax_key]);
      }
    }
    //ot_total nur anzeigen wenn unterschiedlich
    if (round($ot_subtotal_value, 2) == round($ot_total_value, 2) && isset($order_total_array[$ot_total_key]) ) {
      unset($order_total_array[$ot_total_key]);
    } else {
      $order->info['total'] = $ot_subtotal_value;
    }
    //Array Indexe neu erstellen
    $order_total_array = array_merge($order_total_array);
  }
  $total_block = $order_total_modules->output();

  $module_smarty->assign('TOTAL_BLOCK_ARRAY', $order_total_array);
  $module_smarty->assign('TOTAL_BLOCK', $total_block);

  $smarty->assign('TOTAL_BLOCK_ARRAY', $order_total_array);
  $smarty->assign('TOTAL_BLOCK', $total_block);
}

if (!isset($order->info['total'])) {
  $order->info['total'] = $_SESSION['cart']->show_total();
}
$total = $ot_total_value;

//suppot downloads and gifts
if ($order->content_type == 'virtual' || ($order->content_type == 'virtual_weight') || ($_SESSION['cart']->count_contents_virtual() == 0)) {
  $shipping_content = array(array('NAME' => _SHIPPING_FREE));
  if (DOWNLOAD_SHOW_LANG_DROPDOWN == 'false') {
    $module_smarty->clear_assign('SELECT_COUNTRY');
    $smarty->clear_assign('SELECT_COUNTRY');
  }
} elseif (defined('MODULE_ORDER_TOTAL_SHIPPING_STATUS')
          && MODULE_ORDER_TOTAL_SHIPPING_STATUS == 'true'
          )
{
  require_once (DIR_WS_CLASSES.'shipping.php');
  $shipping = new shipping;

  $free_shipping = false;
  include_once (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/order_total/ot_shipping.php');
  $ot_shipping = new ot_shipping;
  $ot_shipping->process();

  // load all enabled shipping modules
  $quotes = $shipping->quote();

  if (SHOW_SELFPICKUP_FREE == 'true') {
    if ($free_shipping == true) {
      $free_shipping = false;
    
      $quotes_array = $ot_shipping->quote();
      for ($i = 0, $n = sizeof($quotes); $i < $n; $i ++) {
        if (isset($GLOBALS[$quotes[$i]['id']])
            && is_object($GLOBALS[$quotes[$i]['id']])
            && method_exists($GLOBALS[$quotes[$i]['id']], 'display_free')
            )
        {
          if ($GLOBALS[$quotes[$i]['id']]->display_free() === true) {
            $quotes_array = array_merge($quotes_array, $shipping->quote($quotes[$i]['id'], $quotes[$i]['methods'][0]['id']));
          }
        }
      }
      $quotes = $quotes_array;
    }
  }
  
  $shipping_content = array ();
  if ($free_shipping == true) {
    $shipping_content[] = array(
      'NAME' => FREE_SHIPPING_TITLE,
      'VALUE' => $xtPrice->xtcFormat(0, true, 0, true)
    );
  } else {
    if (defined('MODULE_ORDER_TOTAL_SHIPPING_STATUS')
        && MODULE_ORDER_TOTAL_SHIPPING_STATUS == 'true'
        && MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true'
        && $pass === true
        )
    {
      $module_smarty->assign('FREE_SHIPPING_INFO', sprintf(FREE_SHIPPING_DESCRIPTION, $xtPrice->xtcFormat($free_shipping_value_over, true, 0, true)));
      $smarty->assign('FREE_SHIPPING_INFO', sprintf(FREE_SHIPPING_DESCRIPTION, $xtPrice->xtcFormat($free_shipping_value_over, true, 0, true)));
    }
  
    $i = 0;
    foreach ($quotes as $quote) {
      if (!isset($quote['error']) || (isset($quote['error']) && trim($quote['error']) == '')) {
        if (($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] != 1) || !isset($quote['tax'])) { 
          $quote['tax'] = 0;
        }
        $value = '0';
        if (isset($quote['methods'][0]['cost']) && $quote['methods'][0]['cost'] > 0) {
          if (isset($quote['tax']) && $quote['tax'] > 0) {
            $value = $xtPrice->xtcAddTax($quote['methods'][0]['cost'], $quote['tax']);
          } else {
            $value = $xtPrice->xtcCalculateCurr($quote['methods'][0]['cost']);
          }
        }
        $total += $value;
        $title = $quote['module'];
        if (!defined('SHOW_SHIPPING_MODULE_TITLE') || SHOW_SHIPPING_MODULE_TITLE == 'shipping_default') {
          $title .= ' - ' . $quote['methods'][0]['title'];
        }
        $shipping_content[$i] = array(
          'NAME' => $title,
          'VALUE' => $xtPrice->xtcFormat($value, true),
          'QUOTE' => $quote
        );
      } else {
        $shipping_content[$i] = array(
          'NAME' => $quote['module'] . ' - ' . $quote['error'],
          'VALUE' => '',
          'QUOTE' => $quote
        );
      }
      $i++;
    }
  }

  if (sizeof($quotes) < 1) {
    $shipping_content[] = array('NAME' => _MODULE_INVALID_SHIPPING_ZONE);
  }
  if (sizeof($shipping_content) < 1) {
    $shipping_content[] = array('NAME' => _MODULE_UNDEFINED_SHIPPING_RATE);
  }
}

#unset($_SESSION['billto']);
unset($_SESSION['delivery_zone']);
$module_smarty->assign('shipping_content', $shipping_content);
$module_smarty->assign('COUNTRY', $order->delivery['country']['title']);
$module_smarty->assign('TOTAL_WEIGHT', $_SESSION['cart']->weight + SHIPPING_BOX_WEIGHT);

$smarty->assign('shipping_content', $shipping_content);
$smarty->assign('COUNTRY', $order->delivery['country']['title']);
$smarty->assign('TOTAL_WEIGHT', $_SESSION['cart']->weight + SHIPPING_BOX_WEIGHT);

if ($order->content_type == 'virtual' 
    || $order->content_type == 'virtual_weight'
    || $_SESSION['cart']->count_contents_virtual() == 0
    ) 
{
  $module_smarty->clear_assign('shipping_content');
  $module_smarty->clear_assign('COUNTRY');

  $smarty->clear_assign('shipping_content');
  $smarty->clear_assign('COUNTRY');
}

if (count($shipping_content) <= 1) {
  $module_smarty->assign('total', $xtPrice->xtcFormat($total, true));
  $smarty->assign('total', $xtPrice->xtcFormat($total, true));
}
?>