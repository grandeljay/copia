<?php
/* --------------------------------------------------------------
   $Id: orders.php 10326 2016-10-19 14:06:18Z Tomcraft $   

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce; www.oscommerce.com 
   (c) 2003      nextcommerce; www.nextcommerce.org
   (c) 2006      xt:Commerce; www.xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
define('TEXT_BANK', 'Bankeinzug');
define('TEXT_BANK_OWNER', 'Kontoinhaber:');
define('TEXT_BANK_NUMBER', 'Kontonummer:');
define('TEXT_BANK_BLZ', 'BLZ:');
define('TEXT_BANK_NAME', 'Bank:');
define('TEXT_BANK_BIC', 'BIC:');
define('TEXT_BANK_IBAN', 'IBAN:');
define('TEXT_BANK_FAX', 'Einzugserm&auml;chtigung wird per Fax best&auml;tigt');
define('TEXT_BANK_STATUS', 'Pr&uuml;fstatus:');
define('TEXT_BANK_PRZ', 'Pr&uuml;fverfahren:');
define('TEXT_BANK_OWNER_EMAIL', 'E-Mail-Adresse Kontoinhaber:');

define('TEXT_BANK_ERROR_1', 'Kontonummer stimmt nicht mit BLZ &uuml;berein!');
define('TEXT_BANK_ERROR_2', 'F&uuml;r diese Kontonummer ist kein Pr&uuml;fverfahren definiert!');
define('TEXT_BANK_ERROR_3', 'Kontonummer nicht pr&uuml;fbar! Pr&uuml;fverfahren nicht implementiert');
define('TEXT_BANK_ERROR_4', 'Kontonummer technisch nicht pr&uuml;fbar!');
define('TEXT_BANK_ERROR_5', 'Bankleitzahl nicht gefunden!');
define('TEXT_BANK_ERROR_8', 'Keine Bankleitzahl angegeben!');
define('TEXT_BANK_ERROR_9', 'Keine Kontonummer angegeben!');
define('TEXT_BANK_ERRORCODE', 'Fehlercode:');

define('HEADING_TITLE', 'Bestellungen');
define('HEADING_TITLE_SEARCH', 'Bestell-Nr.:');
define('HEADING_TITLE_STATUS', 'Status:');

define('TABLE_HEADING_COMMENTS', 'Kommentar');
define('TABLE_HEADING_CUSTOMERS', 'Kunden');
define('TABLE_HEADING_ORDER_TOTAL', 'Gesamtwert');
define('TABLE_HEADING_DATE_PURCHASED', 'Bestelldatum');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TABLE_HEADING_QUANTITY', 'Anzahl');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Artikel-Nr.');
define('TABLE_HEADING_PRODUCTS', 'Artikel');
define('TABLE_HEADING_TAX', 'MwSt.');
define('TABLE_HEADING_TOTAL', 'Gesamtsumme');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Preis (exkl.)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Preis (inkl.)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (exkl.)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total');
define('TABLE_HEADING_AFTERBUY','Afterbuy');
define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Kunde benachrichtigt');
define('TABLE_HEADING_DATE_ADDED', 'hinzugef&uuml;gt am:');

define('ENTRY_CUSTOMER', 'Kunde:');
define('ENTRY_SOLD_TO', 'Rechnungsadresse:');
define('ENTRY_STREET_ADDRESS', 'Strasse:');
define('ENTRY_SUBURB', 'zus. Anschrift:');
define('ENTRY_CITY', 'Stadt:');
define('ENTRY_POST_CODE', 'PLZ:');
define('ENTRY_STATE', 'Bundesland:');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_TELEPHONE', 'Telefon:');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail-Adresse:');
define('ENTRY_DELIVERY_TO', 'Lieferanschrift:');
define('ENTRY_SHIP_TO', 'Lieferanschrift:');
define('ENTRY_SHIPPING_ADDRESS', 'Versandadresse:');
define('ENTRY_BILLING_ADDRESS', 'Rechnungsadresse:');
define('ENTRY_PAYMENT_METHOD', 'Zahlungsweise:');
define('ENTRY_SHIPPING_METHOD', 'Versandart:');
define('ENTRY_CREDIT_CARD_TYPE', 'Kreditkartentyp:');
define('ENTRY_CREDIT_CARD_OWNER', 'Kreditkarteninhaber:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Kreditkartennummer:');
define('ENTRY_CREDIT_CARD_CVV', 'Sicherheitscode (CVV)):');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Kreditkarte l&auml;uft ab am:');
define('ENTRY_SUB_TOTAL', 'Zwischensumme:');
define('ENTRY_TAX', 'MwSt.:');
define('ENTRY_SHIPPING', 'Versandkosten:');
define('ENTRY_TOTAL', 'Gesamtsumme:');
define('ENTRY_DATE_PURCHASED', 'Bestelldatum:');
define('ENTRY_STATUS', 'Status:');
define('ENTRY_DATE_LAST_UPDATED', 'zuletzt aktualisiert am:');
define('ENTRY_NOTIFY_CUSTOMER', 'Kunde benachrichtigen:');
define('ENTRY_NOTIFY_COMMENTS', 'Kommentare mitsenden:');
define('ENTRY_PRINTABLE', 'Rechnung Drucken');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Bestellung l&ouml;schen');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, das Sie diese Bestellung l&ouml;schen m&ouml;chten?');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Artikelanzahl dem Lager gutschreiben');
define('TEXT_DATE_ORDER_CREATED', 'erstellt am:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'letzte &Auml;nderung:');
define('TEXT_INFO_PAYMENT_METHOD', 'Zahlungsweise:');
define('TEXT_INFO_SHIPPING_METHOD', 'Versandart:');

define('TEXT_ALL_ORDERS', 'Alle Bestellungen');
define('TEXT_NO_ORDER_HISTORY', 'Keine Bestellhistorie verf&uuml;gbar');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Status&auml;nderung Ihrer Bestellung');
define('EMAIL_TEXT_ORDER_NUMBER', 'Bestell-Nr.:');
define('EMAIL_TEXT_INVOICE_URL', 'Ihre Bestellung k&ouml;nnen Sie unter folgender Adresse einsehen:');
define('EMAIL_TEXT_DATE_ORDERED', 'Bestelldatum:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Der Status Ihrer Bestellung wurde aktualisiert.' . "\n\n" . 'Neuer Status: %s' . "\n\n" . 'Bei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese E-Mail.' . "\n\n" . 'Mit freundlichen Gr&uuml;ssen' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Anmerkungen und Kommentare zu Ihrer Bestellung:' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Fehler: Die Bestellung existiert nicht!.');
define('SUCCESS_ORDER_UPDATED', 'Erfolg: Die Bestellung wurde erfolgreich aktualisiert.');
define('WARNING_ORDER_NOT_UPDATED', 'Hinweis: Es wurde nichts ge&auml;ndert. Daher wurde diese Bestellung nicht aktualisiert.');

define('TABLE_HEADING_DISCOUNT','Rabatt');
define('ENTRY_CUSTOMERS_GROUP','Kundengruppe:');
define('ENTRY_CUSTOMERS_VAT_ID','USt-IdNr.:');
define('TEXT_VALIDATING','Nicht best&auml;tigt');

// BOF - Tomcraft - 2009-10-03 - Paypal Express Modul
define('TEXT_INFO_PAYPAL_DELETE', 'PayPal Transaktions Daten auch l�schen.'); // ACHTUNG hier keine HTML-Entities verwenden
// EOF - Tomcraft - 2009-10-03 - Paypal Express Modul

// BOF - Tomcraft - 2010-04-22 - Added a missing language definition
define('TEXT_PRODUCTS', 'Artikel');
// EOF - Tomcraft - 2010-04-22 - Added a missing language definition

//BOF - web28 - 2010-03-20 - Send Order by Admin
define('COMMENT_SEND_ORDER_BY_ADMIN' , 'Auftragsbest�tigung gesendet'); // ACHTUNG hier keine HTML-Entities verwenden
define('BUTTON_ORDER_CONFIRMATION', 'Auftragsbest&auml;tigung senden');
define('SUCCESS_ORDER_SEND', 'Auftragsbest&auml;tigung erfolgreich gesendet');
//EOF - web28 - 2010-03-20 - Send Order by Admin

// web28 2010-12-07 add new defines
define('ENTRY_CUSTOMERS_ADDRESS', 'Kundenadresse:');
define('TEXT_ORDER', 'Bestellung:');
define('TEXT_ORDER_HISTORY', 'Bestellhistorie:');
define('TEXT_ORDER_STATUS', 'Bestellstatus:');

define('TABLE_HEADING_ORDERS_ID', 'Best.Nr.');
define('TEXT_SHIPPING_TO', 'Versand nach');

define('TABLE_HEADING_COMMENTS_SENT', 'Kommentar versandt');

define('TABLE_HEADING_TRACK_TRACE', 'Track &amp; Trace:');
define('TABLE_HEADING_CARRIER', 'Versandart');
define('TABLE_HEADING_PARCEL_LINK', 'Sendungsnummer / Paketscheinnummer / Auftragsnummer / Sendungs-ID / Trackingnummer');

define('TEXT_INFO_HEADING_REVERSE_ORDER', 'Bestellung stornieren');
define('TEXT_INFO_REVERSE_INTRO', 'Sind Sie sicher, das Sie diese Bestellung stornieren m&ouml;chten?');

define('TABLE_HEADING_SHIPCLOUD', 'Shipcloud:');
define('TABLE_HEADING_PARCEL_ID', 'Paketschein Nummer');
define('TEXT_SHIPCLOUD_STANDARD', 'Standard');
define('TEXT_SHIPCLOUD_ONE_DAY', 'Express');
define('TEXT_SHIPCLOUD_ONE_DAY_EARLY', 'Express 10:00');
define('TEXT_SHIPCLOUD_RETURNS', 'Retour');
define('TEXT_SHIPCLOUD_LETTER', 'Post Brief');
define('TEXT_SHIPCLOUD_BOOKS', 'Post B&uuml;chersendung');
define('TEXT_SHIPCLOUD_PARCEL_LETTER', 'Post Warensendung');

define('DOWNLOAD_LABEL', 'Paketschein herunterladen');
define('CREATE_LABEL', 'Paketschein erstellen');
define('TEXT_DELETE_SHIPMENT_SUCCESS', 'shipcloud Paketschein gel&ouml;scht.');
define('TEXT_LABEL_CREATED', 'Paketschein erfolgreich erstellt.');
define('TEXT_CARRIER_ERROR', 'Paketdienstleister nicht in Ihrem shipcloud Account freigeschaltet oder ung&uuml;ltiger API-Key.');
define('TEXT_CARRIER_PLACEHOLDER', 'Beschreibung (optional)');

define('TEXT_DOWNLOADS', 'Downloads');
define('TABLE_HEADING_FILENAME', 'Dateiname');
define('TABLE_HEADING_EXPIRES', 'Ablaufdatum');
define('TABLE_HEADING_DOWNLOADS', 'Anzahl Downloads');
define('TABLE_HEADING_DAYS', 'Anzahl Tage');

define('ENTRY_SEND_TRACKING_INFO', 'Versandinformationen:');

define('TEXT_ORDERS_STATUS_FILTER', 'Bestellstatus Filter');

define('TABLE_HEADING_DATE', 'Datum');

define('BUTTON_ORDER_MAIL_STEP', 'Bestellbest&auml;tigung senden');
define('COMMENT_SEND_ORDER_MAIL_STEP' , 'Bestellbest�tigung gesendet'); // ACHTUNG hier keine HTML-Entities verwenden
define('SUCCESS_ORDER_MAIL_STEP_SEND', 'Bestellbest&auml;tigung erfolgreich gesendet');
?>