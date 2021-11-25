<?php
/* -----------------------------------------------------------------------------------------
   $Id: set_ids_by_url_parameters.php 12277 2019-10-14 15:50:58Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// product URLS
if (isset($_GET['info'])) {
  $site = explode('_', $_GET['info']);
  $pID = $site[0];
  $_GET['products_id'] = xtc_input_validation(str_replace('p', '', $pID), 'products_id');
  $actual_products_id = (int) $_GET['products_id'];
  $product = new product($actual_products_id);
  unset($_GET['info']);
} elseif (isset($_GET['products_id'])) {
  $_GET['products_id'] = xtc_input_validation($_GET['products_id'], 'products_id');
  $actual_products_id = (int) $_GET['products_id'];
  $product = new product($actual_products_id);
}

// category URLS
if (isset($_GET['cat'])) {
  $site = explode('_', $_GET['cat']);
  $cID = $site[0];
  $cID = str_replace('c', '', $cID);
  $_GET['cPath'] = xtc_get_category_path($cID);
  unset($_GET['cat']);
}

// manufacturer URLS
if (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] != '') {
  require_once (DIR_FS_INC.'manufacturer_redirect.inc.php');
  $_GET['manufacturers_id'] = (int)$_GET['manufacturers_id'];
  $_GET['manufacturers_id'] = manufacturer_redirect($_GET['manufacturers_id']);
} elseif (isset($_GET['manu'])) {
  require_once (DIR_FS_INC.'manufacturer_redirect.inc.php');
  $site = explode('_', $_GET['manu']);
  $mID = $site[0];
  $mID = (int)str_replace('m', '', $mID);
  $_GET['manufacturers_id'] = $mID;
  unset($_GET['manu']);
  $_GET['manufacturers_id'] = manufacturer_redirect($_GET['manufacturers_id']);
}

// calculate category path
defined('PRODUCTS_CANONICAL_CAT_ID') OR define('PRODUCTS_CANONICAL_CAT_ID', false);
if (isset($_GET['cpID']) && (int)$_GET['cpID'] > 0) {
  $_SESSION['CatPath'] = xtc_get_category_path((int)$_GET['cpID']);
  unset($_GET['cpID']);
}
if (isset ($_GET['cPath']) && (!isset($product) || !is_object($product))) {
  $cPath = $_GET['cPath'] = xtc_input_validation($_GET['cPath'], 'cPath');
} elseif (isset($product) 
          && is_object($product) 
          && !isset($_GET['manufacturers_id'])
          && basename($PHP_SELF) == FILENAME_PRODUCT_INFO
          )
{
  if ($product->isProduct() === true) {
    require_once (DIR_FS_INC.'product_redirect.inc.php');
    $cPath = product_redirect($actual_products_id);
  } else {
    $cPath = '';
  }
} else {
  $cPath = '';
}
$products_link_cat_id = 0;

// set default product class
if (!isset($product) || !is_object($product)) {
  $product = new product();
}

// content URLS
if (isset ($_GET['coID']) && function_exists('xtc_get_content_path')) {
  require_once (DIR_FS_INC.'content_redirect.inc.php');
  $_GET['coID'] = (int) $_GET['coID'];
  $_GET['coID'] = content_redirect($_GET['coID']);
  $coPath_array = xtc_get_content_path($_GET['coID']);
  $coPath_array[sizeof($coPath_array)] = xtc_get_content_id($_GET['coID']);  
  $coPath = implode('_', $coPath_array);
}

//set $current_category_id, $_SESSION['CatPath'], verify $cPath
unset($_SESSION['CatPath']);
if (xtc_not_null($cPath)) {
  require_once (DIR_FS_INC.'category_redirect.inc.php');
  $cPath_array = xtc_parse_category_path($cPath);
  $current_category_id = end($cPath_array);
  $cPath = category_redirect(xtc_get_category_path($current_category_id)); //verify $cPath
  $_SESSION['CatPath'] = $cPath;
} else {
  $current_category_id = 0;
}

if (isset($_GET['page']) && $_GET['page'] != '') {
  $_GET['page'] = (int)$_GET['page'];
}