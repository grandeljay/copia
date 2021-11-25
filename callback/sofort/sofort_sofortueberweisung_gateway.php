<?php
/* -----------------------------------------------------------------------------------------
   $Id: sofort_sofortueberweisung_gateway.php 11380 2018-07-30 14:21:06Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
 	 based on:
	  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
	  (c) 2002-2003 osCommerce - www.oscommerce.com
	  (c) 2001-2003 TheMedia, Dipl.-Ing Thomas Pl�nkers - http://www.themedia.at & http://www.oscommerce.at
	  (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com
    (c) 2010 Payment Network AG - http://www.payment-network.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

chdir('../../');
require_once('includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'get_external_content.inc.php');

// include needed classes
require_once(DIR_WS_CLASSES.'order.php');

// include autoloader
require_once(DIR_FS_EXTERNAL.'sofort/autoload.php');

// logger
$logger = new Sofort\SofortLib\FileLogger();
$logger->setLogfilePath(DIR_FS_LOG.'sofort_'.date('Y-m-d').'.log');

// get transaction
$SofortLibNotification = new Sofort\SofortLib\Notification();
$tID = $SofortLibNotification->getNotification(get_external_content('php://input', 3, false));

if (xtc_not_null($tID)) {

  $orders_query = xtc_db_query("SELECT order_id
                                  FROM sofort_sofortueberweisung_gateway
                                 WHERE transaction_id = '".xtc_db_input($tID)."'");
  if (xtc_db_num_rows($orders_query) == 1) {

    // transaction data
    $SofortLibTransactionData = new Sofort\SofortLib\TransactionData(MODULE_PAYMENT_SOFORT_SOFORTUEBERWEISUNG_GATEWAY_KEY);

    // set Logging
    $SofortLibTransactionData->setLogger($logger);
    if (MODULE_PAYMENT_SOFORT_SOFORTUEBERWEISUNG_GATEWAY_LOGGING == 'True') {
      $SofortLibTransactionData->setLogEnabled();
    }

    // get transaction
    $SofortLibTransactionData->addTransaction($tID);
    $SofortLibTransactionData->sendRequest();

    if ($SofortLibTransactionData->isError() === false) {

      $tID = $SofortLibTransactionData->getTransaction();
      $status = $SofortLibTransactionData->getStatus();
      $reason = $SofortLibTransactionData->getStatusReason(0,0);

      // order id
      $orders = xtc_db_fetch_array($orders_query);
      $order = new order($orders['order_id']);

      include_once (DIR_FS_CATALOG . 'lang/'.$order->info['language'].'/modules/payment/'.$order->info['payment_method'].'.php');

      switch ($status) {
        case 'pending':
          $order_status_id = constant('MODULE_PAYMENT_'.strtoupper($order->info['payment_method']).'_ORDER_STATUS_ID');
          $comments = sprintf(constant('MODULE_PAYMENT_'.strtoupper($order->info['payment_method']).'_SUCCESS_TRANSACTION'), $tID);
          break;
        case 'received':
          $order_status_id = constant('MODULE_PAYMENT_'.strtoupper($order->info['payment_method']).'_REC_STATUS_ID');
          $comments = sprintf(constant('MODULE_PAYMENT_'.strtoupper($order->info['payment_method']).'_SUCCESS_PAYMENT'), $tID);
          break;
        case 'refunded':
          $order_status_id = constant('MODULE_PAYMENT_'.strtoupper($order->info['payment_method']).'_REF_STATUS_ID');
          $comments = sprintf(constant('MODULE_PAYMENT_'.strtoupper($order->info['payment_method']).'_SUCCESS_REFUNDED'), $tID);
          break;
        case 'loss':
          $order_status_id = constant('MODULE_PAYMENT_'.strtoupper($order->info['payment_method']).'_LOSS_STATUS_ID');
          $comments = sprintf(constant('MODULE_PAYMENT_'.strtoupper($order->info['payment_method']).'_ERROR_PAYMENT'), $tID);
          break;
        case 'untraceable':
          $order_status_id = constant('MODULE_PAYMENT_'.strtoupper($order->info['payment_method']).'_UNC_STATUS_ID');
          $comments = sprintf(constant('MODULE_PAYMENT_'.strtoupper($order->info['payment_method']).'_ERROR_UNEXPECTED_STATUS'), $tID);
          break;
      }

      if ($order_status_id < 0) {
        $order_status_id = $order->info['orders_status_id'];
      }
      if ($reason != '') {
        $comments .= "\n".'Reason: ' . constant('TEXT_SOFORT_'.strtoupper($reason));
      }

      xtc_db_query("UPDATE ".TABLE_ORDERS." 
                       SET orders_status = '".(int) $order_status_id."' 
                     WHERE orders_id = '".(int) $orders['order_id']."'");
      
      $sql_data_array = array(
        'orders_id' => (int) $orders['order_id'],
        'orders_status_id' => (int) $order_status_id,
        'date_added' => 'now()',
        'customer_notified' => '0',
        'comments' => decode_htmlentities($comments),
        'comments_sent' => '0'
      );

      xtc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
    }

  } else {

    // order is missing
    header("HTTP/1.0 404 Not Found");
    header("Status: 404 Not Found");
    
  }
} else {
  die('Direct access to this location is not allowed.');
}