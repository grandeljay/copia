<?php
/* -----------------------------------------------------------------------------------------
   $Id: contact_us.php 13412 2021-02-09 11:35:54Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2006 XT-Commerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  defined('DISPLAY_PRIVACY_CHECK') or define('DISPLAY_PRIVACY_CHECK', 'true');

  //use contact_us.php language file
  require_once (DIR_WS_LANGUAGES.$_SESSION['language'].'/contact_us.php');

  // include needed functions
  require_once (DIR_FS_INC.'parse_multi_language_value.inc.php');
  require_once (DIR_FS_INC.'secure_form.inc.php');

  // include needed classes
  require_once(DIR_WS_CLASSES.'modified_captcha.php');
  
  $mod_captcha = $_mod_captcha_class::getInstance();
    
  // captcha
  $use_captcha = array('contact');
  if (defined('MODULE_CAPTCHA_ACTIVE')) {
    $use_captcha = explode(',', MODULE_CAPTCHA_ACTIVE);
  }
  defined('MODULE_CAPTCHA_CODE_LENGTH') or define('MODULE_CAPTCHA_CODE_LENGTH', 6);
  defined('MODULE_CAPTCHA_LOGGED_IN') or define('MODULE_CAPTCHA_LOGGED_IN', 'True');
  
  $action = isset($_GET['action']) && $_GET['action'] != '' ? $_GET['action'] : '';
  $privacy = isset($_POST['privacy']) && $_POST['privacy'] == 'privacy' ? true : false;
  
  if (!isset($smarty) || !is_object($smarty)) {
    $smarty = new Smarty();
  }
  
  if (!isset($main) || !is_object($main)) {
    $main = new main();
  }
  
  $error = false;
  if ($action == 'send') {

    $valid_params = array(
      'name',
      'email',
      'message_body',
      'company',
      'street',
      'postcode',
      'city',
      'phone',
      'fax',
    );

    // prepare variables
    foreach ($_POST as $key => $value) {
      if ((!isset(${$key}) || !is_object(${$key})) && in_array($key , $valid_params)) {
        ${$key} = xtc_db_prepare_input($value);
      }
    }

    if (!xtc_validate_email(trim($email))) {
      $messageStack->add('contact_us', ERROR_EMAIL);
      $error = true;
    }
    
    if (in_array('contact', $use_captcha) && (!isset($_SESSION['customer_id']) || MODULE_CAPTCHA_LOGGED_IN == 'True')) {    
      if ($mod_captcha->validate($_POST['vvcode']) !== true) {
        $messageStack->add('contact_us', ERROR_VVCODE);
        $error = true;
      }
    }
    
    if (trim($message_body) == '') {
      $messageStack->add('contact_us', ERROR_MSG_BODY);
      $error = true;
    }

    if (DISPLAY_PRIVACY_CHECK == 'true' && empty($privacy)) {
      $messageStack->add('contact_us', ENTRY_PRIVACY_ERROR);
      $error = true;
    }

    if (check_secure_form($_POST) === false) {
      $messageStack->add('contact_us', ENTRY_TOKEN_ERROR);
      $error = true;
    }

    if ($messageStack->size('contact_us') > 0) {
      $messageStack->add('contact_us', ERROR_MAIL);
      $smarty->assign('error_message', $messageStack->output('contact_us'));
    }

    if ($error === false) {
      $datum = date("d.m.Y");
      $uhrzeit = date("H:i");

      $additional_fields = '';
      if (isset($company))  $additional_fields =  EMAIL_COMPANY. $company . "\n" ;
      if (isset($street))   $additional_fields .= EMAIL_STREET . $street . "\n" ;
      if (isset($postcode)) $additional_fields .= EMAIL_POSTCODE . $postcode . "\n" ;
      if (isset($city))     $additional_fields .= EMAIL_CITY . $city . "\n" ;
      if (isset($phone))    $additional_fields .= EMAIL_PHONE . $phone . "\n" ;
      if (isset($fax))      $additional_fields .= EMAIL_FAX . $fax . "\n" ;

      if (file_exists(DIR_FS_DOCUMENT_ROOT.'templates/'.CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/contact_us.html') 
          && file_exists(DIR_FS_DOCUMENT_ROOT.'templates/'.CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/contact_us.txt')
          ) 
      {
        $smarty->assign('language', $_SESSION['language']);
        $smarty->assign('tpl_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/');    
        $smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
        $smarty->assign('NAME', $name);
        $smarty->assign('EMAIL', $email);
        $smarty->assign('DATE', $datum);
        $smarty->assign('TIME', $uhrzeit);
        $smarty->assign('ADDITIONAL_FIELDS', nl2br($additional_fields));
        $smarty->assign('MESSAGE', nl2br($message_body));
     
        // dont allow cache
        $smarty->caching = false;
     
        $html_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/contact_us.html');
        $txt_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/contact_us.txt');
        $txt_mail = str_replace(array('<br />', '<br/>', '<br>'), '', $txt_mail);
      } else {
        $txt_mail = sprintf(EMAIL_SENT_BY, parse_multi_language_value(CONTACT_US_NAME, $_SESSION['language_code']), parse_multi_language_value(CONTACT_US_EMAIL_ADDRESS, $_SESSION['language_code']), $datum , $uhrzeit) . "\n" .
                "--------------------------------------------------------------" . "\n" .
                EMAIL_NAME. $name . "\n" .
                EMAIL_EMAIL. trim($email) . "\n" .
                $additional_fields .
                "\n".EMAIL_MESSAGE."\n ". $message_body . "\n";
        $html_mail = nl2br($txt_mail);
      }
      
      if (defined('MODULE_CONTACT_US_STATUS') && MODULE_CONTACT_US_STATUS == 'true') {
        require_once (DIR_FS_INC.'ip_clearing.inc.php');

        $sql_data_array = array(
          'customers_id' => (int)$_SESSION['customer_id'],
          'customers_name' => $name,
          'customers_email_address' => $email,
          'customers_ip' => ip_clearing($_SESSION['tracking']['ip']),
          'date_added' => 'now()',
        );
        xtc_db_perform('contact_us_log', $sql_data_array);
      }
      
      xtc_php_mail(CONTACT_US_EMAIL_ADDRESS,
                   CONTACT_US_NAME,
                   CONTACT_US_EMAIL_ADDRESS,
                   CONTACT_US_NAME,
                   CONTACT_US_FORWARDING_STRING,
                   trim($email),
                   $name,
                   '',
                   '',
                   CONTACT_US_EMAIL_SUBJECT,
                   $html_mail,
                   $txt_mail
                   );

      xtc_redirect(xtc_href_link(FILENAME_CONTENT, 'action=success&coID='.(int) $_GET['coID']));
    }
  }

  $smarty->assign('CONTACT_HEADING', $shop_content_data['content_heading']);
  if (isset ($_GET['action']) && ($_GET['action'] == 'success')) {
    $smarty->assign('success', '1');
    $smarty->assign('BUTTON_CONTINUE', '<a href="'.xtc_href_link(FILENAME_DEFAULT).'">'.xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).'</a>');

  } else {
    if (isset ($_SESSION['customer_id']) && $action == '') {
      $c_query = xtc_db_query("SELECT c.customers_email_address,
                                      c.customers_telephone,
                                      c.customers_fax,
                                      ab.entry_company,
                                      ab.entry_street_address,
                                      ab.entry_city,
                                      ab.entry_postcode
                                 FROM ".TABLE_CUSTOMERS." c
                                 JOIN ".TABLE_ADDRESS_BOOK." ab
                                      ON ab.customers_id = c.customers_id
                                         AND ab.address_book_id = c.customers_default_address_id
                                WHERE c.customers_id = '".(int)$_SESSION['customer_id']."'");
      $c_data  = xtc_db_fetch_array($c_query);
      $c_data = array_map('stripslashes', $c_data);
      $name = $_SESSION['customer_first_name'].' '.$_SESSION['customer_last_name'];
      $email = $c_data['customers_email_address'];
      $phone = $c_data['customers_telephone'];
      $fax = $c_data['customers_fax'];
      $company = $c_data['entry_company'];
      $street = $c_data['entry_street_address'];
      $postcode = $c_data['entry_postcode'];
      $city = $c_data['entry_city'];
    } elseif ($action == '') {
    	$name = '';
    	$email = '';
    	$phone = '';
    	$company = '';
    	$street = '';
    	$postcode = '';
    	$city = '';
    	$fax = '';
    }
    
    $smarty->assign('CONTACT_CONTENT', $shop_content_data['content_text']);
    $smarty->assign('FORM_ACTION', xtc_draw_form('contact_us', xtc_href_link(FILENAME_CONTENT, 'action=send&coID='.(int) $_GET['coID'], 'SSL')).secure_form());
    if (in_array('contact', $use_captcha) && (!isset($_SESSION['customer_id']) || MODULE_CAPTCHA_LOGGED_IN == 'True')) {
      $smarty->assign('VVIMG', $mod_captcha->get_image_code());
      $smarty->assign('INPUT_CODE', $mod_captcha->get_input_code());
    }
    if (DISPLAY_PRIVACY_CHECK == 'true') {
      $smarty->assign('PRIVACY_CHECKBOX', xtc_draw_checkbox_field('privacy', 'privacy', $privacy, 'id="privacy"'));
    }
    $smarty->assign('PRIVACY_LINK', $main->getContentLink(2, MORE_INFO, $request_type));
    $smarty->assign('INPUT_NAME', xtc_draw_input_field('name', ((isset($name)) ? $name : ''), 'size="30"'));
    $smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', ((isset($email)) ? $email : ''), 'size="30"'));
    $smarty->assign('INPUT_PHONE', xtc_draw_input_field('phone', ((isset($phone)) ? $phone : ''), 'size="30"'));
    $smarty->assign('INPUT_COMPANY', xtc_draw_input_field('company', ((isset($company)) ? $company : ''), 'size="30"'));
    $smarty->assign('INPUT_STREET', xtc_draw_input_field('street', ((isset($street)) ? $street : ''), 'size="30"'));
    $smarty->assign('INPUT_POSTCODE', xtc_draw_input_field('postcode', ((isset($postcode)) ? $postcode : ''), 'size="30"'));
    $smarty->assign('INPUT_CITY', xtc_draw_input_field('city', ((isset($city)) ? $city : ''), 'size="30"'));
    $smarty->assign('INPUT_FAX', xtc_draw_input_field('fax', ((isset($fax)) ? $fax : ''), 'size="30"'));
    $smarty->assign('INPUT_TEXT', xtc_draw_textarea_field('message_body', 'soft', 45, 15, ((isset($message_body)) ? $message_body : '')));
    $smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_send.gif', IMAGE_BUTTON_SEND));
    $smarty->assign('FORM_END', '</form>');
  }

  $smarty->assign('language', $_SESSION['language']);
  $smarty->caching = 0;
  $smarty->display(CURRENT_TEMPLATE.'/module/contact_us.html');
  
  // clear variables
  $smarty->clear_assign('BUTTON_CONTINUE');
  $smarty->clear_assign('CONTENT_HEADING');
  $content_body = '';
  
  // disable cache
  $disable_smarty_cache = true;
?>