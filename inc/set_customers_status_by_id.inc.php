<?php
/* -----------------------------------------------------------------------------------------
   $Id: set_customers_status_by_id.inc.php 12440 2019-12-02 17:54:12Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  function set_customers_status_by_id($customers_status_id) {
    $customers_status_query = xtDBquery("SELECT *
                                           FROM " . TABLE_CUSTOMERS_STATUS . "
                                          WHERE customers_status_id = '" . (int)$customers_status_id . "'
                                            AND language_id = '" . (int)$_SESSION['languages_id'] . "'");
    
    $_SESSION['customers_status'] = xtc_db_fetch_array($customers_status_query, true);
  }
?>