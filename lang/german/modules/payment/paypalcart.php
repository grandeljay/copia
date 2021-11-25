<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypalcart.php 11030 2017-12-08 07:50:06Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


$lang_array = array(
  'MODULE_PAYMENT_PAYPALCART_TEXT_TITLE' => 'PayPal Express',
  'MODULE_PAYMENT_PAYPALCART_TEXT_INFO' => '<img src="https://www.paypal.com/de_DE/DE/i/logo/lockbox_150x47.gif" />',
  'MODULE_PAYMENT_PAYPALCART_TEXT_DESCRIPTION' => 'PayPal Express Checkout - der PayPal Button im Warenkorb und auf der Artikelseite f&uuml;r maximale Konversion.<br/>Mehr Infos zu PayPal Express Shortcut finden Sie <a target="_blank" href="https://www.paypal.com/de/webapps/mpp/express-checkout">hier</a>.',
  'MODULE_PAYMENT_PAYPALCART_ALLOWED_TITLE' => 'Erlaubte Zonen',
  'MODULE_PAYMENT_PAYPALCART_ALLOWED_DESC' => 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))',
  'MODULE_PAYMENT_PAYPALCART_STATUS_TITLE' => 'PayPal Express aktivieren',
  'MODULE_PAYMENT_PAYPALCART_STATUS_DESC' => 'M&ouml;chten Sie Zahlungen per PayPal Express akzeptieren?',
  'MODULE_PAYMENT_PAYPALCART_SORT_ORDER_TITLE' => 'Anzeigereihenfolge',
  'MODULE_PAYMENT_PAYPALCART_SORT_ORDER_DESC' => 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt',
  'MODULE_PAYMENT_PAYPALCART_ZONE_TITLE' => 'Zahlungszone',
  'MODULE_PAYMENT_PAYPALCART_ZONE_DESC' => 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.',
  'MODULE_PAYMENT_PAYPALCART_LP' => '<br /><br /><a target="_blank" href="http://www.paypal.com/de/webapps/mpp/referral/paypal-business-account2?partner_id=EHALBVD4M2RQS"><strong>Jetzt PayPal Konto hier erstellen.</strong></a>',

  'MODULE_PAYMENT_PAYPALCART_TEXT_EXTENDED_DESCRIPTION' => '<strong><font color="red">ACHTUNG:</font></strong> Bitte nehmen Sie noch die Einstellungen unter "Partner Module" -> "PayPal" -> <a href="'.xtc_href_link('paypal_config.php').'"><strong>"PayPal Konfiguration"</strong></a> vor!',

  'MODULE_PAYMENT_PAYPALCART_TEXT_ERROR_HEADING' => 'Hinweis',
  'MODULE_PAYMENT_PAYPALCART_TEXT_ERROR_MESSAGE' => 'PayPal Zahlung wurde abgebrochen',
  
  'TEXT_PAYPAL_CART_ACCOUNT_CREATED' => 'Wir haben f&uuml;r Sie ein Kundenkonto mit Ihrer PayPal E-Mail Adresse angelegt. Das Passwort f&uuml;r Ihr neues Kundenkonto k&ouml;nnen Sie sp&auml;ter &uuml;ber die "Passwort vergessen" Funktion anfordern.',
);


foreach ($lang_array as $key => $val) {
  defined($key) or define($key, $val);
}
?>