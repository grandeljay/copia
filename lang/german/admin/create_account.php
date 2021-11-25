<?php
/* --------------------------------------------------------------
   $Id: create_account.php 11649 2019-03-28 14:36:34Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(create_account.php,v 1.13 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (create_account.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('NAVBAR_TITLE', 'Konto erstellen');

define('HEADING_TITLE', 'Kundenkonto Admin');

define('TEXT_ORIGIN_LOGIN', '<span class="col-red"><small><b>ACHTUNG:</b></small></span> Wenn Sie bereits ein Konto besitzen, melden Sie sich bitte <a href="%s"><u><b>hier</b></u></a> an.');

define('EMAIL_SUBJECT', 'Willkommen bei ' . STORE_NAME);
define('EMAIL_WELCOME', 'Willkommen bei <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_TEXT', 'Sie k&ouml;nnen jetzt unseren <b>Online-Service</b> nutzen. Der Service bietet unter anderem:' . "\n\n" . '<li><b>Kundenwarenkorb</b> - Jeder Artikel bleibt darin registriert bis Sie zur Kasse bezahlen, oder die Artikel aus dem Warenkorb entfernen.' . "\n" . '<li><b>Adressbuch</b> - Wir k&ouml;nnen jetzt die Artikel zu der von Ihnen ausgesuchten Adresse senden. Der perfekte Weg ein Geburtstagsgeschenk zu versenden.' . "\n" . '<li><b>Vorherige Bestellungen</b> - Sie k&ouml;nnen jederzeit Ihre vorangegangenen Bestellungen &uuml;berpr&uuml;fen.' . "\n" . '<li><b>Meinungen &uuml;ber Artikel</b> - Teilen Sie Ihre Meinung zu unseren Artikeln mit anderen Kunden.' . "\n\n");
define('EMAIL_CONTACT', 'Falls Sie Fragen zu unserem Kunden-Service haben, wenden Sie sich bitte an uns: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Achtung:</b> Diese E-Mail-Adresse wurde uns von einem Kunden bekannt gegeben. Falls Sie sich nicht angemeldet haben, senden Sie bitte eine E-Mail an ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
define('ENTRY_PAYMENT_UNALLOWED','Nicht erlaubte Zahlungsmodule:');
define('ENTRY_SHIPPING_UNALLOWED','Nicht erlaubte Versandmodule:');
?>