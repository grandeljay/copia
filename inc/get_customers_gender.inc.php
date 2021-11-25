<?php
/* -----------------------------------------------------------------------------------------
   $Id: get_customers_gender.inc.php 13120 2021-01-06 08:23:53Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


function get_customers_gender($id=false) 
{
  $gender_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT),
                        array('id' => 'm', 'text' => MALE),
                        array('id' => 'f', 'text' => FEMALE),
                        array('id' => 'd', 'text' => DIVERSE),
                        );
  if ($id === false) {
    return $gender_array;
  } else {
    for ($i=0, $n=count($gender_array); $i<$n; $i++) {
      if ($gender_array[$i]['id'] == $id && $id != '') {
        return $gender_array[$i]['text'];
      }
    }
  }
  
  return '';
}
?>