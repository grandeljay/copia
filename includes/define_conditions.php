<?php
/*
   $Id: define_conditions.php 12022 2019-07-27 09:45:22Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]

   Released under the GNU General Public License
*/

// for short lines :)
$customers_status_id = $_SESSION['customers_status']['customers_status_id'];


# CONTENT
########################

# group check
$group_check = GROUP_CHECK == 'true' ? ' AND c1.group_ids LIKE \'%c_'.$customers_status_id.'_group%\' ' : '';
$content_conditions_c1 = $group_check . (isset($content_conditions_c1) ? $content_conditions_c1 : '');
defined('CONTENT_CONDITIONS_C1') OR define('CONTENT_CONDITIONS_C1', $content_conditions_c1);
defined('CONTENT_CONDITIONS') OR define('CONTENT_CONDITIONS', str_replace('c1.', '', $content_conditions_c1));


# PRODUCTS
########################

# fsk18 lock
$fsk_lock = $_SESSION['customers_status']['customers_fsk18_display'] == '0' ? ' AND p.products_fsk18 != 1 ' : '';

# group check
$p_group_check = GROUP_CHECK == 'true' ? ' AND p.group_permission_'.$customers_status_id.' = 1 ' : '';

$products_conditions_p = $fsk_lock . $p_group_check . (isset($products_conditions_p) ? $products_conditions_p : '');
defined('PRODUCTS_CONDITIONS_P') OR define('PRODUCTS_CONDITIONS_P', $products_conditions_p);
defined('PRODUCTS_CONDITIONS') OR define('PRODUCTS_CONDITIONS', str_replace('p.', '', $products_conditions_p));


# CATEGORIES
########################

# group check
$c_group_check = GROUP_CHECK == 'true' ? " AND c.group_permission_".$customers_status_id." = 1 " : "";

$categories_conditions_c = $c_group_check . (isset($categories_conditions_c) ? $categories_conditions_c : '');
defined('CATEGORIES_CONDITIONS_C') OR define('CATEGORIES_CONDITIONS_C', $categories_conditions_c);
defined('CATEGORIES_CONDITIONS') OR define('CATEGORIES_CONDITIONS', str_replace('c.', '', $categories_conditions_c));


# SPECIALS
########################
$specials_conditions_s = " AND s.status = '1' AND (s.start_date <= now() OR s.start_date IS NULL OR s.start_date = 0) AND (s.expires_date >= now() OR s.expires_date IS NULL OR s.expires_date = 0) " . (isset($specials_conditions_s) ? $specials_conditions_s : '');
defined('SPECIALS_CONDITIONS_S') OR define('SPECIALS_CONDITIONS_S', $specials_conditions_s);
defined('SPECIALS_CONDITIONS') OR define('SPECIALS_CONDITIONS', str_replace('s.', '', $specials_conditions_s));
?>