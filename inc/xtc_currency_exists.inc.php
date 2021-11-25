<?php

/* -----------------------------------------------------------------------------------------
   $Id: xtc_currency_exists.inc.php 10500 2016-12-14 15:17:45Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_currency_exists.inc.php); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function xtc_currency_exists($code) {
	$param ='/[^a-zA-Z]/';
	$code = preg_replace($param,'',$code);
	$currency_code = xtc_db_query("SELECT code, 
	                                      currencies_id 
	                                 FROM " . TABLE_CURRENCIES . " 
	                                WHERE code = '" . xtc_db_input($code) . "' 
	                                  AND status = '1'
	                                LIMIT 1");
	if (xtc_db_num_rows($currency_code)) {
		$curr = xtc_db_fetch_array($currency_code);
		if ($curr['code'] == $code) {
			return $code;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
?>