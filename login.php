<?php
/* -----------------------------------------------------------------------------------------
   $Id: login.php 10152 2016-07-27 07:15:01Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(login.php,v 1.79 2003/05/19); www.oscommerce.com 
   (c) 2003 nextcommerce (login.php,v 1.13 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce
   
   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   guest account idea by Ingo T. <xIngox@web.de>
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

define('LOGIN_NUM', 2);
defined('MODULE_CAPTCHA_CODE_LENGTH') or define('MODULE_CAPTCHA_CODE_LENGTH', 6);

if (isset ($_SESSION['customer_id'])) {
	xtc_redirect(xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}

// create smarty elements
$smarty = new Smarty;

// include needed functions
require_once (DIR_FS_INC.'xtc_validate_password.inc.php');
require_once (DIR_FS_INC.'xtc_array_to_string.inc.php');
require_once (DIR_FS_INC.'xtc_write_user_info.inc.php');

// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
if ($session_started == false) {
	xtc_redirect(xtc_href_link(FILENAME_COOKIE_USAGE));
}

$account_options = ACCOUNT_OPTIONS;
$products = $_SESSION['cart']->get_products();
for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {
  if (preg_match('/^GIFT/', addslashes($products[$i]['model']))) {
    $account_options = 'account';
    break;
  }
}

if (!isset($_SESSION['customers_login_tries'])) {
  $_SESSION['customers_login_tries'] = 0;
}

if (isset ($_GET['action']) && ($_GET['action'] == 'process')) {
	$email_address = xtc_db_prepare_input($_POST['email_address']);
	$password = xtc_db_prepare_input($_POST['password']);

	$vvcode = xtc_db_prepare_input((isset($_POST['vvcode'])) ? $_POST['vvcode'] : '0');
	$captcha = xtc_db_prepare_input((isset($_SESSION['vvcode'])) ? $_SESSION['vvcode'] : '1');
  unset($_SESSION['vvcode']);		
  
  // brute force
  $check_login_query = xtc_db_query("SELECT customers_login_tries
                                       FROM ".TABLE_CUSTOMERS_LOGIN."
                                      WHERE (customers_email_address = '".xtc_db_input($email_address)."'
                                             OR customers_ip = '".xtc_db_input($_SESSION['tracking']['ip'])."')");
  if (xtc_db_num_rows($check_login_query) > 0) {
    while ($check_login = xtc_db_fetch_array($check_login_query)) {
      if ($check_login['customers_login_tries'] > $_SESSION['customers_login_tries']) {
        $_SESSION['customers_login_tries'] = $check_login['customers_login_tries'];
      }
    }
    // update login tries
    xtc_db_query("UPDATE ".TABLE_CUSTOMERS_LOGIN." 
                     SET customers_login_tries = '".($_SESSION['customers_login_tries'] + 1)."'
                   WHERE (customers_email_address = '".xtc_db_input($email_address)."'
                          OR customers_ip = '".xtc_db_input($_SESSION['tracking']['ip'])."')");
  } else {
    $sql_data_array = array(
      'customers_ip' => $_SESSION['tracking']['ip'],
      'customers_email_address' => $email_address,
      'customers_login_tries' => ($_SESSION['customers_login_tries'] + 1),
    );
    xtc_db_perform(TABLE_CUSTOMERS_LOGIN, $sql_data_array);
  }

  // captcha
  $captcha_error = false;	
  if ($_SESSION['customers_login_tries'] >= LOGIN_NUM) {
    if (strtoupper($vvcode) != $captcha) {
      $captcha_error = true;
    }
  }
    
  // increment login tries
  $_SESSION['customers_login_tries'] ++;

	// check if email exists
	$check_customer_query = xtc_db_query("SELECT customers_id, 
	                                             customers_vat_id, 
	                                             customers_firstname,
	                                             customers_lastname, 
	                                             customers_gender, 
	                                             customers_password, 
	                                             customers_email_address, 
	                                             customers_default_address_id,
	                                             password_request_key,
	                                             password_request_time
	                                        FROM ".TABLE_CUSTOMERS." 
	                                       WHERE customers_email_address = '".xtc_db_input($email_address)."' 
	                                         AND account_type = '0'");

	if (xtc_db_num_rows($check_customer_query) < 1) {
		$messageStack->add('login', TEXT_LOGIN_ERROR);
	} else {
		$check_customer = xtc_db_fetch_array($check_customer_query);
    		
		// Check that password is good
		if (xtc_validate_password($password, $check_customer['customers_password'], $check_customer['customers_id']) !== true) {
			$messageStack->add('login', TEXT_LOGIN_ERROR);      
		} elseif ($captcha_error === false) {		
			if (SESSION_RECREATE == 'True') {
				xtc_session_recreate();
			}
      
      // reset Login tries
      unset($_SESSION['customers_login_tries']);
      xtc_db_query("DELETE FROM ".TABLE_CUSTOMERS_LOGIN."
                          WHERE (customers_email_address = '".xtc_db_input($email_address)."'
                                 OR customers_ip = '".xtc_db_input($_SESSION['tracking']['ip'])."')");

			$check_country_query = xtc_db_query("SELECT entry_country_id, 
			                                            entry_zone_id 
			                                       FROM ".TABLE_ADDRESS_BOOK." 
			                                      WHERE customers_id = '".(int) $check_customer['customers_id']."' 
			                                        AND address_book_id = '".$check_customer['customers_default_address_id']."'");
			$check_country = xtc_db_fetch_array($check_country_query);

			$_SESSION['customer_gender'] = $check_customer['customers_gender'];
			$_SESSION['customer_first_name'] = $check_customer['customers_firstname'];
			$_SESSION['customer_last_name'] = $check_customer['customers_lastname'];
			$_SESSION['customer_email_address'] = $check_customer['customers_email_address'];
			$_SESSION['customer_id'] = $check_customer['customers_id'];
			$_SESSION['customer_vat_id'] = $check_customer['customers_vat_id'];
			$_SESSION['customer_default_address_id'] = $check_customer['customers_default_address_id'];
			$_SESSION['customer_country_id'] = $check_country['entry_country_id'];
			$_SESSION['customer_zone_id'] = $check_country['entry_zone_id'];

			xtc_db_query("UPDATE ".TABLE_CUSTOMERS_INFO." 
			                 SET customers_info_date_of_last_logon = now(), 
			                     customers_info_number_of_logons = customers_info_number_of_logons+1 
			               WHERE customers_info_id = '".(int) $_SESSION['customer_id']."'");
			xtc_write_user_info((int) $_SESSION['customer_id']);
			
      // who's online
      xtc_update_whos_online();

			// restore cart contents
			$_SESSION['cart']->restore_contents();

			// restore wishlist contents
			if (defined('MODULE_WISHLIST_SYSTEM_STATUS') && MODULE_WISHLIST_SYSTEM_STATUS == 'true') {
			  $_SESSION['wishlist']->restore_contents();
			}
			
			if (isset($econda) && is_object($econda)) {
			  $econda->_loginUser();			
      }

      foreach(auto_include(DIR_FS_CATALOG.'includes/extra/login/','php') as $file) require_once ($file);
      
      // define pages allowed to redirect
      $redirect_array = array(FILENAME_ACCOUNT_HISTORY_INFO, 
                              FILENAME_ACCOUNT, 
                              FILENAME_CHECKOUT_SHIPPING, 
                              FILENAME_PRODUCT_REVIEWS_WRITE
                              );
      if (isset($_SESSION['REFERER']) && xtc_not_null($_SESSION['REFERER']) && in_array($_SESSION['REFERER'], $redirect_array) && $_SESSION['old_customers_basket_cart'] === false) {
        xtc_redirect(xtc_href_link($_SESSION['REFERER'], xtc_get_all_get_params(array('review_prod_id', 'action')).(isset($_GET['review_prod_id']) ? 'products_id=' .$_GET['review_prod_id'] : ''))); 
      } elseif ($_SESSION['cart']->count_contents() > 0) {
        if ($_SESSION['old_customers_basket_cart'] === true) {
          unset($_SESSION['old_customers_basket_cart']);
          $messageStack->add_session('info_message_3', TEXT_SAVED_BASKET);
        }
        xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART),'NONSSL'); 
      } else {          
        xtc_redirect(xtc_href_link(FILENAME_DEFAULT),'NONSSL');           
      } 
		}
	}
}

if ($captcha_error === true) {	
  $messageStack->add('login', TEXT_WRONG_CODE);
}

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

$breadcrumb->add(NAVBAR_TITLE_LOGIN, xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
require (DIR_WS_INCLUDES.'header.php');

if (isset($_GET['info_message']) && xtc_not_null($_GET['info_message'])) {
  $messageStack->add('login', get_message('info_message'));
}

if ($messageStack->size('login') > 0) {
	$smarty->assign('info_message', $messageStack->output('login'));
}

$smarty->assign('account_option', $account_options);
$smarty->assign('BUTTON_NEW_ACCOUNT', '<a href="'.xtc_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL').'">'.xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).'</a>');
$smarty->assign('BUTTON_LOGIN', xtc_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN));
$smarty->assign('BUTTON_GUEST', '<a href="'.xtc_href_link(FILENAME_CREATE_GUEST_ACCOUNT, '', 'SSL').'">'.xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).'</a>');
$smarty->assign('FORM_ACTION', xtc_draw_form('login', xtc_href_link(FILENAME_LOGIN, xtc_get_all_get_params().'action=process', 'SSL')));
$smarty->assign('INPUT_MAIL', xtc_draw_input_field('email_address'));
$smarty->assign('INPUT_PASSWORD', xtc_draw_password_field('password'));
$smarty->assign('LINK_LOST_PASSWORD', xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, '', 'SSL'));
$smarty->assign('FORM_END', '</form>');

// captcha
if ($_SESSION['customers_login_tries'] >= LOGIN_NUM) {
  $smarty->assign('VVIMG', '<img src="'.xtc_href_link(FILENAME_DISPLAY_VVCODES, '', 'SSL').'" alt="Captcha" />');
  $smarty->assign('INPUT_CODE', xtc_draw_input_field('vvcode', '', 'size="'.MODULE_CAPTCHA_CODE_LENGTH.'" maxlength="'.MODULE_CAPTCHA_CODE_LENGTH.'"', 'text', false));
}

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/login.html');
$smarty->assign('main_content', $main_content);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
if (!defined('RM'))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>