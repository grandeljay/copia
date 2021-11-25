<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_discount.php 11583 2019-03-21 10:23:16Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_subtotal.php,v 1.7 2003/02/13); www.oscommerce.com
   (c) 2003	 nextcommerce (ot_discount.php,v 1.11 2003/08/24); www.nextcommerce.org
   (c) 2006 xt:Commerce (ot_discount.php 1277 2005-10-01 ); www.xt-commerce.de

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  class ot_discount {
    var $title, $output;

    function __construct() {
    	global $xtPrice;
    	
      $this->code = 'ot_discount';
      $this->title = MODULE_ORDER_TOTAL_DISCOUNT_TITLE;
      $this->description = MODULE_ORDER_TOTAL_DISCOUNT_DESCRIPTION;
      $this->enabled = ((defined('MODULE_ORDER_TOTAL_DISCOUNT_STATUS') && MODULE_ORDER_TOTAL_DISCOUNT_STATUS == 'true') ? true : false);
      $this->sort_order = ((defined('MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER')) ? MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER : '');
      $this->credit_class = true;
      
      $this->output = array();
    }

    function process() {
      global $order, $xtPrice;

      $this->title = $_SESSION['customers_status']['customers_status_ot_discount'] . ' % ' . MODULE_ORDER_TOTAL_DISCOUNT_TITLE;
      if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' 
          && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00'
          ) 
      {
        $discount_price = $xtPrice->xtcFormat(($xtPrice->xtcFormat($order->info['subtotal'], false) / 100 * $_SESSION['customers_status']['customers_status_ot_discount']), false);
        $this->deduction = $discount_price * (-1);
        
        $order->info['subtotal'] = $order->info['subtotal'] + $this->deduction;
        $order->info['total'] = $order->info['total'] + $this->deduction;

        $this->output[] = array(
            'title' => $this->title . ':',
            'text'  => '<span class="color_ot_total"><b>'.$xtPrice->xtcFormat($this->deduction, true).'</b></span>',
            'value' => $this->deduction
          );
      }
    }
    
    function pre_confirmation_check($order_total) {
      global $order, $xtPrice;
      
      $discount_price = 0;
      
      if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' 
          && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00'
          ) 
      {
        $discount_price = $xtPrice->xtcFormat(($xtPrice->xtcFormat($order->info['subtotal'], false) / 100 * $_SESSION['customers_status']['customers_status_ot_discount']), false);
      }

      return $discount_price;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_DISCOUNT_STATUS'");
        $this->_check = xtc_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array(
        'MODULE_ORDER_TOTAL_DISCOUNT_STATUS',
        'MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER'
      );
    }

    function install() {
      xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_DISCOUNT_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
      xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER', '20', '6', '2', now())");      
    }

    function remove() {
      xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>