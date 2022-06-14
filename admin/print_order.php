<?php
/* -----------------------------------------------------------------------------------------
   $Id: print_order.php 10061 2016-07-12 10:21:49Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003 nextcommerce (print_order.php,v 1.1 2003/08/19); www.nextcommerce.org
   (c) 2006 XT-Commerce (print_order.php 1166 2005-08-21)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  require('includes/application_top.php');

  $smarty = new Smarty;

  //get store name and store name_address
  $smarty->assign('store_name', STORE_NAME);
  $smarty->assign('store_name_address', STORE_NAME_ADDRESS); 

  // get order data
  include(DIR_WS_CLASSES . 'order.php');
  $order = new order((int)$_GET['oID']);

  $smarty->assign('address_label_customer',xtc_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
  $smarty->assign('address_label_shipping',xtc_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
  $smarty->assign('address_label_payment',xtc_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
  $smarty->assign('csID',$order->customer['csID']);
  $smarty->assign('vatID',$order->customer['vat_id']);

  // get products data
  include_once(DIR_FS_CATALOG.DIR_WS_CLASSES .'xtcPrice.php');
  $xtPrice = new xtcPrice($order->info['currency'], $order->info['status']);

  $order_total = $order->getTotalData($order->info['order_id']);
  $order_data = $order->getOrderData($order->info['order_id']);

  $smarty->assign('order_data', $order_data);
  $smarty->assign('order_total', $order_total['data']);

  // assign language to template for caching
  $languages_query = xtc_db_query("select code, language_charset from " . TABLE_LANGUAGES . " WHERE directory ='". $order->info['language'] ."'");
  $langcode = xtc_db_fetch_array($languages_query);
  $smarty->assign('langcode', $langcode['code']);
  $smarty->assign('charset', $langcode['language_charset']);
  $smarty->assign('language', $order->info['language']);

  $smarty->assign('logo_path',HTTP_SERVER . DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
  $smarty->assign('tpl_path',HTTP_SERVER . DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/');

  $smarty->assign('oID',$order->info['order_id']);
  if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
    include(DIR_FS_CATALOG.'lang/'.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
    $payment_method = constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));

    // mod: BILLPAY payment module
    if(stripos($order->info['payment_method'], 'billpay') !== false) {
      require_once(DIR_FS_EXTERNAL . 'billpay/utils/billpay_display_bankdata.php');
      $payment_method .= display_billpay_bankdata();
    }

    if(strpos($order->info['payment_method'], 'paypalplus') !== false) {
      require_once(DIR_FS_EXTERNAL.'paypal/classes/PayPalInfo.php');
      $paypal = new PayPalInfo($order->info['payment_method']);      
      $smarty->assign('PAYMENT_INFO', $paypal->get_payment_instructions($order->info['order_id']));
    }
    $smarty->assign('PAYMENT_METHOD', $payment_method);
  }
  $smarty->assign('COMMENTS', nl2br($order->info['comments']));
  $smarty->assign('DATE',xtc_date_long($order->info['date_purchased']));
  $smarty->assign('INVOICE_NUMBER', isset($order->info['ibn_billnr']) && $order->info['ibn_billnr'] != '' ? $order->info['ibn_billnr'] :  $order->info['order_id']);
  $smarty->assign('INVOICE_DATE', isset($order->info['ibn_billdate']) && $order->info['ibn_billdate'] != '0000-00-00' ? xtc_date_short($order->info['ibn_billdate']) :  xtc_date_short($order->info['date_purchased']));
  $smarty->assign('DELIVERY_DATE', isset($order->info['ibn_billdate']) && $order->info['ibn_billdate'] != '0000-00-00' ? xtc_date_short($order->info['ibn_billdate']) :  xtc_date_short($order->info['date_purchased']));

  require_once(DIR_FS_CATALOG.'includes/classes/main.php');
  $main = new main();

  $invoice_data = $main->getContentData(INVOICE_INFOS);
  $smarty->assign('ADDRESS_SMALL', $invoice_data['content_heading']);
  $smarty->assign('ADDRESS_LARGE', $invoice_data['content_text']);

  // dont allow cache
  $smarty->caching = false;
  $smarty->template_dir=DIR_FS_CATALOG.'templates';
  $smarty->compile_dir=DIR_FS_CATALOG.'templates_c';
  $smarty->config_dir=DIR_FS_CATALOG.'lang';
  $smarty->display(CURRENT_TEMPLATE . '/admin/print_order.html');
?>