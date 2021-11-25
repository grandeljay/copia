<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_check_gzip.inc.php 11990 2019-07-23 06:53:35Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(gzip_compression.php,v 1.3 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_check_gzip.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function xtc_check_gzip() {
    if (headers_sent() || connection_aborted()) {
      return false;
    }

    $encoding = '';
    if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
      $encoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
    }
    
    if (strpos($encoding, 'x-gzip') !== false) return 'x-gzip';
    if (strpos($encoding,'gzip') !== false) return 'gzip';

    return false;
  } 
?>