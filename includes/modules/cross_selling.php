<?php
/* -----------------------------------------------------------------------------------------
   $Id: cross_selling.php 13283 2021-02-01 08:49:41Z GTB $ 

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2005 XT-Commerce

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(also_purchased_products.php,v 1.21 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (also_purchased_products.php,v 1.9 2003/08/17); www.nextcommerce.org 
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once (DIR_FS_INC.'get_pictureset_data.inc.php');

$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');

if (ACTIVATE_CROSS_SELLING == 'true') {
  $data = $product->getCrossSells();
  if (count($data) > 0) {
    $module_smarty->assign('language', $_SESSION['language']);
    $module_smarty->assign('module_content', $data);

    if (defined('PICTURESET_BOX')) {
      $module_smarty->assign('pictureset_box', get_pictureset_data(PICTURESET_BOX));
    }
    if (defined('PICTURESET_ROW')) {
      $module_smarty->assign('pictureset_row', get_pictureset_data(PICTURESET_ROW));
    }

    // set cache ID
    $module_smarty->caching = 0;
    $module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/cross_selling.html');
    $info_smarty->assign('MODULE_cross_selling', $module);
  }
}

// reverse cross selling
if (ACTIVATE_REVERSE_CROSS_SELLING == 'true') {
  $data = $product->getReverseCrossSells();	
  if (count($data) > 0) {
    $module_smarty->assign('language', $_SESSION['language']);
    $module_smarty->assign('module_content', $data);
    
    if (defined('PICTURESET_BOX')) {
      $module_smarty->assign('pictureset_box', get_pictureset_data(PICTURESET_BOX));
    }
    if (defined('PICTURESET_ROW')) {
      $module_smarty->assign('pictureset_row', get_pictureset_data(PICTURESET_ROW));
    }

    // set cache ID
    $module_smarty->caching = 0;
    $module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/reverse_cross_selling.html');
    $info_smarty->assign('MODULE_reverse_cross_selling', $module);
  }
}
?>