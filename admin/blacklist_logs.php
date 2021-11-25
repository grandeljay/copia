<?php
  /* --------------------------------------------------------------
   $Id: blacklist_logs.php 10842 2017-07-12 12:44:37Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------*/
  
  require('includes/application_top.php');
  require_once(DIR_FS_CATALOG.'includes/xss_secure.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if (xtc_not_null($action)) {
    switch ($action) {
      case 'deleteconfirm':
        $contents_array = xss_read_blacklist();
        unset($contents_array[$_GET['ip']]);
        xss_write_blacklist($contents_array);
        xtc_redirect(xtc_href_link(FILENAME_BLACKLIST_LOGS));
        break;

      case 'insert':
        $blacklist_ip = xtc_db_prepare_input($_POST['blacklist_ip']);
        $blacklist_time = strtotime($_POST['blacklist_time']) - XSS_BLACKLIST_TIME;
        if ($blacklist_ip != '' && $blacklist_time > 0) {
          $contents_array = xss_read_blacklist();
          $contents_array[$blacklist_ip] = $blacklist_time;
          xss_write_blacklist($contents_array);
          xtc_redirect(xtc_href_link(FILENAME_BLACKLIST_LOGS, 'ip='.$blacklist_ip));
        }
        xtc_redirect(xtc_href_link(FILENAME_BLACKLIST_LOGS));
        break;
    }
  }

  // check if the backup directory exists
  $dir_ok = false;
  if (is_dir(DIR_FS_LOG)) {
    $dir_ok = true;
    if (!is_writeable(DIR_FS_LOG)) {
      $messageStack->add(ERROR_LOG_DIRECTORY_NOT_WRITEABLE, 'error');
    }
  } else {
    $messageStack->add(ERROR_LOG_DIRECTORY_DOES_NOT_EXIST, 'error');
  }

  require (DIR_WS_INCLUDES.'head.php');
?>  
  <link type="text/css" href="includes/javascript/jQueryDateTimePicker/jquery.datetimepicker.css" rel="stylesheet" />
  <script type="text/javascript" src="includes/javascript/jQueryDateTimePicker/jquery.datetimepicker.full.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $.datetimepicker.setLocale('<?php echo $_SESSION["language_code"]; ?>');
      $('#Datepicker1').datetimepicker({format:'Y-m-d H:i'});
    });
  </script>
</head>

<body>
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
          <div class="pageHeading pdg2 flt-l">
            <?php echo HEADING_TITLE; ?><br />
            <div class="main pdg2 flt-l">Tools</div>
          </div>
        <div>
          <?php 
            echo '<a class="button" style="margin-left:100px;" href="' . xtc_href_link(FILENAME_BLACKLIST_LOGS, 'action=new') . '">'.BUTTON_INSERT.'</a>';
          ?>
        </div>
          <table class="tableCenter">
            <tr>
              <td class="boxCenterLeft">
                <table class="tableBoxCenter collapse">
                  <?php
                    if ($dir_ok) {
                      $contents_array = xss_read_blacklist();
                      if (count($contents_array) > 0) {
                        ?>
                        <tr class="dataTableHeadingRow">
                          <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_IP; ?></td>
                          <td class="dataTableHeadingContent txta-c"><?php echo TABLE_HEADING_BANNED; ?></td>
                          <td class="dataTableHeadingContent txta-r"><?php echo TABLE_HEADING_ACTION; ?></td>
                        </tr>
                        <?php

                        foreach ($contents_array as $ip => $time) {
                          $time += XSS_BLACKLIST_TIME;
                          $entry = $ip;
                          $orders_action_image = '<a href="' . xtc_href_link(FILENAME_BLACKLIST_LOGS, 'ip=' . $ip) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_arrow_grey.gif', IMAGE_ICON_INFO) . '</a>';
                          if ((!isset($_GET['ip']) || ($_GET['ip'] == $ip)) && !isset($buInfo)) {
                            $file_array = array(
                              'ip' => $ip,
                              'time' => $time
                            );
                            $buInfo = new objectInfo($file_array);
                            $orders_action_image = xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ICON_EDIT);
                          }
                          if (isset($buInfo) && is_object($buInfo) && ($ip == $buInfo->ip)) {
                            echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'pointer\'">' . "\n";
                          } else {
                            echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'pointer\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\''.xtc_href_link(FILENAME_BLACKLIST_LOGS, 'ip='.$ip).'\'">' . "\n";
                          }
                          ?>
                            <td class="dataTableContent"><?php echo $ip; ?></td>
                            <td class="dataTableContent txta-c"><?php echo xtc_datetime_short(date('Y-m-d H:i:s', $time)); ?></td>
                            <td class="dataTableContent txta-r"><?php echo $orders_action_image; ?></td>
                          </tr>
                          <?php
                        }
                      } else {
                        ?>
                        <tr class="dataTableHeadingRow">
                          <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_IP; ?></td>
                          <td class="dataTableHeadingContent txta-c"><?php echo TABLE_HEADING_BANNED; ?></td>
                          <td class="dataTableHeadingContent txta-r"><?php echo TABLE_HEADING_ACTION; ?></td>
                        </tr>
                        <?php
                      }
                    }
                  ?>
                </table>
              </td>
              <?php
                $heading = array();
                $contents = array();
                switch ($action) {
                  case 'delete':
                    $heading[] = array('text' => '<b>' . $buInfo->ip . '</b>');
                    $contents = array('form' => xtc_draw_form('delete', FILENAME_BLACKLIST_LOGS, 'ip=' . $buInfo->ip . '&action=deleteconfirm'));
                    $contents[] = array('text' => TEXT_DELETE_INTRO);
                    $contents[] = array('text' => '<br /><b>' . $buInfo->ip . '</b>');
                    $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onclick="this.blur();" value="' . BUTTON_DELETE . '"/> <a class="button" onclick="this.blur();" href="' . xtc_href_link(FILENAME_BLACKLIST_LOGS, 'ip=' . $buInfo->ip) . '">' . BUTTON_CANCEL . '</a><br/><br/>');
                    break;

                  case 'new':
                    $heading[] = array('text' => '<b>' . TEXT_NEW_ENTRY . '</b>');
                    $contents = array('form' => xtc_draw_form('insert', FILENAME_BLACKLIST_LOGS, 'action=insert'));
                    $contents[] = array('text' => '<br /><b>' . TEXT_ENTRY_IP . '</b><br />' . TEXT_ENTRY_IP_INFO . '<br />' . xtc_draw_input_field('blacklist_ip', ''));
                    $contents[] = array('text' => '<br /><b>' . TEXT_ENTRY_TIME . '</b><br />' . TEXT_ENTRY_TIME_INFO . '<br />' . xtc_draw_input_field('blacklist_time', '', 'id="Datepicker1"'));
                    $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onclick="this.blur();" value="' . BUTTON_SAVE . '"/> <a class="button" onclick="this.blur();" href="' . xtc_href_link(FILENAME_BLACKLIST_LOGS) . '">' . BUTTON_CANCEL . '</a><br/><br/>');
                    break;

                  case 'edit':
                    $heading[] = array('text' => '<b>' . TEXT_EDIT_ENTRY . '</b>');
                    $contents = array('form' => xtc_draw_form('insert', FILENAME_BLACKLIST_LOGS, 'action=insert'));
                    $contents[] = array('text' => '<br /><b>' . TEXT_ENTRY_IP . '</b><br />' . TEXT_ENTRY_IP_INFO . '<br />' . xtc_draw_input_field('blacklist_ip', preg_replace('/[^0-9a-zA-Z:\.]/', '', ((isset($buInfo->ip)) ? $buInfo->ip : $_GET['ip']))));
                    $contents[] = array('text' => '<br /><b>' . TEXT_ENTRY_TIME . '</b><br />' . TEXT_ENTRY_TIME_INFO . '<br />' . xtc_draw_input_field('blacklist_time', date('Y-m-d H:i', ((isset($buInfo->time)) ? $buInfo->time : time())), 'id="Datepicker1"'));
                    $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onclick="this.blur();" value="' . BUTTON_SAVE . '"/> <a class="button" onclick="this.blur();" href="' . xtc_href_link(FILENAME_BLACKLIST_LOGS) . '">' . BUTTON_CANCEL . '</a><br/><br/>');
                    break;
                  
                  default:
                    if (isset($buInfo) && is_object($buInfo)) {
                      $heading[] = array('text' => '<b>' . $buInfo->ip . '</b>');
                      $contents[] = array('align' => 'center', 'text' => '<a class="button" onclick="this.blur();" href="' . xtc_href_link(FILENAME_BLACKLIST_LOGS, 'action=edit&ip='.$buInfo->ip) . '">' . BUTTON_EDIT . '</a> <a class="button" onclick="this.blur();" href="' . xtc_href_link(FILENAME_BLACKLIST_LOGS, 'ip=' . $buInfo->ip . '&action=delete') . '">' . BUTTON_DELETE . '</a><br/><br/>');
                    }
                    break;
                }
                if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
                  echo '            <td class="boxRight">' . "\n";
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