<?php

/* -----------------------------------------------------------------------------------------
   $Id: gift_cart.php 13222 2021-01-21 10:30:51Z GTB $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shopping_cart.php,v 1.32 2003/02/11); www.oscommerce.com
   (c) 2003     nextcommerce (shopping_cart.php,v 1.21 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:


   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$gift_smarty = new Smarty;
$gift_smarty->assign('tpl_path', DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');

if (ACTIVATE_GIFT_SYSTEM == 'true') {
	$gift_smarty->assign('ACTIVATE_GIFT', 'true');
}

if (isset ($_SESSION['customer_id'])) {
  $gv_amount = 0;
	$gv_query = xtc_db_query("SELECT amount 
	                            FROM ".TABLE_COUPON_GV_CUSTOMER." 
	                           WHERE customer_id = '".(int)$_SESSION['customer_id']."'");
	if (xtc_db_num_rows($gv_query) > 0) {
	  $gv_result = xtc_db_fetch_array($gv_query);
    if ($gv_result['amount'] > 0) {
      $gv_amount = $xtPrice->xtcFormat($gv_result['amount'], true, 0, true);
      $gift_smarty->assign('GV_SEND_TO_FRIEND_LINK', xtc_href_link(FILENAME_GV_SEND));
    }
	}
  $gift_smarty->assign('GV_AMOUNT', $gv_amount);
  $gift_smarty->assign('C_FLAG', 'true');
}

if (isset ($_SESSION['gv_id'])) {
	$gv_query = xtc_db_query("SELECT coupon_amount 
	                            FROM ".TABLE_COUPONS." 
	                           WHERE coupon_id = '".(int)$_SESSION['gv_id']."'");
	$coupon = xtc_db_fetch_array($gv_query);
	$gift_smarty->assign('COUPON_AMOUNT2', $xtPrice->xtcFormat($coupon['coupon_amount'], true, 0, true));
}

$cc_check = isset($_SESSION['cc_amount_min_order']) && $_SESSION['cc_amount_min_order'] <= $_SESSION['cart']->show_total() ? true : false;
if (isset ($_SESSION['cc_id']) && $cc_check) {
  if (!defined('POPUP_COUPON_HELP_LINK_PARAMETERS')) {
    define('POPUP_COUPON_HELP_LINK_PARAMETERS', '&KeepThis=true&TB_iframe=true&height=400&width=600');
  }
  if (!defined('POPUP_SHIPPING_LINK_CLASS')) {
    define('POPUP_SHIPPING_LINK_CLASS', 'thickbox');
  }
  $clink_parameters = defined('TPL_POPUP_CONTENT_LINK_PARAMETERS') ? TPL_POPUP_COUPON_HELP_LINK_PARAMETERS : POPUP_COUPON_HELP_LINK_PARAMETERS;
  $clink_class = defined('TPL_POPUP_CONTENT_LINK_CLASS') ? TPL_POPUP_SHIPPING_LINK_CLASS : POPUP_SHIPPING_LINK_CLASS;
	$gift_smarty->assign('COUPON_HELP_LINK', '<a title="'.TEXT_LINK_TITLE_INFORMATION.'" target="_blank" class="'.$clink_class.'" href="'.xtc_href_link(FILENAME_POPUP_COUPON_HELP, 'cID='.$_SESSION['cc_id'].$clink_parameters, $request_type).'">');
}

//check coupon minimum order
$cc_check = isset($_SESSION['cc_amount_min_order']) && $_SESSION['cc_amount_min_order'] <= $_SESSION['cart']->show_total() ? true : false;
if (isset($_SESSION['cc_post']) && !$cc_check) {
  unset($_SESSION['cc_id']); 
  unset($_SESSION['cc_post']);   
  unset($_GET['info_message']);
  $cc_amount_min_order_info = sprintf(ERROR_INVALID_MINIMUM_ORDER_COUPON,$xtPrice->xtcFormat($_SESSION['cc_amount_min_order'],true)).ERROR_INVALID_MINIMUM_ORDER_COUPON_ADD;
}

if ($messageStack->size('coupon_message') > 0) {
  $gift_smarty->assign('coupon_message', $messageStack->output('coupon_message'));
}
if ($messageStack->size('coupon_message', 'success') > 0) {
	$gift_smarty->assign('success_message', $messageStack->output('coupon_message', 'success'));
}

$dflag = 'cart';
$action = 'action=check_gift';
if (strpos(basename($PHP_SELF), 'checkout') !== false) {
  $action = 'action=check_gift_checkout&conditions=on';
  $dflag = 'checkout';
}
$gift_smarty->assign('D_FLAG', $dflag);
$gift_smarty->assign('LINK_ACCOUNT', xtc_href_link(FILENAME_CREATE_ACCOUNT,'','SSL'));
$gift_smarty->assign('FORM_ACTION', xtc_draw_form('gift_coupon', xtc_href_link(basename($PHP_SELF), $action, $request_type)));
$gift_smarty->assign('INPUT_CODE', xtc_draw_input_field('gv_redeem_code'));
$gift_smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_redeem.gif', IMAGE_REDEEM_GIFT, 'name="check_gift"'));
$gift_smarty->assign('language', $_SESSION['language']);
$gift_smarty->assign('FORM_END', '</form>');
$gift_smarty->caching = 0;

$smarty->assign('MODULE_gift_cart', $gift_smarty->fetch(CURRENT_TEMPLATE.'/module/gift_cart.html'));
?>