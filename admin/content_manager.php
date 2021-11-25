<?php
  /* --------------------------------------------------------------
   $Id: content_manager.php 13482 2021-04-01 08:41:11Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com
   (c) 2003 nextcommerce (content_manager.php,v 1.18 2003/08/25); www.nextcommerce.org
   (c) 2006 XT-Commerce (content_manager.php 1304 2005-10-12)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'xtc_format_filesize.inc.php');
  require_once(DIR_FS_INC . 'xtc_filesize.inc.php');
  require_once(DIR_FS_INC . 'xtc_wysiwyg.inc.php');
  require_once(DIR_FS_INC . 'xtc_href_link_from_admin.inc.php');

  if(!defined('CONTENT_CHILDS_ACTIV')) {
    define('CONTENT_CHILDS_ACTIV','true');
  }
  
  $set = (isset($_GET['set']) ? $_GET['set'] : '');
  $setparam = !empty($set) ? '&set='.$set : '';
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $special = (isset($_GET['special']) ? $_GET['special'] : '');
  $id = (isset($_GET['id']) ? $_GET['id'] : '');
  $g_coID = (isset($_GET['coID']) ? (int)$_GET['coID'] : '');
  $coIndex = (isset($_GET['coIndex']) ? (int)$_GET['coIndex'] : '');
  $languages = xtc_get_languages();

  if ($special != '') {
    switch ($special) {
      case 'delete':
        $paramas = '';
        xtc_db_query("DELETE FROM ".TABLE_CONTENT_MANAGER." WHERE content_group='".$g_coID."' AND content_group_index='".$coIndex."'");
        break;
    
      case 'delete_product':
        $paramas = 'pID='.(int)$_GET['pID'];
        xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_CONTENT." where content_id='".$g_coID."'");
        break;

      case 'delete_content':
        $paramas = 'cID='.(int)$_GET['cID'];
        xtc_db_query("DELETE FROM ".TABLE_CONTENT_MANAGER_CONTENT." where content_id='".$g_coID."'");
        break;

      case 'delete_email':
        $paramas = 'eID='.$_GET['eID'];
        xtc_db_query("DELETE FROM ".TABLE_EMAIL_CONTENT." where content_id='".$g_coID."'");
        break;
    }
    
    foreach(auto_include(DIR_FS_ADMIN.'includes/extra/modules/content_manager/action/','php') as $file) require ($file);

    if (isset($_GET['cPath'])) {
      xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('special', 'last_action', 'action', 'coID', 'coIndex')) . 'action='.$_GET['last_action']));
    } else {
      xtc_redirect(xtc_href_link(FILENAME_CONTENT_MANAGER, $paramas.$setparam));
    }
  }
  
  if (empty($action) && isset($_GET['cPath'])) {
    xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('special', 'last_action', 'action', 'coID', 'coIndex', 'search')) . 'action='.$_GET['last_action']));
  }

  if ($id == 'update' || $id == 'insert') {    
    foreach ($_POST as $key => $value) {
      if (!isset(${$key}) || !is_object(${$key})) {
        if (is_array($value)) {
          ${$key} = array_map('xtc_db_prepare_input', $value);
        } else {
          ${$key} = xtc_db_prepare_input($value);
        }
      }
    }

    $content_meta_robots = implode(', ', ((isset($content_meta_robots) && is_array($content_meta_robots)) ? $content_meta_robots : array()));    
    if (isset($parent_check) && $parent_check == 'yes') {                                     
      $parent_query = xtc_db_query("SELECT c2.content_id,
                                           c2.languages_id
                                      FROM ".TABLE_CONTENT_MANAGER." c1
                                      JOIN ".TABLE_CONTENT_MANAGER." c2
                                           ON c1.content_group = c2.content_group
                                     WHERE c1.content_id = '".(int)$parent_id."'
                                     ");
      $parent_id = array();
      while ($parent = xtc_db_fetch_array($parent_query)) {
        $parent_id[$parent['languages_id']] = $parent['content_id'];
      }
    }

    if ($content_group == '0' || $content_group == '') {
      $content_query = xtc_db_query("SELECT MAX(content_group) AS content_group FROM ".TABLE_CONTENT_MANAGER);
      $content_data = xtc_db_fetch_row($content_query);
      $content_group = $content_data[0] + 1;
    }

    $sql_data_array = array(
      'content_group' => (int)$content_group,
      'sort_order' => $sort_order,
      'file_flag' => $file_flag,
      'content_meta_robots' => $content_meta_robots,
    );

    
    for ($i=0; $i<$content_count; $i++) {
      for ($l=0, $ln=count($languages); $l<$ln; $l++) {
        $error = false;
        /*
        if (strlen($content_title[$i][$languages[$l]['id']]) < 1) {
          $error = true;
          $messageStack->add_session(strtoupper($languages[$l]['name']).': '.ERROR_TITLE, 'error');
        }
        */
        if ($error === false) {
          $content_file_name = '';
          if ($select_file[$i][$languages[$l]['id']] != 'default') {
            $content_file_name = $select_file[$i][$languages[$l]['id']];
          }
          $accepted_file_upload_files_extensions = array("htm","html","txt");
          $accepted_file_upload_files_mime_types = array("text/html","text/html","text/plain");
          if ($content_file = xtc_try_upload('file_upload_'.$i.'_'.$languages[$l]['id'], DIR_FS_CATALOG.'media/content/', '644', $accepted_file_upload_files_extensions, $accepted_file_upload_files_mime_types)) {
            $content_file_name = $content_file->filename;
          }

          // set allowed c.groups
          $group_ids = '';
          if (isset($groups[$i][$languages[$l]['id']])) {
            foreach($groups[$i][$languages[$l]['id']] as $b) {
              $group_ids .= 'c_'.$b."_group,";
            }
          }
          $customers_statuses_array = xtc_get_customers_statuses();
          if (strpos($group_ids,'c_all_group')) {
            $group_ids = 'c_all_group,';
            for ($g=0, $x=count($customers_statuses_array); $g<$x; $g++) {
              $group_ids .= 'c_'.$customers_statuses_array[$g]['id'].'_group,';
            }
          }

          $sql_data_lang_array = array(
            'content_status' => (int)$content_status[$i][$languages[$l]['id']],
            'content_active' => (int)$content_active[$i][$languages[$l]['id']],
            'languages_id' => $languages[$l]['id'],
            'parent_id' => ((isset($parent_id) && is_array($parent_id) && array_key_exists($languages[$l]['id'], $parent_id)) ? $parent_id[$languages[$l]['id']] : ''),
            'group_ids' => $group_ids,
            'content_title' => $content_title[$i][$languages[$l]['id']],
            'content_heading' => $content_heading[$i][$languages[$l]['id']],
            'content_text' => $content_text[$i][$languages[$l]['id']],
            'content_meta_title' => $content_meta_title[$i][$languages[$l]['id']],
            'content_meta_description' => $content_meta_description[$i][$languages[$l]['id']],
            'content_meta_keywords' => $content_meta_keywords[$i][$languages[$l]['id']],
            'content_file' => $content_file_name
          );
        
          // check content_group_index 
          $add_and = '';          
          if ($id == 'update' && $content_id[$i][$languages[$l]['id']] > 0) {
            $add_and = " AND content_id != '" . $content_id[$i][$languages[$l]['id']] ."'";
          }          
          $dbQuery = xtc_db_query("SELECT MAX(content_group_index)
                                     FROM ".TABLE_CONTENT_MANAGER."
                                    WHERE languages_id ='" . $sql_data_lang_array['languages_id'] . "'
                                          ".$add_and."
                                      AND content_group ='" . $sql_data_array['content_group'] . "'");
                                                     
          //check change content_group
          $change_content_group = (isset($coID) && $coID != $content_group) ? true : false;    
          $dbData = xtc_db_fetch_row($dbQuery);
          if (!is_null($dbData[0])) { 
            $sql_data_array['content_group_index'] = $dbData[0] + 1;
            if ($id == 'update' && !  $change_content_group) {
              $sql_data_array['content_group_index'] = $content_group_index;
            }
            $content_group_index = $sql_data_array['content_group_index'];
          } else {
            $sql_data_array['content_group_index'] = 0;
          }
          
          if (isset($content_new_group_index[$i][$languages[$l]['id']])) {
            $sql_data_array['content_group_index'] = (int)$content_new_group_index[$i][$languages[$l]['id']];
          }
          
          if ($id == 'update' && $content_id[$i][$languages[$l]['id']] > 0) {
            $sql_data_array['last_modified'] = 'now()';
            xtc_db_perform(TABLE_CONTENT_MANAGER, array_merge($sql_data_array, $sql_data_lang_array), 'update', "content_id = '".$content_id[$i][$languages[$l]['id']]."'");
          } else {
            $sql_data_array['date_added'] = 'now()';
            xtc_db_perform(TABLE_CONTENT_MANAGER, array_merge($sql_data_array, $sql_data_lang_array));
          }
        }
      }
    }

    foreach(auto_include(DIR_FS_ADMIN.'includes/extra/modules/content_manager/action/','php') as $file) require ($file);

    if (isset($page_update)) {
      $setparam = 'action=edit&coID='.$content_group.'&coIndex='.$sql_data_array['content_group_index'];
    }
    if ($error === true) {
      $setparam = 'action=edit&coID='.(($g_coID != '') ? $g_coID : $content_group);
    }
    xtc_redirect(xtc_href_link(FILENAME_CONTENT_MANAGER, $setparam));
  }

  
  $action_id = array(
    'update_products',
    'insert_products',
    'update_content_manager',
    'insert_content_manager',
    'update_email',
    'insert_email',
  );
  
  if (in_array($id, $action_id)) {
    $action_array = explode('_', $id);
    $subaction = array_shift($action_array);
    
    $type = $path = implode('_', $action_array);
    if ($type == 'content_manager' || $type == 'email') {
      $path = 'content';
    }
    $table = constant('TABLE_'.strtoupper($type).'_CONTENT');
        
    // set allowed c.groups
    $group_ids = '';
    if(isset($_POST['groups']) && is_array($_POST['groups']))  {
      foreach($_POST['groups'] as $b){
        $group_ids .= 'c_'.$b."_group,";
      }
    }
    $customers_statuses_array=xtc_get_customers_statuses();
    if (strpos($group_ids,'c_all_group')) {
      $group_ids = 'c_all_group,';
      for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
        $group_ids .= 'c_'.$customers_statuses_array[$i]['id'].'_group,';
     }
    }

    $content_title = xtc_db_prepare_input($_POST['cont_title']);
    $content_link = ((isset($_POST['cont_link'])) ? xtc_db_prepare_input($_POST['cont_link']) : '');
    $content_language_code = xtc_db_prepare_input($_POST['language_code']);
    $product = xtc_db_prepare_input($_POST['product']);
    $file_comment = ((isset($_POST['file_comment'])) ? xtc_db_prepare_input($_POST['file_comment']) : '');
    $select_file = xtc_db_prepare_input($_POST['select_file']);
    $filename = ((isset($_POST['file_name'])) ? xtc_db_prepare_input($_POST['file_name']) : '');

    $error = false;
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
      if ($languages[$i]['code'] == $content_language_code) {
        $content_language_id = $languages[$i]['id'];
      }
    }

    if (strlen($content_title) < 1) {
      $error = true;
      $messageStack->add(ERROR_TITLE,'error');
    }

    if ($error == false) {
      if ($select_file=='default') {
        $accepted_file_upload_files_extensions = array("xls","xla","hlp","chm","ppt","ppz","pps","pot","doc","dot","pdf","rtf","swf","cab","tar","zip","au","snd","mp2","rpm","stream","wav","gif","jpeg","jpg","jpe","png","tiff","tif","bmp","csv","txt","rtf","tsv","mpeg","mpg","mpe","qt","mov","avi","movie","rar","7z");
        $accepted_file_upload_files_mime_types = array("application/msexcel","application/mshelp","application/mspowerpoint","application/msword","application/pdf","application/rtf","application/x-shockwave-flash","application/x-tar","application/zip","audio/basic","audio/x-mpeg","audio/x-pn-realaudio-plugin","audio/x-qt-stream","audio/x-wav","image/gif","image/jpeg","image/png","image/tiff","image/bmp","text/csv","text/comma-separated-values","text/plain","text/rtf","text/tab-separated-values","video/mpeg","video/quicktime","video/x-msvideo","video/x-sgi-movie","application/x-rar-compressed","application/x-7z-compressed");
        if ($content_file = xtc_try_upload('file_upload', DIR_FS_CATALOG.'media/'.$path.'/','644',$accepted_file_upload_files_extensions,$accepted_file_upload_files_mime_types)) {
          $content_file_name = $content_file->filename;
          if ($_POST['keep_filename'] != '1') {
            $old_filename = $content_file_name;
            $timestamp = str_replace('.','',microtime());
            $timestamp = str_replace(' ','',$timestamp);
            $content_file_name = $timestamp.strstr($content_file_name,'.');
            rename(DIR_FS_CATALOG.'media/'.$path.'/'.$old_filename, DIR_FS_CATALOG.'media/'.$path.'/'.$content_file_name);
          }
          copy(DIR_FS_CATALOG.'media/'.$path.'/'.$content_file_name, DIR_FS_CATALOG.'media/'.$path.'/backup/'.$content_file_name);
        }
        if (!isset($content_file_name) || $content_file_name == '') {
          $content_file_name = $filename;
        }
      } else {
        $content_file_name = $select_file;
      }

      $sql_data_array = array(
        $type.'_id' => $product,
        'group_ids' => $group_ids,
        'content_name' => $content_title,
        'content_file' => $content_file_name,
        'content_link' => $content_link,
        'file_comment' => $file_comment,
        'languages_id' => $content_language_id,
      );

      if ($subaction == 'update') {
        $coID = xtc_db_prepare_input($_POST['coID']);
        xtc_db_perform($table, $sql_data_array, 'update', "content_id = '" . $coID . "'");
      } else {
        xtc_db_perform($table, $sql_data_array);
        $_GET[$type[0].'ID'] = $product;
      }

      foreach(auto_include(DIR_FS_ADMIN.'includes/extra/modules/content_manager/action/','php') as $file) require ($file);

      if (isset($_GET['cPath'])) {
        xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('last_action', 'action', 'id', 'coID')) . 'action='.$_GET['last_action']));
      } else {
        xtc_redirect(xtc_href_link(FILENAME_CONTENT_MANAGER, xtc_get_all_get_params(array('action', 'id', 'coID'))));
      }
    }
  }

  function check_content_childs($content_id,$languages_id) {    
    $contents_query = xtc_db_query("SELECT parent_id                              
                                      FROM " . TABLE_CONTENT_MANAGER . "
                                     WHERE parent_id = '" . (int) $content_id . "'
                                       AND languages_id = '" . (int)$languages_id . "'");
    if (xtc_db_num_rows($contents_query) > 0) {
      return true;
    }
    return false;
  }

  require (DIR_WS_INCLUDES.'head.php');

  if (USE_WYSIWYG=='true') {
    $query=xtc_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".(int)$_SESSION['languages_id']."'");
    $data=xtc_db_fetch_array($query);
    if ($set != '') {
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        echo xtc_wysiwyg('products_content', $data['code'], $languages[$i]['id']);
      }
    }
  }
?>
</head>
<body>
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php');?>
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
          <div class="pageHeading"><?php echo HEADING_TITLE;?><br /></div>          
          <div class="main pdg2 flt-l">Tools</div>
          <div class="clear"></div>
          <div class="content-manager-width mrg5">             
              <?php
                if ($set == '') {
                  //content
                  include(DIR_WS_MODULES.'content_manager_pages.php');
                  $newaction = 'new';
                } elseif ($set == 'product') {
                  //products content
                  include(DIR_WS_MODULES.'content_manager_products.php');
                  $newaction = 'new_products_content';
                } elseif ($set == 'content') {
                  //products content
                  include(DIR_WS_MODULES.'content_manager_content.php');
                  $newaction = 'new_content_manager_content';
                } elseif ($set == 'email') {
                  //products content
                  include(DIR_WS_MODULES.'content_manager_email.php');
                  $newaction = 'new_email_content';
                }
              ?>
              <?php                        
              if (!$action) {
                ?>                
                <div class="mrg5"><a class="button" onclick="this.blur();" href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'action='.$newaction.$setparam); ?>"><?php echo BUTTON_NEW_CONTENT; ?></a></div>
                <?php
              }
              ?>
          </div>
        </td>
        <!-- body_text_eof //-->
      </tr>
    </table>   
    <!-- body_eof //-->
    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
  </body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>