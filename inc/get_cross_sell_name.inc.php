<?php
/* -----------------------------------------------------------------------------------------
   $Id: get_cross_sell_name.inc.php 12439 2019-12-02 17:40:51Z GTB $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2005 XT-Commerce
   -----------------------------------------------------------------------------------------

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
 
  function xtc_get_cross_sell_name($cross_sell_group, $language_id = '') {

    if (!$language_id)
      $language_id = $_SESSION['languages_id'];
    
    $cross_sell_query = xtc_db_query("SELECT groupname 
                                        FROM ".TABLE_PRODUCTS_XSELL_GROUPS." 
                                       WHERE products_xsell_grp_name_id = '".(int)$cross_sell_group."' 
                                         AND language_id = '".(int)$language_id."'");
    $cross_sell = xtc_db_fetch_array($cross_sell_query);

    return $cross_sell['groupname'];
  }
?>