<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypalplus.php 11836 2019-05-20 17:43:36Z Tomcraft $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


$lang_array = array(
  'MODULE_PAYMENT_PAYPALPLUS_TEXT_TITLE' => 'PayPal Plus',
  'MODULE_PAYMENT_PAYPALPLUS_TEXT_ADMIN_TITLE' => 'PayPal Plus mit PayPal Express',
  'MODULE_PAYMENT_PAYPALPLUS_TEXT_INFO' => 'Bitte w&auml;hlen Sie eine aus den hier aufgef&uuml;hrten Zahlarten durch Anklicken aus.',
  'MODULE_PAYMENT_PAYPALPLUS_TEXT_DESCRIPTION' => 'PayPal Plus - die vier beliebtesten Bezahlmethoden deutscher K&auml;ufer: PayPal, Lastschrift, Kreditkarte und Rechnung.<br/>Mehr Infos zu PayPal Plus finden Sie <a target="_blank" href="https://www.paypal.com/de/webapps/mpp/paypal-plus">hier</a>.',
  'MODULE_PAYMENT_PAYPALPLUS_ALLOWED_TITLE' => 'Erlaubte Zonen',
  'MODULE_PAYMENT_PAYPALPLUS_ALLOWED_DESC' => 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))',
  'MODULE_PAYMENT_PAYPALPLUS_STATUS_TITLE' => 'PayPal Plus aktivieren',
  'MODULE_PAYMENT_PAYPALPLUS_STATUS_DESC' => 'M&ouml;chten Sie Zahlungen per PayPal, Kreditkarte, Lastschrift und Kauf auf Rechnung akzeptieren?',
  'MODULE_PAYMENT_PAYPALPLUS_SORT_ORDER_TITLE' => 'Anzeigereihenfolge',
  'MODULE_PAYMENT_PAYPALPLUS_SORT_ORDER_DESC' => 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt',
  'MODULE_PAYMENT_PAYPALPLUS_ZONE_TITLE' => 'Zahlungszone',
  'MODULE_PAYMENT_PAYPALPLUS_ZONE_DESC' => 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.',
  'MODULE_PAYMENT_PAYPALPLUS_LP' => '<br /><br /><a target="_blank" href="http://www.paypal.com/de/webapps/mpp/referral/paypal-business-account2?partner_id=EHALBVD4M2RQS"><strong>Jetzt PayPal Konto hier erstellen.</strong></a>',

  'MODULE_PAYMENT_PAYPALPLUS_TEXT_EXTENDED_DESCRIPTION' => '<strong><font color="red">ACHTUNG:</font></strong> Bitte nehmen Sie noch die Einstellungen unter "Partner Module" -> "PayPal" -> <a href="'.xtc_href_link('paypal_config.php').'"><strong>"PayPal Konfiguration"</strong></a> vor!',

  'MODULE_PAYMENT_PAYPALPLUS_TEXT_ERROR_HEADING' => 'Hinweis',
  'MODULE_PAYMENT_PAYPALPLUS_TEXT_ERROR_MESSAGE' => 'PayPal Zahlung wurde abgebrochen',

  'MODULE_PAYMENT_PAYPALPLUS_INVOICE' => 'Kauf auf Rechnung',
);


foreach ($lang_array as $key => $val) {
  defined($key) or define($key, $val);
}
?>