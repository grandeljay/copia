<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_random_name.inc.php 12438 2019-12-02 15:52:46Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   by Mario Zanier for XTcommerce
   
   based on:
   (c) 2003	 nextcommerce (xtc_random_name.inc.php,v 1.1 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  // include needed functions
  require_once(DIR_FS_INC . 'xtc_rand.inc.php');

  // Returns a random name, 16 to 20 characters long
  // There are more than 10^28 combinations
  // The directory is "hidden", i.e. starts with '.'
  function xtc_random_name() {
    $letters = 'abcdefghijklmnopqrstuvwxyz';
    $dirname = '.';
    $length = floor(xtc_rand(16,20));
    for ($i = 1; $i <= $length; $i++) {
      $q = floor(xtc_rand(0,25));
      $dirname .= $letters[(int)$q];
    }
    return $dirname;
  }
?>