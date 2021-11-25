<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_image_submit.inc.php 11608 2019-03-22 09:54:17Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_image_submit.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// The HTML form submit button wrapper function
// Outputs a button in the selected language
  function xtc_image_submit($image, $alt = '', $parameters = '', $useCssButton = true) {
    
    if (basename($image) == $image) {
      $image = ((defined('DIR_WS_BASE')) ? DIR_WS_BASE : '').'templates/'.CURRENT_TEMPLATE.'/buttons/' . $_SESSION['language'] . '/'. $image;
    }
    
    if (function_exists('css_button') && $useCssButton) {
      return css_button($image, $alt, $parameters, true); //function parameters: imagename, alttext, parameters, isSubmitBtn
    }

    $image_submit = '<input type="image" src="' . xtc_parse_input_field_data($image, array('"' => '&quot;')) . '" alt="' . xtc_parse_input_field_data($alt, array('"' => '&quot;')) . '"';

    if (xtc_not_null($alt)) $image_submit .= ' title="' . xtc_parse_input_field_data($alt, array('"' => '&quot;')) . '"';

    if (xtc_not_null($parameters)) $image_submit .= ' ' . $parameters;

    $image_submit .= ' />';

    return $image_submit;
  }
 ?>