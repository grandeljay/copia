<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_info.php 13237 2021-01-26 13:30:03Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com
   (c) 2003 nextcommerce (product_info.php,v 1.46 2003/08/25); www.nextcommerce.org
   (c) 2006 xt:Commerce (product_info.php 1317 2005-10-21); www.xt-commerce.de

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
   New Attribute Manager v4b - Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Cross-Sell (X-Sell) Admin 1 - Autor: Joshua Dechant (dreamscape)
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// todo: move to configuration ?
defined('MANUFACTURER_IMAGE_SHOW_NO_IMAGE') OR define('MANUFACTURER_IMAGE_SHOW_NO_IMAGE', 'false');

/******* SHOPGATE **********/
if(defined('MODULE_PAYMENT_SHOPGATE_STATUS') && MODULE_PAYMENT_SHOPGATE_STATUS=='True' && strpos($_SESSION['customers_status']['customers_status_payment_unallowed'], 'shopgate') === false){
  include_once DIR_FS_CATALOG.'includes/external/shopgate/base/includes/modules/product_info.php';
}
/******* SHOPGATE **********/

//include needed functions
require_once (DIR_FS_INC.'xtc_get_products_mo_images.inc.php');
require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');
require_once (DIR_FS_INC.'xtc_date_short.inc.php');  // for specials

if (!is_object($product) || $product->isProduct() === false || $language_not_found === true) {

  // product not found in database
  $site_error = TEXT_PRODUCT_NOT_FOUND;
  include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);

} else {

  $info_smarty = new Smarty;
  $info_smarty->assign('tpl_path', DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');

  // defaults
  $hide_qty = 0;

  if (ACTIVATE_NAVIGATOR == 'true') {
    include (DIR_WS_MODULES.'product_navigator.php');
  }

  // Update products_viewed
  if ($_SESSION['customers_status']['customers_status_id'] != '0') {
    xtc_db_query("UPDATE ".TABLE_PRODUCTS_DESCRIPTION."
                     SET products_viewed = products_viewed+1
                   WHERE products_id = '".$product->data['products_id']."'
                     AND language_id = ".(int)$_SESSION['languages_id']);
  }

  $manufacturers_array = xtc_get_manufacturers();
  if (isset($manufacturers_array[$product->data['manufacturers_id']])) {
    $manufacturer = $manufacturers_array[$product->data['manufacturers_id']];
    $image = $main->getImage($manufacturer['manufacturers_image'], 'manufacturers/', MANUFACTURER_IMAGE_SHOW_NO_IMAGE);

    $info_smarty->assign('MANUFACTURER_IMAGE', (($image != '') ? DIR_WS_BASE . $image : ''));
    $info_smarty->assign('MANUFACTURER', $manufacturer['manufacturers_name']);
    $info_smarty->assign('MANUFACTURER_DESCRIPTION', $manufacturer['manufacturers_description']);
    $info_smarty->assign('MANUFACTURER_LINK', xtc_href_link(FILENAME_DEFAULT, xtc_manufacturer_link($manufacturer['manufacturers_id'], $manufacturer['manufacturers_name'])));
  }

  // check if customer is allowed to add to cart
  if ($_SESSION['customers_status']['customers_status_show_price'] != '0'
      && (($_SESSION['customers_status']['customers_fsk18'] == '1' && $product->data['products_fsk18'] == '0')
      || $_SESSION['customers_status']['customers_fsk18'] != '1')) 
  {
    $add_pid_to_qty = xtc_draw_hidden_field('products_id', $product->data['products_id']);
    $info_smarty->assign('ADD_QTY', xtc_draw_input_field('products_qty', '1', ($hide_qty ? '' : 'size="3"'), ($hide_qty ? 'hidden' : 'text')).' '.$add_pid_to_qty);
    $info_smarty->assign('ADD_CART_BUTTON', xtc_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART));

    if (defined('MODULE_CHECKOUT_EXPRESS_STATUS') && MODULE_CHECKOUT_EXPRESS_STATUS == 'true') {
      if (isset($_SESSION['customer_id']) && $_SESSION['customers_status']['customers_status_id'] != DEFAULT_CUSTOMERS_STATUS_ID_GUEST) {
        $express_query = xtc_db_query("SELECT *
                                         FROM ".TABLE_CUSTOMERS_CHECKOUT." 
                                        WHERE customers_id = '".(int)$_SESSION['customer_id']."'");
        if (xtc_db_num_rows($express_query) > 0) {
          $info_smarty->assign('ADD_CART_BUTTON_EXPRESS', xtc_image_submit('button_checkout_express.gif', IMAGE_BUTTON_IN_CART, 'name="express"'));
        } else {
          $info_smarty->assign('ACTIVATE_EXPRESS_LINK', xtc_href_link(FILENAME_ACCOUNT_CHECKOUT_EXPRESS, 'products_id='.$product->data['products_id'], 'SSL'));
        }
      }
      if (MODULE_CHECKOUT_EXPRESS_CONTENT != '') {
        $info_smarty->assign('EXPRESS_LINK', $main->getContentLink(MODULE_CHECKOUT_EXPRESS_CONTENT, TEXT_CHECKOUT_EXPRESS_INFO_LINK, 'NONSSL', false));
      }
    }

    // check for gift
    if (preg_match('/^GIFT/', addslashes($product->data['products_model']))
        && $_SESSION['customers_status']['customers_status_id'] == DEFAULT_CUSTOMERS_STATUS_ID_GUEST
        && isset($_SESSION['customer_id']))
    {
      $info_smarty->clear_assign('ADD_QTY');
      $info_smarty->clear_assign('ADD_CART_BUTTON');      
    }
    
    // wishlist
    if (defined('MODULE_WISHLIST_SYSTEM_STATUS') && MODULE_WISHLIST_SYSTEM_STATUS == 'true') {
      $info_smarty->assign('ADD_CART_BUTTON_WISHLIST', xtc_image_submit('button_in_wishlist.gif', IMAGE_BUTTON_TO_WISHLIST, 'name="wishlist"'));
      $info_smarty->assign('ADD_CART_BUTTON_WISHLIST_TEXT', '<input type="submit" value="submit" style="display:none;" />'.xtc_draw_input_field('wishlist', IMAGE_BUTTON_TO_WISHLIST, 'class="wishlist_submit_link"', 'submit'));
    }
  }
  
  // form tags
  $info_smarty->assign('FORM_ACTION', xtc_draw_form('cart_quantity', xtc_href_link(FILENAME_PRODUCT_INFO, xtc_get_all_get_params(array ('action')).'action=add_product', $request_type)));
  $info_smarty->assign('FORM_END', '</form>');
  
  // load all definitions from product class
  $productDataArray = $product->buildDataArray($product->data, 'info');
  foreach ($productDataArray as $key => $value) {
    $info_smarty->assign($key, $value);
  }
  
  /*
   * assign smarty additional variables or overwrite them
   * START
   */
   
  // show expiry date of active special products
  if ($_SESSION['customers_status']['customers_status_specials'] != '0') {
    $special_expires_date_query = "SELECT expires_date
                                     FROM ".TABLE_SPECIALS."
                                    WHERE products_id = '".$product->data['products_id']."'
                                          ".SPECIALS_CONDITIONS;
    $special_expires_date_query = xtc_db_query($special_expires_date_query);
    if (xtc_db_num_rows($special_expires_date_query) > 0) {
      $sDate = xtc_db_fetch_array($special_expires_date_query);
      $info_smarty->assign('PRODUCTS_EXPIRES', $sDate['expires_date'] != '0000-00-00 00:00:00' ? xtc_date_short($sDate['expires_date']) : '');
      $info_smarty->assign('PRODUCTS_EXPIRES_C', $sDate['expires_date'] != '0000-00-00 00:00:00' ? date('c', strtotime($sDate['expires_date'])) : '');
    }
  }

  // FSK18
  $info_smarty->assign('PRODUCTS_FSK18', $product->data['products_fsk18'] == '1' ? 'true' : '');
  
  $info_smarty->assign('PRODUCTS_PRINT', xtc_image_button('print.gif', PRINTVIEW_INFO, 'onclick="javascript:window.open(\''.xtc_href_link(FILENAME_PRINT_PRODUCT_INFO, 'products_id='.$product->data['products_id'], $request_type).'\', \'popup\', \'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no, '.POPUP_PRODUCT_PRINT_SIZE.'\')"'));
  $info_smarty->assign('PRODUCTS_PRINT_LAYER', '<a class="iframe" target="_blank" rel="nofollow" href="'.xtc_href_link(FILENAME_PRINT_PRODUCT_INFO, 'products_id='.$product->data['products_id'], $request_type). '" title="'.PRINTVIEW_INFO.'">'.PRINTVIEW_INFO.'</a>');
  $info_smarty->assign('PRODUCTS_WRITE_REVIEW', '<a rel="nofollow" href="'.xtc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'products_id='.$product->data['products_id']). '" title="'.PRODUCTS_REVIEW_LINK.'">'.PRODUCTS_REVIEW_LINK.'</a>');
  $info_smarty->assign('PRODUCTS_DESCRIPTION', stripslashes($product->data['products_description']));
  $info_smarty->assign('PRODUCTS_SHORT_DESCRIPTION', stripslashes($product->data['products_short_description']));
  $info_smarty->assign('PRODUCTS_URL', !empty($product->data['products_url']) ? sprintf(TEXT_MORE_INFORMATION, xtc_href_link(FILENAME_REDIRECT, 'action=product&id='.$product->data['products_id'], 'NONSSL', true, false)) : '');

  // more images
  if (MO_PICS != '0') {
    $mo_images = xtc_get_products_mo_images($product->data['products_id']);
    if ($mo_images != false) {
      $more_images_data = array();
      foreach ($mo_images as $img) {
        $mo_img = $product->productImage($img['image_name'], 'info');
        $mo_img_nr = $img['image_nr'];
        if ($mo_img != '') {
          $more_images_data[$mo_img_nr] = array ('PRODUCTS_IMAGE' => $mo_img);
        }
        foreach(auto_include(DIR_FS_CATALOG.'includes/extra/modules/product_info_mo_images/','php') as $file) require ($file);
      }
      $info_smarty->assign('more_images', $more_images_data);
    }
  }

  // product discount
  if ($_SESSION['customers_status']['customers_status_public'] == '1') {
    $discount = $xtPrice->xtcCheckDiscount($product->data['products_id']);
    if ($discount != '0.00') {
      $info_smarty->assign('PRODUCTS_DISCOUNT', $discount.'%');
    }
  }

  // date available/added
  if (isset($product->data['products_date_available']) && $product->data['products_date_available'] > date('Y-m-d H:i:s')) {
    $info_smarty->assign('PRODUCTS_DATE_AVIABLE', sprintf(TEXT_DATE_AVAILABLE, xtc_date_long($product->data['products_date_available'])));
    $info_smarty->assign('PRODUCTS_DATE_AVAILABLE', sprintf(TEXT_DATE_AVAILABLE, xtc_date_long($product->data['products_date_available']))); 
  } elseif (isset($product->data['products_date_added']) && $product->data['products_date_added'] != '0000-00-00 00:00:00') {
    $info_smarty->assign('PRODUCTS_ADDED', sprintf(TEXT_DATE_ADDED, xtc_date_long($product->data['products_date_added'])));
  }
  
  /*
   * assign smarty additional variables or overwrite them
   * END
   */

  //include modules
  if ($_SESSION['customers_status']['customers_status_graduated_prices'] == '1') {
    include (DIR_WS_MODULES.FILENAME_GRADUATED_PRICE);
  }
  $products_reviews_count = 0;
  if ($_SESSION['customers_status']['customers_status_read_reviews'] == '1') {
    $products_reviews_count = $product->getReviewsCount();
    $info_smarty->assign('PRODUCTS_AVERAGE_RATING', $product->getReviewsAverage());
    $info_smarty->assign('PRODUCTS_RATING_COUNT', $products_reviews_count);
    include (DIR_WS_MODULES.'product_reviews.php');
  }
  include (DIR_WS_MODULES.'product_tags.php');
  include (DIR_WS_MODULES.'product_attributes.php');
  include (DIR_WS_MODULES.FILENAME_PRODUCTS_MEDIA);
  include (DIR_WS_MODULES.FILENAME_ALSO_PURCHASED_PRODUCTS);
  include (DIR_WS_MODULES.FILENAME_CROSS_SELLING);

  foreach(auto_include(DIR_FS_CATALOG.'includes/extra/modules/product_info_end/','php') as $file) require ($file);

  // get default product_info template
  if ($product->data['product_template'] == '' 
      || $product->data['product_template'] == 'default'
      || !is_file(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/product_info/'.$product->data['product_template'])
      )
  {
    $files = array_filter(auto_include(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/product_info/','html'), function($file) {
      return false === strpos($file, 'index.html');
    });
    $product->data['product_template'] = basename($files[0]);
  }

  // session products history
  if (!isset($_SESSION['tracking']['products_history'])) $_SESSION['tracking']['products_history'] = array();
  if (in_array($product->data['products_id'], $_SESSION['tracking']['products_history'])) {
    unset($_SESSION['tracking']['products_history'][array_search($product->data['products_id'], $_SESSION['tracking']['products_history'])]);
    $_SESSION['tracking']['products_history'] = array_values($_SESSION['tracking']['products_history']);
  }
  array_push($_SESSION['tracking']['products_history'], $product->data['products_id']);
  if (count($_SESSION['tracking']['products_history']) > (int)MAX_DISPLAY_PRODUCTS_HISTORY) {
    array_shift($_SESSION['tracking']['products_history']); 
  }
  $_SESSION['tracking']['products_history'] = array_values($_SESSION['tracking']['products_history']);

  $info_smarty->assign('language', $_SESSION['language']);

  // set cache ID
  if (!CacheCheck()) {
    $info_smarty->caching = 0;
    $product_info = $info_smarty->fetch(CURRENT_TEMPLATE.'/module/product_info/'.$product->data['product_template']);
  } else {
    $info_smarty->caching = 1;
    $info_smarty->cache_lifetime = CACHE_LIFETIME;
    $info_smarty->cache_modified_check = CACHE_CHECK;

    //setting/clearing params
    $get_params = xtc_get_all_get_params();
    $get_params .= $products_reviews_count;
    
    $cache_id = md5(xtc_input_validation($_GET['products_id'], 'products_id').$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'].$get_params);
    $product_info = $info_smarty->fetch(CURRENT_TEMPLATE.'/module/product_info/'.$product->data['product_template'], $cache_id);
  }
  $smarty->assign('main_content', $product_info);
}
?>