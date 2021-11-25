<?php
/* -----------------------------------------------------------------------------------------
   $Id: clear_string.inc.php 11292 2018-06-15 08:55:59Z GTB $

   modified eCommerce Shopsoftware - community made shopping
   http://www.modified-shop.org

   Copyright (c) 2009 - 2012 modified eCommerce Shopsoftware
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  function clear_string($value) {
    $string = str_replace("'", '', $value);
    $string = str_replace(')', '', $string);
    $string = str_replace('(', '', $string);
    $array = explode(',', $string);
    return $array;
  }
?>