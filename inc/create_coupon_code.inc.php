<?php
/* -----------------------------------------------------------------------------------------
   $Id: create_coupon_code.inc.php 12438 2019-12-02 15:52:46Z GTB $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
   (c) 2003     nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// Create a Coupon Code. length may be between 1 and 16 Characters
// $salt needs some thought.

  // include needed functions
  require_once(DIR_FS_INC . 'xtc_rand.inc.php');

  function create_coupon_code($salt = "secret", $length = SECURITY_CODE_LENGTH) {
    $ccid = md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));

    $random_start = xtc_rand(0, (128-$length));
    
    $good_result = 0;
    while ($good_result == 0) {
      $id1 = substr($ccid, $random_start, $length);
      $query = xtc_db_query("SELECT coupon_code 
                               FROM " . TABLE_COUPONS . " 
                              WHERE coupon_code = '" . xtc_db_input($id1) . "'");
      if (xtc_db_num_rows($query) == 0) $good_result = 1;
    }
    return $id1;
  }
?>