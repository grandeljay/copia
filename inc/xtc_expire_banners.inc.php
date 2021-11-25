<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_expire_banners.inc.php 13081 2020-12-15 17:04:30Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_expire_banners.inc.php,v 1.5 2003/08/1); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  require_once(DIR_FS_INC . 'xtc_set_banner_status.inc.php');
   
  // Auto expire banners
  function xtc_expire_banners() {
    $banners_query = xtc_db_query("SELECT b.banners_group_id, 
                                          b.expires_date, 
                                          b.expires_impressions, 
                                          sum(bh.banners_shown) as banners_shown 
                                     FROM " . TABLE_BANNERS . " b
                                     JOIN " . TABLE_BANNERS_HISTORY . " bh 
                                          ON b.banners_id = bh.banners_id
                                    WHERE b.status = '1'
                                 GROUP BY b.banners_id");
    if (xtc_db_num_rows($banners_query)) {
      while ($banners = xtc_db_fetch_array($banners_query)) {
        if (xtc_not_null($banners['expires_date'])) {
          if (date('Y-m-d H:i:s') >= $banners['expires_date']) {
            xtc_set_banner_status($banners['banners_group_id'], '0');
          }
        }
        if (xtc_not_null($banners['expires_impressions'])) {
          if ($banners['banners_shown'] >= $banners['expires_impressions']) {
            xtc_set_banner_status($banners['banners_group_id'], '0');
          }
        }
      }
    }
  }
?>