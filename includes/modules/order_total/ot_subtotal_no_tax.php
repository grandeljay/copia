<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_subtotal_no_tax.php 12070 2019-08-06 16:21:58Z GTB $   

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_subtotal.php,v 1.7 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (ot_subtotal_no_tax.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2006 xt:Commerce; www.xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


  class ot_subtotal_no_tax {

    var $title, $output;

    function __construct() {
    	global $xtPrice;
      $this->code = 'ot_subtotal_no_tax';
      $this->title = MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_TITLE;
      $this->description = MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_DESCRIPTION;
      $this->enabled = ((defined('MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS') && MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS == 'true') ? true : false);
      $this->sort_order = ((defined('MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER')) ? MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER : '');

      $this->output = array();
    }

    function process() {
      global $order, $xtPrice;
      
      // merchant
      if (($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 
           && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1
          ) || ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0
                && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0
                && $order->delivery['country_id'] == STORE_COUNTRY
                )
          ) 
      {
        $this->output[] = array('title' => $this->title . ':',
                                'text' => '<b>'.$xtPrice->xtcFormat($order->info['total'], true).'</b>',
                                'value' => $xtPrice->xtcFormat($order->info['total'], false));
      }
      // default customer
      elseif ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1 
              && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0 
              && $xtPrice->xtcRemoveCurr($order->info['total']) >= $_SESSION['customers_status']['customers_status_show_tax_total']
              ) 
      {
        // calculate notax
        $sub_total_price = $order->info['total']-$order->info['tax'];
        
        $this->output[] = array('title' => $this->title . ':',
                                'text' => '<b>'.$xtPrice->xtcFormat($sub_total_price, true).'</b>',
                                'value' => $xtPrice->xtcFormat($sub_total_price, false));
      }
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS'");
        $this->_check = xtc_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array(
        'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS', 
        'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER'
      );
    }

    function install() {
      xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS', 'true', '6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
      xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER', '40','6', '2', now())");
    }

    function remove() {
      xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>