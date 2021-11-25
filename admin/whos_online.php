<?php
/* --------------------------------------------------------------
   $Id: whos_online.php 13259 2021-01-31 10:44:32Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(whos_online.php,v 1.30 2002/11/22); www.oscommerce.com
   (c) 2003 nextcommerce (whos_online.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2006 XT-Commerce (whos_online.php 1133 2005-08-07)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  
  // include needed classes
  require (DIR_FS_CATALOG.DIR_WS_CLASSES.'main.php');
  require (DIR_FS_CATALOG.DIR_WS_CLASSES.'xtcPrice.php');
  
  $page = (isset($_GET['page']) ? (int)$_GET['page'] : 1);

  $whosonline_status_array = array(
    array('id' => '1','text'=> CFG_TXT_YES),
    array('id' => '0','text'=> CFG_TXT_NO)
  );
  
  if (!defined('MODULE_WHOS_ONLINE_STATUS')) {
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_WHOS_ONLINE_STATUS', 'true',  '6', '0', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
    define('MODULE_WHOS_ONLINE_STATUS', 'true');
  }
  
  if (isset($_GET['action']) && $_GET['action'] == 'save') {
    xtc_db_query("TRUNCATE " . TABLE_WHOS_ONLINE);
    xtc_db_query("UPDATE ".TABLE_CONFIGURATION."
                     SET configuration_value = '".(($_POST['whos_online'] == '1') ? 'true' : 'false')."'
                   WHERE configuration_key = 'MODULE_WHOS_ONLINE_STATUS'");
    xtc_redirect(xtc_href_link(basename($PHP_SELF)));
  }

  $main = new main();
  
  //display per page
  $cfg_max_display_results_key = 'MAX_DISPLAY_WHOS_ONLINE_RESULTS';
  $page_max_display_results = xtc_cfg_save_max_display_results($cfg_max_display_results_key);

  $time_last_click = 900;
  if (defined('WHOS_ONLINE_TIME_LAST_CLICK')) {
    $time_last_click = (int)WHOS_ONLINE_TIME_LAST_CLICK;
  }
  $xx_mins_ago = (time() - $time_last_click);

  // remove entries that have expired
  xtc_db_query("DELETE FROM " . TABLE_WHOS_ONLINE . " WHERE time_last_click < '" . $xx_mins_ago . "'");
  
  require (DIR_WS_INCLUDES.'head.php');
?>
</head>
<body">
 <!-- header //-->
  <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
  <!-- header_eof //-->
  <!-- body //-->
  <table class="tableBody">
    <tr>
      <?php //left_navigation
      if (USE_ADMIN_TOP_MENU == 'false') {
        echo '<td class="columnLeft2">'.PHP_EOL;
        echo '<!-- left_navigation //-->'.PHP_EOL;       
        require_once(DIR_WS_INCLUDES . 'column_left.php');
        echo '<!-- left_navigation eof //-->'.PHP_EOL; 
        echo '</td>'.PHP_EOL;      
      }
      ?>
      <!-- body_text //-->
      <td class="boxCenter">
        <div class="pageHeadingImage"><?php echo xtc_image(DIR_WS_ICONS.'heading/icon_content.png'); ?></div>      
        <div class="pageHeading"><?php echo HEADING_TITLE; ?></div>
        <div class="main pdg2 flt-l">Tools</div>
        <div class="smallText flt-l" style="margin: -15px 0 0 120px;">&nbsp;&nbsp;
          <?php
          if (defined('WHOS_ONLINE_TIME_LAST_CLICK_INFO')) {
            echo sprintf(WHOS_ONLINE_TIME_LAST_CLICK_INFO ,$time_last_click);
          }
          ?>
        </div>
        <div class="main pdg2 flt-l" style="margin:5px 0 0 128px;">
          <?php 
          echo xtc_draw_form('whos_online', basename($PHP_SELF), 'action=save', 'post').PHP_EOL;
          echo '<div class="flt-l" style="margin: 10px 0 0">'.PHP_EOL;
          echo TEXT_ACTIVATE_WHOS_ONLINE.PHP_EOL;
          echo '<div class="flt-r" style="margin: -6px 50px 0px 5px">'.PHP_EOL;
          echo draw_on_off_selection('whos_online', $whosonline_status_array, ((MODULE_WHOS_ONLINE_STATUS == 'true') ? true : false)).PHP_EOL;
          echo '<input style="margin-top: -23px;" type="submit" name="go" class="button" onclick="this.blur();" value="' . BUTTON_SAVE . '"/>';
          echo '</div>'.PHP_EOL;
          echo '</div>'.PHP_EOL;
          echo '</form>';
          ?>
        </div>
          
        <table class="tableCenter">
          <tr>
            <td class="boxCenterLeft">
              <table class="tableBoxCenter collapse">
                <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent txta-c"><?php echo TABLE_HEADING_ONLINE; ?></td>
                <td class="dataTableHeadingContent txta-c"><?php echo TABLE_HEADING_CUSTOMER_ID; ?></td>
                <td class="dataTableHeadingContent txta-c"><?php echo TABLE_HEADING_FULL_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_IP_ADDRESS; ?></td>
                <!--td class="dataTableHeadingContent txta-c"><?php //echo TABLE_HEADING_COUNTRY; ?></td-->
                <td class="dataTableHeadingContent txta-c"><?php echo TABLE_HEADING_ENTRY_TIME; ?></td>
                <td class="dataTableHeadingContent txta-c"><?php echo TABLE_HEADING_LAST_CLICK; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LAST_PAGE_URL; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_HTTP_REFERER; ?></td>
              </tr>
              <?php
              $whos_online_query_raw = "SELECT customer_id,
                                               full_name,
                                               ip_address,
                                               time_entry,
                                               time_last_click,
                                               last_page_url,
                                               session_id,
                                               http_referer
                                          FROM " . TABLE_WHOS_ONLINE ."
                                      ORDER BY time_last_click desc";
              $whos_online_split = new splitPageResults($page, $page_max_display_results, $whos_online_query_raw, $whos_online_query_numrows);
              $whos_online_query = xtc_db_query($whos_online_query_raw);                        
              while ($whos_online = xtc_db_fetch_array($whos_online_query)) {
                $time_online = (time() - $whos_online['time_entry']);
                if ((!isset($_GET['info']) || (isset($_GET['info']) && ($_GET['info'] == $whos_online['session_id']))) && !isset($info) ) {
                  $info = array(
                    'session_id' => $whos_online['session_id'],
                    'ip' => $whos_online['ip_address'],
                  );
                }
                if (isset($info) && $whos_online['session_id'] === $info['session_id']) {
                  echo '              <tr class="dataTableRowSelected">' . "\n";
                  } elseif (($whos_online['session_id'] == '') || (substr($whos_online['session_id'],0,1) == '[')) {
                    echo '              <tr class="dataTableRow">' . "\n";
                } else {
                  echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'pointer\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_WHOS_ONLINE, xtc_get_all_get_params(array('info', 'action')) . 'info=' . $whos_online['session_id'], 'NONSSL') . '\'">' . "\n";
                }

                //BOF - DokuMan - 2011-03-16 - added GEOIP-function (show customers country)
                $geoip_data = array();
                //$geoip_response = xtc_get_geoip_data($whos_online['ip_address']);
                //$geoip_data = @unserialize($geoip_response);
                //BOF - DokuMan - 2011-03-16 - added GEOIP-function (show customers country)

                //BOF web28 2010-12-03 added Hostname to whois online
                //$whos_online_hostname = '<div style="font-weight: normal; font-style: italic;"> ('.@gethostbyaddr($whos_online['ip_address']).')</div>';
                //EOF web28 2010-12-03 added Hostname to whois online
                
                // last_page_url
                if (preg_match('/^(.*)' . xtc_session_name() . '=[a-z,0-9]+[&]*(.*)/i', $whos_online['last_page_url'], $array)) {
                  $last_page_url = $array[1] . $array[2];
                } else {
                  $last_page_url = $whos_online['last_page_url'];
                }
                ?>
                <td class="dataTableContent txta-c"><?php echo gmdate('H:i:s', $time_online); ?></td>
                <td class="dataTableContent txta-c"><?php echo $whos_online['customer_id']; ?></td>
                <td class="dataTableContent txta-c"><?php echo $whos_online['full_name']; ?></td>
                <td class="dataTableContent txta-c"><a href="<?php echo WHOS_ONLINE_IP_WHOIS_SERVICE.$whos_online['ip_address']; ?>" style="font-weight:bold; text-decoration:underline;" target="_blank"><?php echo $whos_online['ip_address']; ?></a><?php  echo (isset($whos_online_hostname) ? $whos_online_hostname : ''); ?></td>
                <!--td class="dataTableContent"><?php if (isset($geoip_data['geoplugin_countryName'])) {
                                                                        echo $geoip_data['geoplugin_countryName'].' ('.$geoip_data['geoplugin_countryCode'].')';
                                                                      } ?></td-->
                <td class="dataTableContent txta-c"><?php echo date('H:i:s', $whos_online['time_entry']); ?></td>
                <td class="dataTableContent txta-c"><?php echo date('H:i:s', $whos_online['time_last_click']); ?></td>
                <td class="dataTableContent"><?php echo encode_htmlspecialchars($last_page_url); ?>&nbsp;</td>
                <td class="dataTableContent"><?php echo encode_htmlspecialchars($whos_online['http_referer']); ?></td>
              </tr>
              <?php
                }
              ?>
              </table>
                
              <div class="smallText pdg2 flt-l"><?php echo $whos_online_split->display_count($whos_online_query_numrows, $page_max_display_results, $page, TEXT_DISPLAY_NUMBER_OF_WHOS_ONLINE); ?></div>
              <div class="smallText pdg2 flt-r"><?php echo $whos_online_split->display_links($whos_online_query_numrows, $page_max_display_results, MAX_DISPLAY_PAGE_LINKS, $page); ?></div>
              <?php echo draw_input_per_page($PHP_SELF,$cfg_max_display_results_key,$page_max_display_results); ?>
            </td>
          <?php
          $heading = array();
          $contents = array();
          if (isset($info)) {
            $heading[] = array('text' => '<strong>' . TABLE_HEADING_SHOPPING_CART . '</strong>');
            $session_data = '';
            
            //autoload new session addons 
            require_once(DIR_FS_INC.'auto_include.inc.php');
            foreach(auto_include(DIR_FS_ADMIN.'includes/extra/modules/whos_online/','php') as $file) require ($file);
            
            if (STORE_SESSIONS == 'mysql') {
              $session_data = _sess_read($info['session_id']);
            } elseif (STORE_SESSIONS == '') {
              if ( (file_exists(xtc_session_save_path() . '/sess_' . $info['session_id'])) && (filesize(xtc_session_save_path() . '/sess_' . $info['session_id']) > 0) ) {
                $session_data = file(xtc_session_save_path() . '/sess_' . $info['session_id']);
                $session_data = trim(implode('', $session_data));
              }
            }
            $user_session = unserialize_session_data($session_data);
            
            if (isset($user_session) && $user_session != 'ENCRYPTED' && ($user_session != '' || is_array($user_session))) {
              
              $xtPrice = new xtcPrice($user_session['currency'], $user_session['customers_status']['customers_status_id']);
              
              if (is_array($user_session['cart']->contents)) {  
                $products = $user_session['cart']->get_products();
              }
              //$products = xtc_get_products($user_session);
              for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
                $contents[] = array('align' => 'right','text' => $products[$i]['quantity'] . ' x ' . $products[$i]['name']);
              }
              if (sizeof($products) > 0) {
                $contents[] = array('text' => xtc_draw_separator('pixel_black.gif', '100%', '1'));
                $contents[] = array('align' => 'right', 'text'  => '<span style="nobr">'.TEXT_SHOPPING_CART_SUBTOTAL . ' ' . $xtPrice->xtcFormat($user_session['cart']->total, true). '</span>');
              } else {
                $contents[] = array('text' => TEXT_EMPTY_CART);
              }
            }
            if ($user_session == 'ENCRYPTED') {
              $contents[] = array('text' => TEXT_SESSION_IS_ENCRYPTED);
            }
            $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . xtc_href_link(FILENAME_BLACKLIST_LOGS, 'action=edit&ip='.$info['ip']) . '">'.BUTTON_BLACKLIST.'</a><br/><br/>');
          }
          if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
              echo '            <td class="boxRight" style="min-width:120px">' . "\n";
              $box = new box;
              echo $box->infoBox($heading, $contents);
              echo '            </td>' . "\n";
            }
          ?>
          </tr>
        </table>
      </td>
      <!-- body_text_eof //-->
    </tr>
  </table>
  <!-- body_eof //-->
  <!-- footer //-->
  <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
  <!-- footer_eof //-->
  <br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>