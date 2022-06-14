<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_update_whos_online.inc.php 3952 2012-11-15 00:20:51Z Tomcraft1980 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(whos_online.php,v 1.8 2003/02/21); www.oscommerce.com
   (c) 2003 nextcommerce (xtc_update_whos_online.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2006 XT-Commerce (xtc_update_whos_online.inc.php 899 2005-04-29)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  function xtc_update_whos_online() {

    $crawler = 0; 
    if (isset($_SESSION['customer_id'])) {
      $wo_customer_id = (int)$_SESSION['customer_id'];

      $customer_query = xtc_db_query("SELECT customers_firstname,
                                             customers_lastname
                                        FROM " . TABLE_CUSTOMERS . "
                                       WHERE customers_id = '" . (int)$wo_customer_id . "'");
      $customer = xtc_db_fetch_array($customer_query);

      $wo_full_name = xtc_db_prepare_input($customer['customers_firstname'] . ' ' . $customer['customers_lastname']);
    } else {
      $wo_customer_id = '';
      $crawler = xtc_check_agent();
      if ($crawler !== 0) {
        $wo_full_name = '['.TEXT_SEARCH_ENGINE_AGENT.']';
      } else {
        $wo_full_name = TEXT_GUEST;
      }
    }

    if ($crawler !== 0) {
      $wo_session_id = '';
    } else {
      $wo_session_id = xtc_session_id();
    }

    // include needed functions
    require_once (DIR_FS_INC.'ip_clearing.inc.php');
    $wo_ip_address = xtc_db_prepare_input(ip_clearing($_SESSION['tracking']['ip']));
    $wo_last_page_url = xtc_db_prepare_input(strip_tags($_SERVER['REQUEST_URI']));
    $wo_referer = xtc_db_prepare_input(isset($_SERVER['HTTP_REFERER']) ? strip_tags($_SERVER['HTTP_REFERER']) : '---');

    $current_time = time();
    $time_last_click = 900;
    if (defined('WHOS_ONLINE_TIME_LAST_CLICK')) {
      $time_last_click = (int)WHOS_ONLINE_TIME_LAST_CLICK;
    }
    $xx_mins_ago = (time() - $time_last_click);

    // remove entries that have expired
    xtc_db_query("DELETE FROM " . TABLE_WHOS_ONLINE . " WHERE time_last_click < '" . $xx_mins_ago . "'");

    xtc_db_query("INSERT INTO " . TABLE_WHOS_ONLINE . " (customer_id, full_name, session_id, time_entry, ip_address, time_last_click, last_page_url, http_referer)
                       VALUES ('". (int)$wo_customer_id ."', '".xtc_db_input($wo_full_name)."', '".xtc_db_input($wo_session_id)."', '".xtc_db_input($current_time)."', '".xtc_db_input($wo_ip_address)."', '".xtc_db_input($current_time)."', '".xtc_db_input($wo_last_page_url)."', '".xtc_db_input($wo_referer)."')
                       ON DUPLICATE KEY UPDATE customer_id = '".(int)$wo_customer_id."', full_name = '".xtc_db_input($wo_full_name)."', ip_address = '".xtc_db_input($wo_ip_address)."', time_last_click = '".xtc_db_input($current_time)."', last_page_url = '".xtc_db_input($wo_last_page_url)."'");

  }
?>