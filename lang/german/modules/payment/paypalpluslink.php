<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypalpluslink.php 12400 2019-11-08 13:28:49Z Tomcraft $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


$lang_array = array(
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_TITLE' => 'PayPal Plus Link',
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_INFO' => '<img src="https://www.paypal.com/de_DE/DE/i/logo/lockbox_150x47.gif" />',
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_DESCRIPTION' => 'PayPal Plus als Zahlungslink der den Kunden erst nach Bestellabschluss zur Verf&uuml;gung steht. Entscheiden Sie selber, wo der Kunde die Aufforderung zur Zahlung erh&auml;lt.<br/>PayPal Plus - die vier beliebtesten Bezahlmethoden deutscher K&auml;ufer: PayPal, Lastschrift, Kreditkarte und Rechnung.<br/>Mehr Infos zu PayPal Plus finden Sie <a target="_blank" href="https://www.paypal.com/de/webapps/mpp/paypal-plus">hier</a>.',
  'MODULE_PAYMENT_PAYPALPLUSLINK_ALLOWED_TITLE' => 'Erlaubte Zonen',
  'MODULE_PAYMENT_PAYPALPLUSLINK_ALLOWED_DESC' => 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))',
  'MODULE_PAYMENT_PAYPALPLUSLINK_STATUS_TITLE' => 'PayPal Plus Link aktivieren',
  'MODULE_PAYMENT_PAYPALPLUSLINK_STATUS_DESC' => 'M&ouml;chten Sie Zahlungen per PayPal Plus Link akzeptieren?',
  'MODULE_PAYMENT_PAYPALPLUSLINK_SORT_ORDER_TITLE' => 'Anzeigereihenfolge',
  'MODULE_PAYMENT_PAYPALPLUSLINK_SORT_ORDER_DESC' => 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt',
  'MODULE_PAYMENT_PAYPALPLUSLINK_ZONE_TITLE' => 'Zahlungszone',
  'MODULE_PAYMENT_PAYPALPLUSLINK_ZONE_DESC' => 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.',
  'MODULE_PAYMENT_PAYPALPLUSLINK_LP' => '<br /><br /><a target="_blank" href="http://www.paypal.com/de/webapps/mpp/referral/paypal-business-account2?partner_id=EHALBVD4M2RQS"><strong>Jetzt PayPal Konto hier erstellen.</strong></a>',

  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_EXTENDED_DESCRIPTION' => '<strong><font color="red">ACHTUNG:</font></strong> Bitte nehmen Sie noch die Einstellungen unter "Partner Module" -> "PayPal" -> <a href="'.xtc_href_link('paypal_config.php').'"><strong>"PayPal Konfiguration"</strong></a> vor!',

  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_ERROR_HEADING' => 'Hinweis',
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_ERROR_MESSAGE' => 'PayPal Zahlung wurde abgebrochen',
  
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_SUCCESS' => 'Jetzt mit PayPal bezahlen. Klicken Sie bitte auf den folgenden Link:<br/> %s',
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_COMPLETED' => 'Vielen Dank f&uuml;r die Bezahlung mit PayPal.',
);


foreach ($lang_array as $key => $val) {
  defined($key) or define($key, $val);
}
?>