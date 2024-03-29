<?php

/* -----------------------------------------------------------------------------------------
   $Id: account_delete.php 14390 2022-04-29 07:28:14Z GTB $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_password.php,v 1.1 2003/05/19); www.oscommerce.com
   (c) 2003 nextcommerce (account_password.php,v 1.14 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include 'includes/application_top.php';

// include needed functions
require_once DIR_FS_INC . 'xtc_validate_password.inc.php';
require_once DIR_FS_INC . 'secure_form.inc.php';
require_once DIR_FS_INC . 'clear_checkout_session.inc.php';

// create smarty elements
$smarty = new Smarty();

if (!isset($_SESSION['customer_id'])) {
    xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
} elseif (
       isset($_SESSION['customer_id'])
    && DEFAULT_CUSTOMERS_STATUS_ID_GUEST == $_SESSION['customers_status']['customers_status_id']
    && GUEST_ACCOUNT_EDIT != 'true'
) {
    xtc_redirect(xtc_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

// clear session
clear_checkout_session();

if (1 == $_SESSION['customer_id']) {
    xtc_redirect(xtc_href_link(FILENAME_DEFAULT), 'NONSSL');
}

$success = false;

if (isset($_POST['action']) && ('process' == $_POST['action'])) {
    $password             = xtc_db_prepare_input($_POST['password']);
    $check_customer_query = xtc_db_query(
        "SELECT customers_password
           FROM " . TABLE_CUSTOMERS . "
          WHERE customers_id = '" . (int) $_SESSION['customer_id'] . "'"
    );
    $check_customer       = xtc_db_fetch_array($check_customer_query);

    if (check_secure_form($_POST) === false) {
        $messageStack->add('account_delete', ENTRY_TOKEN_ERROR);
    } elseif (!xtc_validate_password($password, $check_customer['customers_password'], $_SESSION['customer_id'])) {
        $messageStack->add('account_delete', TEXT_LOGIN_ERROR);
    } else {
        $_SESSION['cart']->reset(true);

        if (defined('MODULE_WISHLIST_SYSTEM_STATUS') && MODULE_WISHLIST_SYSTEM_STATUS == 'true') {
            $_SESSION['wishlist']->reset(true);
        }

        xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . (int) $_SESSION['customer_id'] . "'");
        xtc_db_query("DELETE FROM " . TABLE_ADDRESS_BOOK . " WHERE customers_id = '" . (int) $_SESSION['customer_id'] . "'");
        xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_INFO . " WHERE customers_info_id = '" . (int) $_SESSION['customer_id'] . "'");
        xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_IP . " WHERE customers_id = '" . (int) $_SESSION['customer_id'] . "'");
        xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_MEMO . " WHERE customers_id = '" . (int) $_SESSION['customer_id'] . "'");
        xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_STATUS_HISTORY . " WHERE customers_id = '" . (int) $_SESSION['customer_id'] . "'");

        xtc_session_destroy();
        xtc_session_reset();

        $success = true;
        require DIR_WS_INCLUDES . 'write_customers_status.php';
    }
}

// include boxes
require DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php';

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_DELETE, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_DELETE, xtc_href_link(FILENAME_ACCOUNT_DELETE, '', 'SSL'));

require DIR_WS_INCLUDES . 'header.php';

if ($messageStack->size('account_delete') > 0) {
    $smarty->assign('error_message', $messageStack->output('account_delete'));
}

$smarty->assign('FORM_ACTION', xtc_draw_form('account_delete', xtc_href_link(FILENAME_ACCOUNT_DELETE, '', 'SSL'), 'post') . xtc_draw_hidden_field('action', 'process') . secure_form('account_delete'));
$smarty->assign('INPUT_PASSWORD', xtc_draw_password_field('password'));
$smarty->assign('BUTTON_BACK', '<a href="' . xtc_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>');
$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('FORM_END', '</form>');

if (true === $success) {
    $smarty->assign('BUTTON_CONTINUE', '<a href="' . xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>');
}

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$main_content    = $smarty->fetch(CURRENT_TEMPLATE . '/module/account_delete.html');

$smarty->assign('main_content', $main_content);

if (!defined('RM')) {
    $smarty->load_filter('output', 'note');
}

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include 'includes/application_bottom.php';
