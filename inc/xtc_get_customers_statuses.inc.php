<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_customers_statuses.inc.php 10481 2016-12-07 13:54:15Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_get_customers_statuses.inc.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  // Return all customers statuses for a specified language_id and return an array(array())
  // Use it to make pull_down_menu, checkbox....
  function xtc_get_customers_statuses($use_customers_status_id = false) {

    $customers_statuses_array = array();
    if (!isset($_SESSION['languages_id'])
        || $_SESSION['languages_id'] == ''
        ) 
    {
      $customers_statuses_query = xtc_db_query("SELECT * 
                                                  FROM " . TABLE_CUSTOMERS_STATUS . " 
                                                 WHERE language_id = '1' 
                                              ORDER BY customers_status_id");
    } else {
      $customers_statuses_query = xtc_db_query("SELECT * 
                                                  FROM " . TABLE_CUSTOMERS_STATUS . " 
                                                 WHERE language_id = '" . (int)$_SESSION['languages_id'] . "' 
                                              ORDER BY customers_status_id");
    }
    $index = 0;
    while ($customers_statuses = xtc_db_fetch_array($customers_statuses_query)) {
      $index = $use_customers_status_id ? $customers_statuses['customers_status_id'] : $index;
      $customers_statuses_array[$index] = array(
        'id' => $customers_statuses['customers_status_id'],
        'text' => $customers_statuses['customers_status_name'],
      );      
      foreach ($customers_statuses as $key => $value) {
        $customers_statuses_array[$index][str_replace('customers_status', 'csa', $key)] = $value;
      }
      $index++;
    }
    
    return $customers_statuses_array;
  }
 ?>