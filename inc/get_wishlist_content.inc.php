<?php
  /* --------------------------------------------------------------
   $Id: get_wishlist_content.inc.php 13488 2021-04-01 09:24:18Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2014 [www.modified-shop.org]
   --------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------*/

  // include needed functions
  require_once(DIR_FS_INC.'xtc_get_products_image.inc.php');

  function get_wishlist_content() {
    global $main, $xtPrice, $product, $PHP_SELF;
    
    $module_data = array();
    $attributes_exists = false;
    
    // build array with wishlist content and count quantity  
    $products = $_SESSION['wishlist']->get_products();

    for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
      foreach((array)$products[$i] as $key => $entry) {                  
        $module_data[$i]['PRODUCTS_'.strtoupper($key)] = $entry;
      }

      $del_button = '<a href="' . xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array('action', 'box', 'prd_id')).'action=remove_product&wishlist=true&prd_id=' . $products[$i]['id'], 'NONSSL') . '">' . xtc_image_button('wishlist_del.gif', IMAGE_BUTTON_DELETE) . '</a>';
      $cart_del_button = '<a href="' . xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array('action', 'box', 'prd_id')).'action=remove_product&wishlist=true&box=cart&prd_id=' . $products[$i]['id'], 'NONSSL') . '">' . xtc_image_button('cart_del.gif', IMAGE_BUTTON_DELETE) . '</a>';

       //get $shipping_status_name, $shipping_status_image
      $shipping_status_name = $shipping_status_image = $shipping_status_link = '';
      if (isset($products[$i]['shippingtime']) && ACTIVATE_SHIPPING_STATUS == 'true') {
        $shipping_status_name = $main->getShippingStatusName($products[$i]['shippingtime']);
        $shipping_status_image = $main->getShippingStatusImage($products[$i]['shippingtime']);
        $shipping_status_link = $main->getShippingStatusName($products[$i]['shippingtime'], true);      
      }
  
      $module_content_add = array (
        'PRODUCTS_LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$products[$i]['id']),
        'PRODUCTS_NAME' => $products[$i]['name'],
        'PRODUCTS_IMAGE' => $product->productImage(xtc_get_products_image(xtc_get_prid($products[$i]['id'])), 'thumbnail'),
        'PRODUCTS_BUTTON_DELETE' => $del_button,
        'PRODUCTS_BUTTON_DELETE_CART' => $cart_del_button,
        'PRODUCTS_VPE' => $products[$i]['vpe'],
        'PRODUCTS_SHIPPING_LINK' => $main->getShippingLink(),
        'PRODUCTS_SHIPPING_NAME' => $shipping_status_name,
        'PRODUCTS_SHIPPING_IMAGE' => $shipping_status_image,
        'PRODUCTS_SHIPPING_NAME_LINK' => $shipping_status_link,
        'PRODUCTS_TAX_INFO' => $main->getTaxInfo($products[$i]['tax']),
        'PRODUCTS_PRICE' => $xtPrice->xtcFormat($products[$i]['price'], true, 0, false, 0, 0, 0),
        'PRODUCTS_BUTTON_BUY_NOW' => $product->getWishlistToCartButton($products[$i]['id'], $products[$i]['name'], $products[$i]['quantity']),
        'PRODUCTS_BUTTON_BUY_NOW_CART' => $product->getWishlistToCartButton($products[$i]['id'], $products[$i]['name'], $products[$i]['quantity'], true),
        'PRODUCTS_QTY' => $products[$i]['quantity'],
        'PRODUCTS_SHORT_DESCRIPTION' => $products[$i]['short_description'],
        'PRODUCTS_DESCRIPTION' => $products[$i]['description'],
        'ATTRIBUTES' => array()
      );
      $module_data[$i] = array_merge($module_data[$i], $module_content_add);

      foreach(auto_include(DIR_FS_CATALOG.'includes/extra/modules/wishlist_content/','php') as $file) require ($file);
      
      //products attributes
      if (isset ($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        $attributes_exists = true;
        $subindex = 0;
        reset($products[$i]['attributes']);
        foreach ($products[$i]['attributes'] as $option => $value) {
          $attributes = $main->getAttributes($products[$i]['id'], $option, $value);
          $module_data[$i]['ATTRIBUTES'][$subindex] = array('ID' => $attributes['products_attributes_id'],
                                                            'MODEL' => $attributes['attributes_model'],
                                                            'EAN' => $attributes['attributes_ean'],
                                                            'NAME' => $attributes['products_options_name'],
                                                            'VALUE_NAME' => $attributes['products_options_values_name']
                                                            );
          foreach(auto_include(DIR_FS_CATALOG.'includes/extra/modules/wishlist_content_attributes/','php') as $file) require ($file);
          
          $subindex++;
        }
      }
    }
    
    return array('DATA' => $module_data,
                 'ATTRIBUTES' => $attributes_exists
                 );
  }
?>