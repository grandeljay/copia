<?php
  /* --------------------------------------------------------------
   $Id: categories.php 10121 2016-07-20 10:53:42Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.26 2003/05/17); www.oscommerce.com
   (c) 2003 nextcommerce (categories.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2006 XT-Commerce (categories.php 1123 2005-07-27)
   --------------------------------------------------------------
   Third Party contribution:
   Enable_Disable_Categories 1.3               Autor: Mikel Williams | mikel@ladykatcostumes.com
   New Attribute Manager v4b                   Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Category Descriptions (Version: 1.5 MS2)    Original Author:   Brian Lowe <blowe@wpcusrgrp.org> | Editor: Lord Illicious <shaolin-venoms@illicious.net>
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

require_once ('includes/application_top.php');
require_once (DIR_WS_CLASSES.FILENAME_IMAGEMANIPULATOR);
/* magnalister v1.0.1 */
if (function_exists('magnaExecute')) magnaExecute('magnaInventoryUpdate', array('action' => 'inventoryUpdate'), array('inventoryUpdate.php'));
/* END magnalister */
require_once (DIR_WS_CLASSES.'categories.php');
require_once (DIR_FS_INC.'xtc_get_tax_rate.inc.php');
require_once (DIR_FS_INC.'xtc_get_products_mo_images.inc.php');
require_once (DIR_WS_CLASSES.'currencies.php');
require_once (DIR_FS_INC.'xtc_wysiwyg.inc.php');
require_once (DIR_FS_INC.'xtc_get_order_description.inc.php');
require_once (DIR_FS_INC.'xtc_parse_category_path.inc.php');

$currencies = new currencies();
$catfunc = new categories();

$catfunc->set_page_parameter();

//this is used only by group_prices
$function = (isset($_GET['function']) ? $_GET['function'] : '');
if (xtc_not_null($function)) {
  switch ($function) {
    case 'delete' :
      xtc_db_query("DELETE FROM personal_offers_by_customers_status_".(int) $_GET['statusID']."
                                 WHERE products_id = '".(int) $_GET['pID']."'
                                 AND quantity    = '".(int) $_GET['quantity']."'");
      break;
  }
  xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&action=new_product&pID='.(int) $_GET['pID'].$catfunc->page_parameter));
}

// Multi-Status Change, separated from $_GET['action'] //$action
// --- MULTI STATUS ---
if (isset ($_POST['multi_status_on'])) {
  //set multi_categories status=on
  if (is_array($_POST['multi_categories'])) {
    foreach ($_POST['multi_categories'] AS $category_id) {
      $catfunc->set_category_recursive((int)$category_id, '1');
    }
  }
  //set multi_products status=on
  if (is_array($_POST['multi_products'])) {
    foreach ($_POST['multi_products'] AS $product_id) {
      $catfunc->set_product_status((int)$product_id, '1');
    }
  }
  xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array ('cPath', 'action', 'pID', 'cID')).'cPath='.$_GET['cPath']));
}

if (isset ($_POST['multi_status_off'])) {
  //set multi_categories status=off
  if (is_array($_POST['multi_categories'])) {
    foreach ($_POST['multi_categories'] AS $category_id) {
      $catfunc->set_category_recursive((int)$category_id, "0");
    }
  }
  //set multi_products status=off
  if (is_array($_POST['multi_products'])) {
    foreach ($_POST['multi_products'] AS $product_id) {
      $catfunc->set_product_status((int)$product_id, "0");
    }
  }
  xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array ('cPath', 'action', 'pID', 'cID')).'cPath='.$_GET['cPath']));
}
// --- MULTI STATUS ENDS ---

//regular actions
$redirect_parameters = array ('action', 'flag', 'page');
if (isset($_GET['search']) && $_GET['search'] != '') {
  array_push($redirect_parameters, 'cPath');
}
$action = (isset($_GET['action']) ? $_GET['action'] : '');
if (xtc_not_null($action)) {
  switch ($action) {
    case 'setcflag' :
      if (($_GET['flag'] == '0') || ($_GET['flag'] == '1')) {
        if ($_GET['cID']) {
          $catfunc->set_category_recursive($_GET['cID'], $_GET['flag']);
        }
      }
      xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params($redirect_parameters).$catfunc->page_parameter_plain));
      break;
      //EOB setcflag
    case 'setpflag' :
      if (($_GET['flag'] == '0') || ($_GET['flag'] == '1')) {
        if ($_GET['pID']) {
          $catfunc->set_product_status($_GET['pID'], $_GET['flag']);
        }
      }
      xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params($redirect_parameters).$catfunc->page_parameter_plain));
      break;
      //EOB setpflag
    case 'setsflag' :
      if (($_GET['flag'] == '0') || ($_GET['flag'] == '1')) {
        if ($_GET['pID']) {
          $catfunc->set_product_startpage($_GET['pID'], $_GET['flag']);
          if ($_GET['flag'] == '1') $catfunc->link_product($_GET['pID'], 0);
          $catfunc->set_product_remove_startpage_sql($_GET['pID'], $_GET['flag']);
        }
      }
      xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params($redirect_parameters).$catfunc->page_parameter_plain));
      break;
      //EOB setsflag
    case 'update_category' :
      $categories_id = $catfunc->insert_category($_POST, '', 'update');
      //redirect by update button
      if (isset($_POST['cat_update'])) {
        xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('action', 'cID')).'action=edit_category&cID='.$categories_id));
      }     
      xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('action', 'cID')).'cID='.$categories_id)); 
      break;
    case 'insert_category' :
      $categories_id = $catfunc->insert_category($_POST, $current_category_id);
      xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_path($categories_id).'&cID='.$categories_id)); 
      break;
    case 'update_product' :
      $result = $catfunc->insert_product($_POST, '', 'update');
      //redirect by update button
      if(isset($_POST['prod_update']) || $result['error'] === true) {
        xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('action', 'pID')).'action=new_product&pID='.$result['products_id']));
      }
      if (isset($_GET['origin']) && $_GET['origin'] != '') {
        xtc_redirect(xtc_href_link(basename($_GET['origin']), 'pID='.$result['products_id'].$catfunc->page_parameter));
      }
      xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_path($current_category_id).'&pID='.$result['products_id'].$catfunc->page_parameter));
      break;
    case 'insert_product' :
      $result = $catfunc->insert_product($_POST, $current_category_id);
      xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_path($current_category_id).'&pID='.$result['products_id'].$catfunc->page_parameter));
      break;
    case 'edit_crossselling' :
      $catfunc->edit_cross_sell($_GET);
      break;
    // BOF - Tomcraft - 2009-11-28 - Included xs:booster
    case 'multi_action':
      // xs:booster start - multiauktion (v1.041)
      if (isset($_POST['multi_xtb'])) {
        $_SESSION['xtb1']['multi_xtb']=array();
        require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'xtbooster.php');
        $xtb = new xtbooster_base;
        $xtb->config();
        $requestx = "ACTION:TradeTemplateFetch";
        $resx = $xtb->parse($xtb->exec($requestx));
        $MULTI_REVERSECATS = $resx['MULTI_REVERSECATS'];
        $MULTI_ONLYONSTOCK = $resx['MULTI_ONLYONSTOCK'];
        if (is_array($_POST['multi_products'])) {
          $x=$_POST['multi_products'];
          foreach($x as $products_id) {
            $q = xtc_db_query("select products_quantity from ".TABLE_PRODUCTS." where products_id = '".$products_id."'");
            $p = xtc_db_fetch_array($q);
            if($MULTI_ONLYONSTOCK=='true'&&$p['products_quantity']<1) continue;
            $_SESSION['xtb1']['multi_xtb'][]=$products_id;
          }
        }
        if (is_array($_POST['multi_categories'])) {
          $_xtb_max_p = 10000;
          function _xtb_reverse($category_id=0) {
            global $_xtb_max_p,$MULTI_ONLYONSTOCK;
            $cp = xtc_db_query("select * from ".TABLE_CATEGORIES." where parent_id = '".$category_id."'");
            while($c=xtc_db_fetch_array($cp)) {
              $q = xtc_db_query("select p.products_id, p.products_quantity from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c where p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '".$c['categories_id']."'");
              while($p = xtc_db_fetch_array($q)) {
                if($MULTI_ONLYONSTOCK=='true'&&$p['products_quantity']<1) continue;
                $_SESSION['xtb1']['multi_xtb'][$p['products_id']] = $p['products_id'];
              }
              if($_xtb_max_p--<0) break;
              _xtb_reverse($c['categories_id']);
            }
          }
          foreach ($_POST['multi_categories'] AS $i=>$category_id) {
            $q = xtc_db_query("select p.products_id, p.products_quantity from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c where p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '".$category_id."'");
            while($p = xtc_db_fetch_array($q)) {
              if($MULTI_ONLYONSTOCK=='true'&&$p['products_quantity']<1) continue;
              $_SESSION['xtb1']['multi_xtb'][$p['products_id']] = $p['products_id'];
            }
            if($MULTI_REVERSECATS=='true') _xtb_reverse($category_id);
          }
        }
        header("Location: xtbooster.php?xtb_module=add&mode=multi_xtb");
        exit;
      }
      // xs:booster end - multiauktion (v1.041)
      break;
      // EOF - Tomcraft - 2009-11-28 - Included xs:booster
    case 'multi_action_confirm' :
      // --- MULTI DELETE ---
      if (isset ($_POST['multi_delete_confirm'])) {
        //delete multi_categories
        if (is_array($_POST['multi_categories'])) {
          foreach ($_POST['multi_categories'] AS $category_id) {
            $catfunc->remove_categories($category_id);
          }
        }
        //delete multi_products
        if (is_array($_POST['multi_products']) && is_array($_POST['multi_products_categories'])) {
          foreach ($_POST['multi_products'] AS $product_id) {
            $catfunc->delete_product($product_id, $_POST['multi_products_categories'][$product_id]);
          }
        }
      }
      // --- MULTI DELETE ENDS ---

      // --- MULTI MOVE ---
      if (isset ($_POST['multi_move_confirm'])) {
        //move multi_categories
        if (is_array($_POST['multi_categories']) && xtc_not_null($_POST['move_to_category_id'])) {
          foreach ($_POST['multi_categories'] AS $category_id) {
            $dest_category_id = xtc_db_prepare_input($_POST['move_to_category_id']);
            if ($category_id != $dest_category_id) {
              $catfunc->move_category($category_id, $dest_category_id);
            }
          }
        }
        //move multi_products
        if (is_array($_POST['multi_products']) && xtc_not_null($_POST['move_to_category_id']) && xtc_not_null($_POST['src_category_id'])) {
          foreach ($_POST['multi_products'] AS $product_id) {
            $product_id = xtc_db_prepare_input($product_id);
            $src_category_id = xtc_db_prepare_input($_POST['src_category_id']);
            $dest_category_id = xtc_db_prepare_input($_POST['move_to_category_id']);
            $catfunc->move_product($product_id, $src_category_id, $dest_category_id);
          }
        }
        xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array ('cPath', 'action', 'pID', 'cID')).'cPath='.$dest_category_id));
      }
      // --- MULTI MOVE ENDS ---

      // --- MULTI COPY ---
      if (isset ($_POST['multi_copy_confirm'])) {
        //copy multi_categories
        if (is_array($_POST['multi_categories']) && (is_array($_POST['dest_cat_ids']) || xtc_not_null($_POST['dest_category_id']))) {
          //BOF - DokuMan - 2010-09-27 - do not create copied categories under TOP-category, but in the chosen category
          if (!isset($_POST['dest_cat_ids']) and isset($_POST['dest_category_id'])) {
            $_POST['dest_cat_ids'] = array($_POST['dest_category_id']);
          }
          $_SESSION['copied'] = array ();
          foreach ($_POST['multi_categories'] AS $category_id) {
            if (is_array($_POST['dest_cat_ids'])) {
              foreach ($_POST['dest_cat_ids'] AS $dest_category_id) {
                if ($_POST['copy_as'] == 'link') {
                  $catfunc->copy_category($category_id, $dest_category_id, 'link');
                } elseif ($_POST['copy_as'] == 'duplicate') {
                  $catfunc->copy_category($category_id, $dest_category_id, 'duplicate');
                } else {
                  $messageStack->add_session(ERROR_COPY_METHOD_NOT_SPECIFIED, 'error');
                }
              }
            } elseif (xtc_not_null($_POST['dest_category_id'])) {
              $dest_category_id = xtc_db_prepare_input($_POST['dest_category_id']); // web28 - 2012-04-14 - BUGFIX $dest_category_id
              if ($_POST['copy_as'] == 'link') {
                //$catfunc->copy_category($category_id, $dest_category_id, 'link');
                $messageStack->add_session(ERROR_COPY_METHOD_NOT_ALLOWED, 'error');
              } elseif ($_POST['copy_as'] == 'duplicate') {
                $catfunc->copy_category($category_id, $dest_category_id, 'duplicate');
              } else {
                $messageStack->add_session(ERROR_COPY_METHOD_NOT_SPECIFIED, 'error');
              }
            }
          }
          unset ($_SESSION['copied']);
        }
        //copy multi_products
        if (is_array($_POST['multi_products']) && (is_array($_POST['dest_cat_ids']) || xtc_not_null($_POST['dest_category_id']))) {
          foreach ($_POST['multi_products'] AS $product_id) {
            $product_id = xtc_db_prepare_input($product_id);
            if (is_array($_POST['dest_cat_ids'])) {
              foreach ($_POST['dest_cat_ids'] AS $dest_category_id) {
                $dest_category_id = xtc_db_prepare_input($dest_category_id);
                if ($_POST['copy_as'] == 'link') {
                  $catfunc->link_product($product_id, $dest_category_id);
                  $pID = $product_id;
                } elseif ($_POST['copy_as'] == 'duplicate') {
                  $catfunc->duplicate_product($product_id, $dest_category_id);
                  $pID = $catfunc->dup_products_id;
                } else {
                  $messageStack->add_session(ERROR_COPY_METHOD_NOT_SPECIFIED, 'error');
                }
              }
            } elseif (xtc_not_null($_POST['dest_category_id'])) {
              $dest_category_id = xtc_db_prepare_input($_POST['dest_category_id']);
              if ($_POST['copy_as'] == 'link') {
                $catfunc->link_product($product_id, $dest_category_id);
                $pID = $product_id;
              } elseif ($_POST['copy_as'] == 'duplicate') {
                $catfunc->duplicate_product($product_id, $dest_category_id);
                $pID = $catfunc->dup_products_id;
              } else {
                $messageStack->add_session(ERROR_COPY_METHOD_NOT_SPECIFIED, 'error');
              }
            }
          }
        }
        //BOC - web28 - redirect to product input mask
        $action = is_array($_POST['multi_products']) && isset($_POST['link_to_product']) ? '&action=new_product' : '';
        $pID = isset($pID) && $pID > 0 ? '&pID='. $pID : '';
        xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array ('cPath', 'action', 'pID', 'cID')).'cPath='.$dest_category_id.$pID.$action));
        //EOC - web28 - redirect to product input mask
      }
      // --- MULTI COPY ENDS ---
      xtc_redirect(xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array ('cPath', 'action', 'pID', 'cID')).'cPath='.$_GET['cPath']));
      break;
      #EOB multi_action_confirm
  } //EOB switch action
} //EOB if action

// check if the catalog image directory exists
if (is_dir(DIR_FS_CATALOG_IMAGES)) {
  if (!is_writeable(DIR_FS_CATALOG_IMAGES))
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
} else {
  $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
}
// end of pre-checks and actions, HTML output follows

//breadcrumb
require_once (DIR_FS_CATALOG.'includes/classes/breadcrumb.php');
$breadcrumb = new breadcrumb;
$breadcrumb->add(TEXT_TOP, xtc_href_link(FILENAME_CATEGORIES, (isset($_GET['page']) ? 'page='.(int)$_GET['page'] : '')));
if (isset ($cPath_array)) {
  $cPathLinkParam = array();
  for ($i = 0, $n = sizeof($cPath_array); $i < $n; $i ++) {
    if ($cPath_array[$i]) {
      $cPathLinkParam[] = $cPath_array[$i];
      $categories_query = xtc_db_query("SELECT categories_name
                                          FROM ".TABLE_CATEGORIES_DESCRIPTION."
                                         WHERE categories_id = '".(int)$cPath_array[$i]."'
                                           AND language_id = '".(int)$_SESSION['languages_id']."'");
      if (xtc_db_num_rows($categories_query) > 0) {
        $categories = xtc_db_fetch_array($categories_query);
        $breadcrumb->add($categories['categories_name'], xtc_href_link(FILENAME_CATEGORIES, 'cPath='.implode('_',$cPathLinkParam) . (isset($_GET['page']) ? '&page='.(int)$_GET['page'] : '')));
      } else {
        break;
      }
    }
  }
}
$breadcrumb_html = '<span class="breadcrumb">' . $breadcrumb->trail(' &raquo; ') . '</span>';

require (DIR_WS_INCLUDES.'head.php');
?>
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript" src="includes/javascript/categories.js"></script>
  <script type="text/javascript"> 
    var lang_chars_left = '<?php echo CHARS_LEFT; ?>'; 
    var lang_chars_max = '<?php echo CHARS_MAX; ?>'; 
  </script>  
  <script type="text/javascript" src="includes/javascript/countdown.js"></script> 
<?php
//jQueryDatepicker
require (DIR_WS_INCLUDES.'javascript/jQueryDateTimePicker/datepicker.js.php');
// Include WYSIWYG if is activated
if (USE_WYSIWYG == 'true') {
	$query = xtc_db_query("SELECT code FROM ".TABLE_LANGUAGES." WHERE languages_id='".(int)$_SESSION['languages_id']."'");
	$data = xtc_db_fetch_array($query);
	// generate editor for categories EDIT
	$languages = xtc_get_languages();
	echo PHP_EOL . (!function_exists('editorJSLink') ? '<script type="text/javascript" src="includes/modules/fckeditor/fckeditor.js"></script>' : '') . PHP_EOL;
	// generate editor for categories
	if ($action == 'new_category' || $action == 'edit_category') {
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
		echo xtc_wysiwyg('categories_description', $data['code'], $languages[$i]['id']);
	  }
	}
	// generate editor for products
	if ($action == 'new_product' || $action == 'new_product_preview') {
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
		echo xtc_wysiwyg('products_description', $data['code'], $languages[$i]['id']);
		echo xtc_wysiwyg('products_short_description', $data['code'], $languages[$i]['id']);
	  }
	}
}
?>
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
              <?php
              //----- new_category / edit_category (when ALLOW_CATEGORY_DESCRIPTIONS is 'true') -----
              if ($action == 'new_category' || $action == 'edit_category') {
                include (DIR_WS_MODULES.'new_category.php');
              } elseif ($action == 'new_product' || $action == 'new_product_preview') {
                include (DIR_WS_MODULES.'new_product.php');
              } elseif ($action == 'edit_crossselling') {
                include (DIR_WS_MODULES.'cross_selling.php');
              } else {
                //set $cPath to 0 if not set - FireFox workaround, didn't work when de/activating categories and $cPath wasn't set
                if (!$cPath) {
                  $cPath = '0';
                }
                include (DIR_WS_MODULES.'categories_view.php');
              }
              ?>
              <!-- close tables from above modules //-->
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