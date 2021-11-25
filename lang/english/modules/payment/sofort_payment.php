<?php
/* -----------------------------------------------------------------------------------------
   $Id: sofort_payment.php 12940 2020-11-23 12:48:58Z Tomcraft $

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

defined('MODULE_PAYMENT_'.$sofort_code.'_TEXT_TITLE') OR define('MODULE_PAYMENT_'.$sofort_code.'_TEXT_TITLE', 'Online Bank Transfer.');
defined('MODULE_PAYMENT_'.$sofort_code.'_TEXT_DESCRIPTION') OR define('MODULE_PAYMENT_'.$sofort_code.'_TEXT_DESCRIPTION', 'Online Bank Transfer. is the free of charge, T&Uuml;V certified payment method by SOFORT GmbH.');
defined('MODULE_PAYMENT_'.$sofort_code.'_TEXT_INFO') OR define('MODULE_PAYMENT_'.$sofort_code.'_TEXT_INFO', 'You can pay with the T&Uuml;V certified online banking system Online Bank Transfer. of SOFORT GmbH.');

// checkout
defined('MODULE_PAYMENT_'.$sofort_code.'_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGE') OR define('MODULE_PAYMENT_'.$sofort_code.'_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGE', '
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td valign="bottom">
	      <a onclick="javascript:window.open(\'https://images.sofort.com/en/su/landing.php\',\'Customerinformationen\',\'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1020, height=900\');" style="float:left; width:auto;">{{image}}</a>
	    </td>
	  </tr>
	  <tr>
	    <td class="main">{{text}}</td>
	  </tr>
	</table>');
defined('MODULE_PAYMENT_'.$sofort_code.'_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGEALT') OR define('MODULE_PAYMENT_'.$sofort_code.'_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGEALT', 'Online Bank Transfer.');
defined('MODULE_PAYMENT_'.$sofort_code.'_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_TEXT') OR define('MODULE_PAYMENT_'.$sofort_code.'_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_TEXT', '
  <ul>
    <li>Simple and secure.</li>
  </ul>');

// admin
defined('MODULE_PAYMENT_'.$sofort_code.'_STATUS_TITLE') OR define('MODULE_PAYMENT_'.$sofort_code.'_STATUS_TITLE', 'Activate Online Bank Transfer.');
defined('MODULE_PAYMENT_'.$sofort_code.'_STATUS_DESC') OR define('MODULE_PAYMENT_'.$sofort_code.'_STATUS_DESC', 'Activates/deactivates Online Bank Transfer.');
define('MODULE_PAYMENT_'.$sofort_code.'_ALLOWED_TITLE', 'Allowed zones');
define('MODULE_PAYMENT_'.$sofort_code.'_ALLOWED_DESC', 'Please enter the zones <b>separately</b> which should be allowed to use this module. (e. g. AT,DE (leave empty if you want to allow all zones))');
define('MODULE_PAYMENT_'.$sofort_code.'_TMP_ORDER_TITLE', 'Temporary Order');
define('MODULE_PAYMENT_'.$sofort_code.'_TMP_ORDER_DESC', 'Do you want to create a temporary order?');
define('MODULE_PAYMENT_'.$sofort_code.'_LOGGING_TITLE', 'activate Logging');
define('MODULE_PAYMENT_'.$sofort_code.'_LOGGING_DESC', 'Activates/deactivates Logging<br/>Logfiles are saved in /log');
define('MODULE_PAYMENT_'.$sofort_code.'_KEY_TITLE', 'Configurationkey');
define('MODULE_PAYMENT_'.$sofort_code.'_KEY_DESC', 'Configurationkey can be found in Online Bank Transfer.');
define('MODULE_PAYMENT_'.$sofort_code.'_SORT_ORDER_TITLE', 'Display order');
define('MODULE_PAYMENT_'.$sofort_code.'_SORT_ORDER_DESC', 'Order of display. Smallest number is displayed first');
define('MODULE_PAYMENT_'.$sofort_code.'_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_'.$sofort_code.'_ZONE_DESC', 'If a zone is selected, the payment method is valid only for that zone.');
define('MODULE_PAYMENT_'.$sofort_code.'_CURRENCY_TITLE', 'Transaction currency');
define('MODULE_PAYMENT_'.$sofort_code.'_CURRENCY_DESC', 'Receiving currency Online Bank Transfer. setting');
define('MODULE_PAYMENT_'.$sofort_code.'_ORDER_STATUS_ID_TITLE', 'Confirmed Order');
define('MODULE_PAYMENT_'.$sofort_code.'_ORDER_STATUS_ID_DESC', 'Order status after receipt of an order, was sent in advance of a successful payment confirmation');
define('MODULE_PAYMENT_'.$sofort_code.'_TMP_STATUS_ID_TITLE', 'Temporary Order Status');
define('MODULE_PAYMENT_'.$sofort_code.'_TMP_STATUS_ID_DESC', 'Order for not yet completed transactions');
define('MODULE_PAYMENT_'.$sofort_code.'_UNC_STATUS_ID_TITLE', 'To Check Order Status');
define('MODULE_PAYMENT_'.$sofort_code.'_UNC_STATUS_ID_DESC', 'Order Status has been received in an incorrect payment confirmation after receipt of an order');
define('MODULE_PAYMENT_'.$sofort_code.'_REC_STATUS_ID_TITLE', 'Order Status after payment');
define('MODULE_PAYMENT_'.$sofort_code.'_REC_STATUS_ID_DESC', 'Order Status after the money has been credited to your account.');
define('MODULE_PAYMENT_'.$sofort_code.'_REF_STATUS_ID_TITLE', 'Order Status after chargeback');
define('MODULE_PAYMENT_'.$sofort_code.'_REF_STATUS_ID_DESC', 'Order Status after a chargeback has occurred.');
define('MODULE_PAYMENT_'.$sofort_code.'_LOSS_STATUS_ID_TITLE', 'Order Status if no money has arrived');
define('MODULE_PAYMENT_'.$sofort_code.'_LOSS_STATUS_ID_DESC', 'Order Status if no money is credited to your account.');
define('MODULE_PAYMENT_'.$sofort_code.'_REASON_1_TITLE', 'Usage Line 1');
define('MODULE_PAYMENT_'.$sofort_code.'_REASON_1_DESC', 'If no temporary order is created, the order number is not available. Therefore, it should be then placed on -TRANSACTION-');
define('MODULE_PAYMENT_'.$sofort_code.'_REASON_2_TITLE', 'Usage Line 2');
define('MODULE_PAYMENT_'.$sofort_code.'_REASON_2_DESC', 'In use (maximum 27 characters) to be replaced following placeholders:<br /> {{order_id}}<br />{{order_date}}<br />{{customer_id}}<br />{{customer_name}}<br />{{customer_company}}<br />{{customer_email}}');
define('MODULE_PAYMENT_'.$sofort_code.'_IMAGE_TITLE', 'Payment Grafic / Text');
define('MODULE_PAYMENT_'.$sofort_code.'_IMAGE_DESC', 'Grafic / Text on Payment Checkout');
define('MODULE_PAYMENT_'.$sofort_code.'_KS_STATUS_TITLE', 'Customer protection activated');
define('MODULE_PAYMENT_'.$sofort_code.'_KS_STATUS_DESC', 'Activate customer protection for Online Bank Transfer.');
define('MODULE_PAYMENT_'.$sofort_code.'_USER_ID_TITLE', 'Customer Number');
define('MODULE_PAYMENT_'.$sofort_code.'_USER_ID_DESC', 'Customer Number at Online Bank Transfer.');
define('MODULE_PAYMENT_'.$sofort_code.'_PROJECT_ID_TITLE', 'Project Nummer');
define('MODULE_PAYMENT_'.$sofort_code.'_PROJECT_ID_DESC', 'The responsible project number in the immediate navigation use Online Bank Transfer. to the payment belongs');
define('MODULE_PAYMENT_'.$sofort_code.'_PROJECT_PASS_TITLE', 'Project Password');
define('MODULE_PAYMENT_'.$sofort_code.'_PROJECT_PASS_DESC', 'Find this under Settings at Online Bank Transfer.');
define('MODULE_PAYMENT_'.$sofort_code.'_NOTIFY_PASS_TITLE', 'Notification Password');
define('MODULE_PAYMENT_'.$sofort_code.'_NOTIFY_PASS_DESC', 'Find this under Settings at Online Bank Transfer.');
define('MODULE_PAYMENT_'.$sofort_code.'_HASH_ALGORITHM_TITLE', 'Hash-Algorithmus:');
define('MODULE_PAYMENT_'.$sofort_code.'_HASH_ALGORITHM_DESC', 'Find this under Settings at Online Bank Transfer.');
define('MODULE_PAYMENT_'.$sofort_code.'_DESCRIPTION_INSTALL', '<br/><br/>Do you want to install proper order status?<br/>The currently set statuses are overwritten.');

// status
defined('TEXT_NO_STATUSUPDATE') OR define('TEXT_NO_STATUSUPDATE', 'no status update');

// error
define('MODULE_PAYMENT_'.$sofort_code.'_TEXT_ERROR_HEADING', 'The following error was reported during the process:');
define('MODULE_PAYMENT_'.$sofort_code.'_TEXT_ERROR_MESSAGE', 'Payment is unfortunately not possible or has been cancelled by the customer. Please select another payment method.');

// callback
defined('TEXT_SOFORT_NOT_CREDITED_YET') OR define('TEXT_SOFORT_NOT_CREDITED_YET', 'Successfully completed Online Bank Transfer.');
defined('TEXT_SOFORT_NOT_CREDITED') OR define('TEXT_SOFORT_NOT_CREDITED', 'Not received money on account');
defined('TEXT_SOFORT_LOSS') OR define('TEXT_SOFORT_LOSS', 'verify the order');
defined('TEXT_SOFORT_RECEIVED') OR define('TEXT_SOFORT_RECEIVED', 'Received money on account');
defined('TEXT_SOFORT_CREDITED') OR define('TEXT_SOFORT_CREDITED', TEXT_SOFORT_RECEIVED);
defined('TEXT_SOFORT_REFUNDED') OR define('TEXT_SOFORT_REFUNDED', 'Money was refunded in full');
defined('TEXT_SOFORT_CANCELED') OR define('TEXT_SOFORT_CANCELED', 'Online Bank Transfer. canceled');
defined('TEXT_SOFORT_WAIT_FOR_MONEY') OR define('TEXT_SOFORT_WAIT_FOR_MONEY', 'Waiting for Payment');
defined('TEXT_SOFORT_CONFIRMATION_PERIOD_EXPIRED') OR define('TEXT_SOFORT_CONFIRMATION_PERIOD_EXPIRED', 'Online Bank Transfer. Timeout');
defined('TEXT_SOFORT_REJECTED') OR define('TEXT_SOFORT_REJECTED', 'Online Bank Transfer. rejected');
defined('TEXT_SOFORT_SOFORT_BANK_ACCOUNT_NEEDED') OR define('TEXT_SOFORT_SOFORT_BANK_ACCOUNT_NEEDED', TEXT_SOFORT_NOT_CREDITED_YET);

define('MODULE_PAYMENT_'.$sofort_code.'_ERROR_TRANSACTION', "Error during HTTP notification\nPlease check transaction and notification\nTransaction-ID: %s");
define('MODULE_PAYMENT_'.$sofort_code.'_ERROR_PAYMENT', "Money NOT received yet\nTransaction-ID: %s");
define('MODULE_PAYMENT_'.$sofort_code.'_ERROR_UNEXPECTED_STATUS', "Error (SU204): Unexpected Status\nTransaction-ID: %s");
define('MODULE_PAYMENT_'.$sofort_code.'_SUCCESS_TRANSACTION', "Payment successful\nTransaction-ID: %s");
define('MODULE_PAYMENT_'.$sofort_code.'_SUCCESS_PAYMENT', "Money received\nTransaction-ID: %s");

// order status
$SOFORT_INST_ORDER_STATUS_TMP_NAME = 'Temp';
$SOFORT_INST_ORDER_STATUS_UNC_NAME = 'Waiting';
$SOFORT_INST_ORDER_STATUS_LOSS_NAME = 'Waiting';
$SOFORT_INST_ORDER_STATUS_REC_NAME = 'Received Payment';
$SOFORT_INST_ORDER_STATUS_REF_NAME = 'Refunded';
$SOFORT_INST_ORDER_STATUS_ORDER_NAME = 'Payment';
?>