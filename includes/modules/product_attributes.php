<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_attributes.php 12763 2020-05-17 14:29:45Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com
   (c) 2003      nextcommerce (product_info.php,v 1.46 2003/08/25); www.nextcommerce.org
   (c) 2006 xt:Commerce (product_attributes.php 1255 2005-09-28); www.xt-commerce.de

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
   New Attribute Manager v4b                            Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Cross-Sell (X-Sell) Admin 1                          Autor: Joshua Dechant (dreamscape)
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once(DIR_FS_INC.'auto_include.inc.php');
foreach(auto_include(DIR_FS_CATALOG.'includes/extra/modules/products_attributes_top/','php') as $file) require ($file);

if ($product->getAttributesCount() > 0) {

  $attrib_checked_array = array();
  if (strpos($_GET['products_id'], '{') !== false) {
    $attrib_array = preg_split('/[{}]/', $_GET['products_id'], null, PREG_SPLIT_NO_EMPTY);
    array_shift($attrib_array);
    for ($i=0, $n=count($attrib_array); $i<$n; $i+=2) {
      $attrib_checked_array[$attrib_array[$i]] = $attrib_array[$i + 1];
    }
  }
  
  $products_price = $xtPrice->xtcGetPrice($product->data['products_id'], false, 1, $product->data['products_tax_class_id'], $product->data['products_price']);

  $module_smarty = new Smarty;

  $module_smarty->assign('tpl_path',DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');
  
  $products_options_name_query = xtDBquery("SELECT distinct
                                                   ".ADD_PRODUCT_OPTIONS_SELECT."
                                                   popt.products_options_id,
                                                   popt.products_options_name,
                                                   popt.products_options_sortorder
                                              FROM ".TABLE_PRODUCTS_OPTIONS." popt
                                              JOIN ".TABLE_PRODUCTS_ATTRIBUTES." patrib
                                                   ON patrib.options_id = popt.products_options_id
                                                      AND patrib.products_id='".$product->data['products_id']."'
                                             WHERE popt.language_id = '".(int) $_SESSION['languages_id']."'
                                               AND trim(popt.products_options_name) != ''
                                          ORDER BY popt.products_options_sortorder, popt.products_options_id"
                                          );

  $row = 0;

  $products_options_data = array ();

  foreach(auto_include(DIR_FS_CATALOG.'includes/extra/modules/products_attributes_begin/','php') as $file) require ($file);
  
  while ($products_options_name = xtc_db_fetch_array($products_options_name_query,true)) {
    $selected = 0;
    $products_options_array = array ();

    $products_options_data[$row] = array ('NAME' => $products_options_name['products_options_name'],
                                          'ID' => $products_options_name['products_options_id'],
                                          'SORTORDER' => $products_options_name['products_options_sortorder'],  //web28 - 2010-12-14  - add OPTIONS SORTORDER for using in template
                                          'DATA' => array()
                                          );

    $products_options_query = xtDBquery("SELECT pov.products_options_values_id,
                                                pov.products_options_values_name,
                                                pa.*
                                           FROM ".TABLE_PRODUCTS_ATTRIBUTES." pa
                                           JOIN ".TABLE_PRODUCTS_OPTIONS_VALUES." pov
                                                ON pa.options_values_id = pov.products_options_values_id
                                                   AND pov.language_id = '".(int) $_SESSION['languages_id']."'
                                                   AND trim(pov.products_options_values_name) != ''
                                          WHERE pa.products_id = '".$product->data['products_id']."'
                                            AND pa.options_id = '".$products_options_name['products_options_id']."'                                            
                                       ORDER BY pa.sortorder, pov.products_options_values_sortorder, pa.options_values_id
                                        ");
    $col = 0;
    while ($products_options = xtc_db_fetch_array($products_options_query,true)) {
      $price = 0;
      
      $checked = '0';
      if (isset($attrib_checked_array[$products_options_name['products_options_id']])) {
        if ($products_options['products_options_values_id'] == $attrib_checked_array[$products_options_name['products_options_id']]) {
          $checked = '1';
        }
      } elseif ($col == 0) {
        $checked = '1';
      }
      
      if ($_SESSION['customers_status']['customers_status_show_price'] == '0') {
        $products_options_data[$row]['DATA'][$col] = array ('ID' => $products_options['products_options_values_id'],
                                                            'TEXT' => $products_options['products_options_values_name'],
                                                            'MODEL' => $products_options['attributes_model'],
                                                            'PRICE' => '',
                                                            'FULL_PRICE' => '',
                                                            'PLAIN_PRICE' => '',
                                                            'STOCK' => $products_options['attributes_stock'],
                                                            'SORTORDER' => $products_options['sortorder'],
                                                            'PREFIX' => $products_options['price_prefix'],
                                                            'CHECKED' => $checked,
                                                            );
      } else {
        if ($products_options['options_values_price'] != '0.00') {
          $CalculateCurr = ($product->data['products_tax_class_id'] == 0) ? true : false; //FIX several currencies on product attributes
          $price = $xtPrice->xtcFormat($products_options['options_values_price'], false, $product->data['products_tax_class_id'],$CalculateCurr);
        }
                
        // product discount
        if ($_SESSION['customers_status']['customers_status_public'] == '1'
            && $_SESSION['customers_status']['customers_status_discount_attributes'] == 1
            )
        {
          $discount = $xtPrice->xtcCheckDiscount($product->data['products_id']);
          if ($discount != '0.00') {
            $price -= $price / 100 * $discount;
          }
        }

        $attr_price = $price;

        if ($products_options['price_prefix'] == "-") {
          $attr_price = $price*(-1);
        }

        $full = $products_price + $attr_price;

        $products_options_data[$row]['DATA'][$col] = array ('ID' => $products_options['products_options_values_id'],
                                                            'TEXT' => $products_options['products_options_values_name'],
                                                            'MODEL' => $products_options['attributes_model'],
                                                            'PRICE' => $xtPrice->xtcFormat($price, true),
                                                            'FULL_PRICE' => $xtPrice->xtcFormat($full, true),
                                                            'PLAIN_PRICE' => $xtPrice->xtcFormat($price,false),
                                                            'STOCK' => $products_options['attributes_stock'],
                                                            'SORTORDER' => $products_options['sortorder'],
                                                            'PREFIX' => $products_options['price_prefix'],
                                                            'CHECKED' => $checked,
                                                            );

        //if PRICE for option is 0 we don't need to display it
        if ($price == 0) {
          unset ($products_options_data[$row]['DATA'][$col]['PRICE']);
          unset ($products_options_data[$row]['DATA'][$col]['PREFIX']);
        }
        
        foreach(auto_include(DIR_FS_CATALOG.'includes/extra/modules/products_attributes_data/','php') as $file) require ($file);

      }
      $col ++;
    }
    $row ++;
  }


  if ($product->data['options_template'] == '' 
      || $product->data['options_template'] == 'default'
      || !is_file(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/product_options/'.$product->data['options_template'])
      )
  {
    $files = array_filter(auto_include(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/product_options/','html'), function($file) {
      return false === strpos($file, 'index.html');
    });
    $product->data['options_template'] = basename($files[0]);
  }

  $module_smarty->assign('language', $_SESSION['language']);
  $module_smarty->assign('options', $products_options_data);
  
  foreach(auto_include(DIR_FS_CATALOG.'includes/extra/modules/products_attributes_end/','php') as $file) require ($file);

  $module_smarty->caching = 0;
  $module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/product_options/'.$product->data['options_template']);

  $info_smarty->assign('MODULE_product_options_template', $product->data['options_template']);
  $info_smarty->assign('MODULE_product_options', $module);
}

foreach(auto_include(DIR_FS_CATALOG.'includes/extra/modules/products_attributes_bottom/','php') as $file) require ($file);
?>