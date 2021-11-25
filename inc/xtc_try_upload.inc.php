<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_try_upload.inc.php 11292 2018-06-15 08:55:59Z GTB $

   modified eCommerce Shopsoftware - community made shopping
   http://www.modified-shop.org

   Copyright (c) 2009 - 2012 modified eCommerce Shopsoftware
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  function xtc_try_upload($file = '', $destination = '', $permissions = '644', $extensions = '', $mime_types = '') {
    $file_object = new upload($file, $destination, $permissions, $extensions, $mime_types);
    if ($file_object->filename != '') {
      return $file_object;
    } else {
      return false;
    }
  }
?>