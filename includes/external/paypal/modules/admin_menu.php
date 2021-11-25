<?php
/* -----------------------------------------------------------------------------------------
   $Id: admin_menu.php 11028 2017-12-07 08:12:10Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
  
  ?>
  <div class="clear configPartner cf" style="border-bottom: none;">
  <?php
    if (isset($admin_access['paypal_info']) && $admin_access['paypal_info'] == '1') echo '<a class="configtab'.(((basename($PHP_SELF) == 'paypal_info.php') ? ' activ' : '') ? ' activ' : '').'" href="'.xtc_href_link('paypal_info.php', '', 'NONSSL').'">'.TEXT_PAYPAL_TAB_INFO.'</a>';
    if (isset($admin_access['paypal_module']) && $admin_access['paypal_module'] == '1') echo '<a class="configtab'.(((basename($PHP_SELF) == 'paypal_module.php') ? ' activ' : '') ? ' activ' : '').'" href="'.xtc_href_link('paypal_module.php', '', 'NONSSL').'">'.TEXT_PAYPAL_TAB_MODULE.'</a>';
    if (isset($admin_access['paypal_config']) && $admin_access['paypal_config'] == '1') echo '<a class="configtab'.((basename($PHP_SELF) == 'paypal_config.php') ? ' activ' : '').'" href="'.xtc_href_link('paypal_config.php', '', 'NONSSL').'">'.TEXT_PAYPAL_TAB_CONFIG.'</a>';
    if (isset($admin_access['paypal_profile']) && $admin_access['paypal_profile'] == '1') echo '<a class="configtab'.(((basename($PHP_SELF) == 'paypal_profile.php') ? ' activ' : '') ? ' activ' : '').'" href="'.xtc_href_link('paypal_profile.php', '', 'NONSSL').'">'.TEXT_PAYPAL_TAB_PROFILE.'</a>';
    if (isset($admin_access['paypal_webhook']) && $admin_access['paypal_webhook'] == '1') echo '<a class="configtab'.(((basename($PHP_SELF) == 'paypal_webhook.php') ? ' activ' : '') ? ' activ' : '').'" href="'.xtc_href_link('paypal_webhook.php', '', 'NONSSL').'">'.TEXT_PAYPAL_TAB_WEBHOOK.'</a>';
  ?>
  </div>