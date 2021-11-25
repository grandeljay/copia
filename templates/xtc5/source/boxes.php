<?php
/* -----------------------------------------------------------------------------------------
   $Id: boxes.php 10720 2017-05-08 10:19:57Z Tomcraft $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2006 XT-Commerce
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

//BOC require boxes
// -----------------------------------------------------------------------------------------
//	Immer sichtbar
// -----------------------------------------------------------------------------------------
  require_once(DIR_FS_BOXES . 'categories.php');
  require_once(DIR_FS_BOXES . 'manufacturers.php');
  require_once(DIR_FS_BOXES . 'last_viewed.php');
  require_once(DIR_FS_BOXES . 'search.php');
  require_once(DIR_FS_BOXES . 'content.php');
  require_once(DIR_FS_BOXES . 'information.php');
  require_once(DIR_FS_BOXES . 'languages.php'); 
  require_once(DIR_FS_BOXES . 'infobox.php');
  if (!defined('MODULE_NEWSLETTER_STATUS') || MODULE_NEWSLETTER_STATUS == 'true') {
    require_once(DIR_FS_BOXES . 'newsletter.php');
  }
  if (defined('MODULE_TS_TRUSTEDSHOPS_ID') 
      && (MODULE_TS_WIDGET == '1'
          || (MODULE_TS_REVIEW_STICKER != '' && MODULE_TS_REVIEW_STICKER_STATUS == '1'))
      ) 
  {
    require_once(DIR_FS_BOXES . 'trustedshops.php');
  }
// -----------------------------------------------------------------------------------------
//	Nur sichtbar, wenn nicht auf der login.php Seite
// -----------------------------------------------------------------------------------------
  if (substr(basename($PHP_SELF), 0,5) != 'login') {
    require_once(DIR_FS_BOXES . 'loginbox.php');
  }
// -----------------------------------------------------------------------------------------
//	Nur, wenn Preise sichtbar
// -----------------------------------------------------------------------------------------
  if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
    require_once(DIR_FS_BOXES . 'add_a_quickie.php');
    require_once(DIR_FS_BOXES . 'shopping_cart.php');
    if (defined('MODULE_WISHLIST_SYSTEM_STATUS') && MODULE_WISHLIST_SYSTEM_STATUS == 'true') {
      require_once(DIR_FS_BOXES . 'wishlist.php');
    }
  }
// -----------------------------------------------------------------------------------------
//	In der Suche verborgen
// -----------------------------------------------------------------------------------------
  if (substr(basename($PHP_SELF), 0,8) != 'advanced') {
    require_once(DIR_FS_BOXES . 'whats_new.php'); 
  }
// -----------------------------------------------------------------------------------------
//	Nur fuer Admins
// -----------------------------------------------------------------------------------------
  if ($_SESSION['customers_status']['customers_status'] == '0') {
    require_once(DIR_FS_BOXES . 'admin.php');
    $smarty->assign('is_admin', true);
  }
// -----------------------------------------------------------------------------------------
//	Produkt-Detailseiten
// -----------------------------------------------------------------------------------------
  if ($product->isProduct() === true) {
    //Aktuelle Seite ist Produkt-Detailseite
    require_once(DIR_FS_BOXES . 'manufacturer_info.php');
  } else {
    //Aktuelle Seite ist keine  Produkt-Detailseite
    require_once(DIR_FS_BOXES . 'best_sellers.php');
    if ($_SESSION['customers_status']['customers_status_specials'] == '1') {
      require_once(DIR_FS_BOXES . 'specials.php');
    }
  }
// -----------------------------------------------------------------------------------------
//	Nur fuer eingeloggte Besucher
// -----------------------------------------------------------------------------------------
  if (isset($_SESSION['customer_id'])) {
    require_once(DIR_FS_BOXES . 'order_history.php');
  }
// -----------------------------------------------------------------------------------------
//	Nur, wenn Rezensionen erlaubt
// -----------------------------------------------------------------------------------------
  if ($_SESSION['customers_status']['customers_status_read_reviews'] == '1') {
    require_once(DIR_FS_BOXES . 'reviews.php');
  }
// -----------------------------------------------------------------------------------------
//	Waehrend des Kauf-Abschlusses verborgen 
// -----------------------------------------------------------------------------------------
  if (substr(basename($PHP_SELF), 0, 8) != 'checkout') {
    require_once(DIR_FS_BOXES . 'currencies.php');
  }
// -----------------------------------------------------------------------------------------
//EOC require boxes

// -----------------------------------------------------------------------------------------
// Smarty Zuweisung Startseite
// -----------------------------------------------------------------------------------------
$smarty->assign('home', strpos($PHP_SELF, 'index')!==false && !isset($_GET['cPath']) && !isset($_GET['manufacturers_id']) ? 1 : 0);
// -----------------------------------------------------------------------------------------

$smarty->assign('tpl_path',DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');
?>