<?php
/* -----------------------------------------------------------------------------------------
   $Id$

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
  
  if ((isset($admin_access['shipcloud_pickup']) && $admin_access['shipcloud_pickup'] == '1')
      && (isset($admin_access['shipcloud']) && $admin_access['shipcloud'] == '1')
      )
  {      
    echo '<li><a href="' . xtc_href_link(FILENAME_SHIPCLOUD) . '" class="menuBoxContentLinkSub"> -' . BOX_SHIPCLOUD . '</a><ul>';
    echo '<li><a href="' . xtc_href_link('shipcloud_pickup.php', '') . '" class="menuBoxContentLink"> -' . BOX_SHIPCLOUD_PICKUP . '</a></li>';
    echo '  </ul></li>';
  } elseif (isset($admin_access['shipcloud']) && $admin_access['shipcloud'] == '1') {
    echo '<li><a href="' . xtc_href_link(FILENAME_SHIPCLOUD, '') . '" class="menuBoxContentLink"> -' . BOX_SHIPCLOUD . '</a></li>';
  }
?>