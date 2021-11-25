<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_create_password.inc.php 12438 2019-12-02 15:52:46Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003 XT-Commerce
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


  // include needed functions
  require_once(DIR_FS_INC . 'xtc_rand.inc.php');

  function xtc_RandomString($length) {
    $chars = array( 'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n','N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v','V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

    $max_chars = count($chars) - 1;

    $rand_str = '';
    for($i=0;$i<$length;$i++) {
     $rand_str = ( $i == 0 ) ? $chars[xtc_rand(0, $max_chars)] : $rand_str . $chars[xtc_rand(0, $max_chars)];
    }
    return $rand_str;
  }


  function xtc_create_password($length) {

    // include needed function
    require_once (DIR_FS_INC.'xtc_encrypt_password.inc.php');
    
    $password = xtc_RandomString($length);
    return xtc_encrypt_password($password);
  }
?>