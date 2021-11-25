<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_validate_password.inc.php 11668 2019-04-01 11:59:59Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(password_funcs.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	nextcommerce (xtc_validate_password.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  // include needed class
  require_once (DIR_FS_CATALOG.'includes/classes/validpass.php');
  
  // This funstion validates a plain text password with an encrpyted password
  function xtc_validate_password($plain, $encrypted, $customers_id = false) {
    if (xtc_not_null($plain) && xtc_not_null($encrypted)) {
      
      $check = xtc_validate_password_collation($plain, $encrypted, $customers_id);
      if ($check === false) {
        $plain = mb_convert_encoding($plain, 'ISO-8859-15', 'UTF-8');
        $check = xtc_validate_password_collation($plain, $encrypted, $customers_id);
      }
      
      return $check;
    }
  }

  function xtc_validate_password_collation($plain, $encrypted, $customers_id) {
    if (xtc_not_null($plain) && xtc_not_null($encrypted)) {

      $password_check = false;
      foreach(auto_include(DIR_FS_CATALOG.'includes/extra/validate_password/','php') as $file) require ($file);
      if ($password_check === true) {
        return true;
      }

      // check for old passwords
      if (preg_match('#^[a-z0-9]{32}$#i', $encrypted)) {
        if ($encrypted != md5($plain)) {
          return false;
        } elseif ($customers_id) {
          // auth is correct, so update to new password hash 
          require_once (DIR_FS_INC . 'xtc_encrypt_password.inc.php');
          xtc_db_query("UPDATE " . TABLE_CUSTOMERS . "
                           SET customers_password = '" . xtc_encrypt_password($plain) . "'
                         WHERE customers_id = '" . (int)$customers_id . "'");
        }
        return true;
      } else {
        // init class
        $validpass = new validpass();
        // validate password
        return $validpass->validate_password($plain, $encrypted);
      }
    }
  }
?>