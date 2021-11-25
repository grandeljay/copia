<?php
/* -----------------------------------------------------------------------------------------
   $Id: sofort_sofortueberweisung_gateway.php 11753 2019-04-12 12:53:47Z GTB $

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

// include autoloader
require_once(DIR_FS_EXTERNAL.'sofort/autoload.php');

// include needed classes
require_once(DIR_FS_EXTERNAL.'sofort/classes/SofortLibPayment.php');

class sofort_sofortueberweisung_gateway extends SofortLibPayment {

	var $code, $title, $description, $enabled;

  function __construct() {
    $this->SofortPayment();

    // logger
    $this->logger = new Sofort\SofortLib\FileLogger();
    $this->logger->setLogfilePath(DIR_FS_LOG.'sofort_'.date('Y-m-d').'.log');
	}


  function _payment_action () {
    global $order, $xtPrice, $insert_id;

    if (!isset($insert_id) || $insert_id == '') {
      $insert_id = $_SESSION['tmp_oID'];
    }

    $this->_payment_data();

    // prepare call
    $this->Sofortueberweisung = new Sofort\SofortLib\Sofortueberweisung(constant('MODULE_PAYMENT_'.strtoupper($this->code).'_KEY'));

    // set Logging
    $this->Sofortueberweisung->setLogger($this->logger);
    if ($this->logging === true) {
      $this->Sofortueberweisung->setLogEnabled();
    }

    /*
     * disabled variables for automation
     *
     $this->Sofortueberweisung->setSenderCountryCode(strtoupper($order->billing['country']['iso_code_2']));
     $this->Sofortueberweisung->setLanguageCode(strtoupper($_SESSION['language_code']));
    */
    $this->Sofortueberweisung->setAmount($this->data['amount']);
    $this->Sofortueberweisung->setCurrencyCode($this->data['currency']);
    $this->Sofortueberweisung->setReason($this->shortenReason($this->data['reason_1']), $this->shortenReason($this->data['reason_2']));
    $this->Sofortueberweisung->setSuccessUrl($this->data['success_url'], true);
    $this->Sofortueberweisung->setUserVariable(array('0' => $this->data['success_url']));
    $this->Sofortueberweisung->setAbortUrl($this->data['abort_url']);
    $this->Sofortueberweisung->setTimeoutUrl($this->data['timeout_url']);
    $this->Sofortueberweisung->setNotificationUrl($this->data['callback_url']);
    $this->Sofortueberweisung->setCustomerprotection($this->ks_status);
    $this->Sofortueberweisung->setVersion($this->version);
    $this->Sofortueberweisung->setSuccessLinkRedirect(true);
    $this->Sofortueberweisung->setTimeout(SESSION_LIFE_CUSTOMERS-(60*5));

    // send request
    $this->Sofortueberweisung->sendRequest();

    // write some variables to session
    $_SESSION['sofort'][$this->code]['total'] = $this->data['amount'];
    $_SESSION['sofort'][$this->code]['cartID'] = $_SESSION['cart']->cartID;
    $_SESSION['sofort'][$this->code]['oID'] = $insert_id;
    $_SESSION['sofort'][$this->code]['tID'] = $this->Sofortueberweisung->getTransactionId();

    if ($this->tmpOrders === true) {
      // update status
      $order_status_id = constant('MODULE_PAYMENT_'.strtoupper($this->code).'_TMP_STATUS_ID');
      if ($order_status_id < 0) {
        $order_status_id = $this->_get_orders_status($insert_id);
      }
      $comments = 'TransactionID: ' . $_SESSION['sofort'][$this->code]['tID'];
      $this->update_sofort_status($insert_id, $order_status_id, $comments, true);
    }

    if ($this->Sofortueberweisung->isError()) {
      // trigger error
      $this->Sofortueberweisung->setError($this->Sofortueberweisung->isError());

      // redirect
      xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code, 'SSL'));
    } else {

      // redirected to $paymentUrl
      xtc_redirect($this->Sofortueberweisung->getPaymentUrl());
    }
  }


	function install () {
	  $this->install_default();
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_".strtoupper($this->code)."_KEY', '',  '6', '4', now())");
	}


	function remove () {
		xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key IN ('" . implode("', '", $this->keys()) . "')");
	  xtc_db_query("DROP TABLE `".$this->code."`");
	}


	function keys () {
	  $keys = $this->keys_default();
	  $keys[1] = 'MODULE_PAYMENT_'.strtoupper($this->code).'_KEY';

    ksort($keys);
    $keys = array_values($keys);

		return $keys;
	}

}
?>