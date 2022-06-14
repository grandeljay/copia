<?php
/* ----------------------------------------------------------------------------------------------
   $Id: product_navigator.php 10034 2016-07-06 06:51:20Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003 xtCommerce - www.xt-commerce.de
   
   Third Party contributions:
   Produktsortierung nach Voreinstellung der Kategorie - (c) by Hetfield | j_hetfield@hotmail.de
   
   Released under the GNU General Public License
   --------------------------------------------------------------------------------------------*/

$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');

// select products
$sorting_query = xtDBquery("SELECT products_sorting,
                                   products_sorting2 
							                FROM ".TABLE_CATEGORIES."
                             WHERE categories_id='".(int)$current_category_id."'");
$sorting_data = xtc_db_fetch_array($sorting_query,true);

if (!$sorting_data['products_sorting']) {
	$sorting_data['products_sorting'] = 'pd.products_name';
}
$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'];

$products_query = xtDBquery("SELECT p2c.products_id,
                                    pd.products_name
                               FROM ".TABLE_PRODUCTS_TO_CATEGORIES." p2c
                               JOIN ".TABLE_PRODUCTS." p
                                    ON p.products_id = p2c.products_id
                                       AND p.products_status = '1'
                               JOIN ".TABLE_PRODUCTS_DESCRIPTION." pd
                                    ON p.products_id = pd.products_id
                                       AND pd.language_id = '".(int) $_SESSION['languages_id']."'
                                       AND trim(pd.products_name) != ''
                              WHERE p2c.categories_id='".(int)$current_category_id."'
                                    ".PRODUCTS_CONDITIONS_P."
                                    ".$sorting);

$i = 0;
while ($products_data = xtc_db_fetch_array($products_query, true)) {
	$p_data[$i] = array ('pID' => $products_data['products_id'], 'pName' => $products_data['products_name']);
	if ($products_data['products_id'] == $product->data['products_id']) {
		$actual_key = $i;
	}
	$i ++;
}

// first set variables
$first_link = $prev_link = $next_link = $last_link = '';

// check if array key = first
if ($actual_key == 0) {
	// aktuel key = first product
} else {
	$prev_id = $actual_key -1;
	$prev_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[$prev_id]['pID'], $p_data[$prev_id]['pName']));
	// check if prev id = first
	if ($prev_id != 0)
		$first_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[0]['pID'], $p_data[0]['pName']));
}
// check if key = last
if ($actual_key == (count($p_data) - 1)) {
	// actual key is last
} else {
	$next_id = $actual_key +1;
	$next_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[$next_id]['pID'], $p_data[$next_id]['pName']));
	// check if next id = last
	if ($next_id != (count($p_data) - 1))
		$last_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[(count($p_data) - 1)]['pID'], $p_data[(count($p_data) - 1)]['pName']));
}
$overview_link = xtc_href_link(FILENAME_DEFAULT, xtc_category_link($current_category_id));

$module_smarty->assign('FIRST', $first_link);
$module_smarty->assign('PREVIOUS', $prev_link);
$module_smarty->assign('OVERVIEW', $overview_link);
$module_smarty->assign('NEXT', $next_link);
$module_smarty->assign('LAST', $last_link);
$module_smarty->assign('ACTUAL_PRODUCT', $actual_key +1);
$module_smarty->assign('PRODUCTS_COUNT', count($p_data));

$module_smarty->assign('language', $_SESSION['language']);
$module_smarty->caching = 0;
$product_navigator = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/product_navigator.html');
$info_smarty->assign('PRODUCT_NAVIGATOR', $product_navigator);
?>