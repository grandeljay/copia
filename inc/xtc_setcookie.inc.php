<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_setcookie.inc.php 10020 2016-06-30 10:58:24Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_setcookie.inc.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  function xtc_setcookie($name, $value = '', $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false) {
    setcookie($name, $value, $expire, $path, (xtc_not_null($domain) ? $domain : ''), $secure, $httponly);
  }
?>