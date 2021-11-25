<?php
/* -----------------------------------------------------------------------------------------
   $Id: secure_form.inc.php 10078 2016-07-15 09:55:42Z GTB $

   modified eCommerce Shopsoftware - community made shopping
   http://www.modified-shop.org

   Copyright (c) 2009 - 2012 modified eCommerce Shopsoftware
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed function
require_once (DIR_FS_INC . 'xtc_create_password.inc.php');

function secure_form() {
  // create CSRF Token
  if (!isset($_SESSION['SFName'])
      || !isset($_SESSION['SFToken'])
      )
  {
    $_SESSION['SFName'] = xtc_RandomString(6);
    $_SESSION['SFToken'] = xtc_RandomString(32);
  }
  
  return xtc_draw_hidden_field($_SESSION['SFName'], $_SESSION['SFToken']);
}

function check_secure_form($params) {
  if (!isset($_SESSION['SFName'])
      || !isset($_SESSION['SFToken'])
      || !isset($params[$_SESSION['SFName']])
      || $params[$_SESSION['SFName']] != $_SESSION['SFToken']
      )
  {
    unset($_SESSION['SFName']);
    unset($_SESSION['SFToken']);
    
    return false;
  }
  unset($_SESSION['SFName']);
  unset($_SESSION['SFToken']);

  return true;
}
?>