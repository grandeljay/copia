<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_banner_exists.inc.php 13081 2020-12-15 17:04:30Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_banner_exists.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  require_once(DIR_FS_INC.'xtc_random_select.inc.php');   
  
  function xtc_banner_exists($action, $identifier) {
    if ($action == 'dynamic') {
      return xtc_random_select("SELECT *
                                  FROM " . TABLE_BANNERS . " 
                                 WHERE status = '1' 
                                   AND languages_id = '" . (int)$_SESSION['languages_id'] . "'
                                   AND banners_group = '" . xtc_db_input($identifier) . "'");
    } elseif ($action == 'static') {
      $banner_query = xtc_db_query("SELECT *
                                      FROM " . TABLE_BANNERS . " 
                                     WHERE status = '1' 
                                       AND languages_id = '" . (int)$_SESSION['languages_id'] . "'
                                       AND banners_id = '" . (int)$identifier . "'");
      return xtc_db_fetch_array($banner_query);
    } elseif ($action == 'slider') {
      $banner_query = xtc_db_query("SELECT *
                                      FROM " . TABLE_BANNERS . " 
                                     WHERE status = '1'
                                       AND banners_image != ''
                                       AND languages_id = '" . (int)$_SESSION['languages_id'] . "' 
                                       AND banners_group = '" . xtc_db_input($identifier) . "'
                                  ORDER BY banners_sort ASC");
      if (xtc_db_num_rows($banner_query) > 0) {
        $banner_array = array();
        while ($banner = xtc_db_fetch_array($banner_query)) {
          $banner_array[] = $banner;
        }
        return $banner_array;
      }
    } else {
      return false;
    }
  }
?>