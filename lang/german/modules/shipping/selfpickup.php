<?PHP
/* -----------------------------------------------------------------------------------------
   $Id: selfpickup.php 12400 2019-11-08 13:28:49Z Tomcraft $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( freeamount.php,v 1.01 2002/01/24 03:25:00); www.oscommerce.com
   (c) 2003 nextcommerce (freeamount.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2006 xt:Commerce; www.xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   selfpickup         Autor: sebthom

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_SELFPICKUP_TEXT_TITLE', 'Selbstabholung');
define('MODULE_SHIPPING_SELFPICKUP_TEXT_DESCRIPTION', 'Selbstabholung der Ware in unserer Gesch&auml;ftsstelle');
define('MODULE_SHIPPING_SELFPICKUP_TEXT_WAY', 'Selbstabholung der Ware in unserer Gesch&auml;ftsstelle.');
define('MODULE_SHIPPING_SELFPICKUP_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_SHIPPING_SELFPICKUP_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand m&ouml;glich sein soll. (z.B. AT,DE (lassen Sie dieses Feld leer, wenn Sie alle Zonen erlauben wollen))');
define('MODULE_SHIPPING_SELFPICKUP_STATUS_TITLE', 'Selbstabholung aktivieren');
define('MODULE_SHIPPING_SELFPICKUP_STATUS_DESC', 'M&ouml;chten Sie Selbstabholung anbieten?');
define('MODULE_SHIPPING_SELFPICKUP_SORT_ORDER_TITLE', 'Sortierreihenfolge');
define('MODULE_SHIPPING_SELFPICKUP_SORT_ORDER_DESC', 'Reihenfolge der Anzeige');
define('MODULE_SHIPPING_SELFPICKUP_COMPANY_TITLE', 'Firmenname');
define('MODULE_SHIPPING_SELFPICKUP_COMPANY_DESC', 'Geben Sie den Firmennamen an.');
define('MODULE_SHIPPING_SELFPICKUP_FIRSTNAME_TITLE', 'Vorname');
define('MODULE_SHIPPING_SELFPICKUP_FIRSTNAME_DESC', 'Geben Sie den Vornamen an.');
define('MODULE_SHIPPING_SELFPICKUP_LASTNAME_TITLE', 'Nachname');
define('MODULE_SHIPPING_SELFPICKUP_LASTNAME_DESC', 'Geben Sie den Nachnamen an.');
define('MODULE_SHIPPING_SELFPICKUP_STREET_ADDRESS_TITLE', 'Stra&szlig;e/Nr.');
define('MODULE_SHIPPING_SELFPICKUP_STREET_ADDRESS_DESC', 'Geben Sie die Stra&szlig;e und Hausnummer an.');
define('MODULE_SHIPPING_SELFPICKUP_SUBURB_TITLE', 'Adresszusatz');
define('MODULE_SHIPPING_SELFPICKUP_SUBURB_DESC', 'Geben Sie den Adresszusatz an.');
define('MODULE_SHIPPING_SELFPICKUP_POSTCODE_TITLE', 'Postleitzahl');
define('MODULE_SHIPPING_SELFPICKUP_POSTCODE_DESC', 'Geben Sie die Postleitzahl an.');
define('MODULE_SHIPPING_SELFPICKUP_CITY_TITLE', 'Ort');
define('MODULE_SHIPPING_SELFPICKUP_CITY_DESC', 'Geben Sie den Ort an.');
define('MODULE_SHIPPING_SELFPICKUP_COUNTRY_TITLE', 'Land');
define('MODULE_SHIPPING_SELFPICKUP_COUNTRY_DESC', 'Geben Sie das Land an.');
?>