<?php
/* -----------------------------------------------------------------------------------------
   $Id: create_breadcrumb.php 11768 2019-04-12 16:27:37Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
if (DIR_WS_CATALOG == '/') {
  $breadcrumb->add(HEADER_TITLE_TOP, xtc_href_link(FILENAME_DEFAULT));
  $link_index = HEADER_TITLE_TOP;
} else {
  $breadcrumb->add(HEADER_TITLE_TOP, xtc_href_link('../'));
  $breadcrumb->add(HEADER_TITLE_CATALOG, xtc_href_link(FILENAME_DEFAULT));
  $link_index = HEADER_TITLE_CATALOG;
}

// add category names or the manufacturer name to the breadcrumb trail
if (isset ($cPath_array)) {
  for ($i = 0, $n = sizeof($cPath_array); $i < $n; $i ++) {
    $categories_query = xtDBquery("SELECT cd.categories_name
                                     FROM ".TABLE_CATEGORIES_DESCRIPTION." cd
                                     JOIN ".TABLE_CATEGORIES." c
                                          ON c.categories_id = cd.categories_id
                                             AND cd.language_id='".(int) $_SESSION['languages_id']."'
                                             AND trim(cd.categories_name) != ''
                                    WHERE c.categories_id = '".(int)$cPath_array[$i]."'
                                      AND c.categories_status = '1'
                                          ".CATEGORIES_CONDITIONS_C);
    if (xtc_db_num_rows($categories_query,true) > 0) {
      $categories = xtc_db_fetch_array($categories_query,true);
      $breadcrumb->add($categories['categories_name'], xtc_href_link(FILENAME_DEFAULT, xtc_category_link($cPath_array[$i], $categories['categories_name'])));
    } else {
      break;
    }
  }
} elseif (isset($_GET['manufacturers_id']) && xtc_not_null($_GET['manufacturers_id'])) { 
  $_GET['manufacturers_id'] = (int) $_GET['manufacturers_id'];
  $manufacturers_array = xtc_get_manufacturers();
  if (isset($manufacturers_array[(int)$_GET['manufacturers_id']])) {
    $manufacturers = $manufacturers_array[(int)$_GET['manufacturers_id']];
    $breadcrumb->add($manufacturers['manufacturers_name'], xtc_href_link(FILENAME_DEFAULT, xtc_manufacturer_link((int) $_GET['manufacturers_id'], $manufacturers['manufacturers_name'])));
  }
}

// add the products model/name to the breadcrumb trail
if ($product->isProduct() === true) {
  $breadcrumb->add($product->getBreadcrumbModel(), xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$product->data['products_id']));
}

foreach(auto_include(DIR_FS_CATALOG.'includes/extra/modules/create_breadcrumb/','php') as $file) require_once ($file);
