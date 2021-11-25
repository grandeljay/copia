<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_update_banner_display_count.inc.php 12532 2020-01-21 16:49:31Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_update_banner_display_count.inc.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  // Update the banner display statistics
  function xtc_update_banner_display_count($banner_id) {
    $banner_check_query = xtc_db_query("SELECT count(*) as count 
                                          FROM " . TABLE_BANNERS_HISTORY . " 
                                         WHERE banners_id = '" . (int)$banner_id . "' 
                                           AND date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");
    $banner_check = xtc_db_fetch_array($banner_check_query);

    if ($banner_check['count'] > 0) {
      xtc_db_query("UPDATE " . TABLE_BANNERS_HISTORY . " 
                       SET banners_shown = banners_shown + 1 
                     WHERE banners_id = '" . (int)$banner_id . "' 
                       AND date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");
    } else {
      $sql_data_array = array(
        'banners_id' => (int)$banner_id,
        'banners_shown' => 1,
        'banners_history_date' => 'now()'
      );
      xtc_db_perform(TABLE_BANNERS_HISTORY, $sql_data_array);
    }
  }
?>