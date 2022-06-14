<?php
/* --------------------------------------------------------------
   $Id: products_attributes_iframe.php 8796 2015-09-11 22:36:20Z web28 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------*/
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

if (!defined('NEW_ATTRIBUTES_IFRAME_FILENAME')) {
  define ('NEW_ATTRIBUTES_IFRAME_FILENAME','new_attributes.php');
}

if (!defined('USE_ATTRIBUTES_IFRAME')) {
  define ('USE_ATTRIBUTES_IFRAME','true');
}

if (is_file(DIR_WS_MODULES.'iframe_box.php')) {
  include_once(DIR_WS_MODULES.'iframe_box.php');
}

if (defined('USE_ATTRIBUTES_IFRAME') && USE_ATTRIBUTES_IFRAME == 'true') {

  function attributes_iframe_link($pID, $icon=false)
  {
    global $icon_padding;
    if ($icon) {
      $link = '<a href="javascript:iframeBox_show('. $pID .', \''.BUTTON_EDIT_ATTRIBUTES.'\' , \''.NEW_ATTRIBUTES_IFRAME_FILENAME.'\',\'&action=edit\');">' . xtc_image(DIR_WS_ICONS . 'icon_edit_attr.gif', BUTTON_EDIT_ATTRIBUTES,'', '', $icon_padding). '</a>';
    } else {
      $link = '<a href="javascript:iframeBox_show('. $pID .', \''.BUTTON_EDIT_ATTRIBUTES.'\' , \''.NEW_ATTRIBUTES_IFRAME_FILENAME.'\',\'&action=edit\');" class="button">'. BUTTON_EDIT_ATTRIBUTES.'</a>';
    }
    return $link;
  }

}