<?php

/* -----------------------------------------------------------------------------------------
   $Id: address_book_process.php 14390 2022-04-29 07:28:14Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book_process.php,v 1.77 2003/05/27); www.oscommerce.com
   (c) 2003  nextcommerce (address_book_process.php,v 1.13 2003/08/17); www.nextcommerce.org
   (c) 2006 XT-Commerce - www.xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include 'includes/application_top.php';

// create smarty elements
$smarty = new Smarty();

// include needed functions
require_once DIR_FS_INC . 'xtc_count_customer_address_book_entries.inc.php';
require_once DIR_FS_INC . 'xtc_address_label.inc.php';
require_once DIR_FS_INC . 'xtc_get_country_name.inc.php';
require_once DIR_FS_INC . 'check_country_required_zones.inc.php';
require_once DIR_FS_INC . 'secure_form.inc.php';
require_once DIR_FS_INC . 'write_customers_session.inc.php';
require_once DIR_FS_INC . 'clear_checkout_session.inc.php';

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

if (isset($_GET['action']) && ('deleteconfirm' == $_GET['action']) && isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    xtc_db_query(
        "DELETE
           FROM " . TABLE_ADDRESS_BOOK . "
          WHERE address_book_id = '" . (int) $_GET['delete'] . "'
            AND customers_id    = '" . (int) $_SESSION['customer_id'] . "'"
    );

    $messageStack->add_session('addressbook', SUCCESS_ADDRESS_BOOK_ENTRY_DELETED, 'success');

    xtc_redirect(xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
}

// error checking when updating or adding an entry
$process = false;

if (isset($_POST['action']) && (('process' == $_POST['action']) || ('update' == $_POST['action']))) {
    $process = true;

    $valid_params = array(
        'gender',
        'firstname',
        'lastname',
        'street_address',
        'postcode',
        'city',
        'country',
        'state',
        'company',
        'suburb',
        'zone_id',
        'vat',
        'email_address',
        'confirm_email_address',
        'telephone',
        'fax',
    );

    // prepare variables
    foreach ($_POST as $key => $value) {
        if ((!isset(${$key}) || !is_object(${$key})) && in_array($key, $valid_params)) {
            ${$key} = xtc_db_prepare_input($value);
        }
    }

    $required_zones = check_country_required_zones($country);

    $error = false;

    if (ACCOUNT_GENDER == 'true' && '' == $gender) {
        $error = true;
        $messageStack->add('addressbook', ENTRY_GENDER_ERROR);
    }

    if (mb_strlen($firstname, $_SESSION['language_charset']) < ENTRY_FIRST_NAME_MIN_LENGTH) {
        $error = true;
        $messageStack->add('addressbook', ENTRY_FIRST_NAME_ERROR);
    }

    if (mb_strlen($lastname, $_SESSION['language_charset']) < ENTRY_LAST_NAME_MIN_LENGTH) {
        $error = true;
        $messageStack->add('addressbook', ENTRY_LAST_NAME_ERROR);
    }

    if (mb_strlen($street_address, $_SESSION['language_charset']) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
        $error = true;
        $messageStack->add('addressbook', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
        $error = true;
        $messageStack->add('addressbook', ENTRY_POST_CODE_ERROR);
    }

    if (mb_strlen($city, $_SESSION['language_charset']) < ENTRY_CITY_MIN_LENGTH) {
        $error = true;
        $messageStack->add('addressbook', ENTRY_CITY_ERROR);
    }

    if (is_numeric($country) == false) {
        $error = true;
        $messageStack->add('addressbook', ENTRY_COUNTRY_ERROR);
    } else {
        $check_country_query = xtc_db_query(
            "SELECT countries_id
               FROM " . TABLE_COUNTRIES . "
              WHERE countries_id = '" . (int) $country . "'
                AND status = '1'"
        );

        if (xtc_db_num_rows($check_country_query) < 1) {
            $error = true;
            $messageStack->add('addressbook', ENTRY_COUNTRY_ERROR);
        }
    }

    if (ACCOUNT_STATE == 'true') {
        $zone_id               = 0;
        $check_query           = xtc_db_query(
            "SELECT count(*) AS total
               FROM " . TABLE_ZONES     . " z
               JOIN " . TABLE_COUNTRIES . " c  ON c.countries_id   = z.zone_country_id
                                              AND c.required_zones = '1'
              WHERE z.zone_country_id = '" . (int) $country . "'"
        );
        $check                 = xtc_db_fetch_array($check_query);
        $entry_state_has_zones = ($check['total'] > 0);

        if (true == $entry_state_has_zones) {
            $zone_query = xtc_db_query(
                "SELECT DISTINCT zone_id
                            FROM " . TABLE_ZONES . "
                           WHERE zone_country_id  = '" . (int) $country . "'
                             AND (   zone_id      = '" . (int) $state   . "'
                                  OR zone_code    = '" . xtc_db_input($state) . "'
                                  OR zone_name LIKE '" . xtc_db_input($state) . "%')"
            );

            if (xtc_db_num_rows($zone_query) == 1) {
                $zone    = xtc_db_fetch_array($zone_query);
                $zone_id = $zone['zone_id'];
                $state   = '';
            } else {
                $error = true;
                $messageStack->add('addressbook', ENTRY_STATE_ERROR_SELECT);
            }
        } else {
            if (!$required_zones) {
                $state = '';
            } elseif (mb_strlen($state, $_SESSION['language_charset']) < ENTRY_STATE_MIN_LENGTH) {
                $error = true;
                $messageStack->add('addressbook', ENTRY_STATE_ERROR);
            }
        }
    }

    if (check_secure_form($_POST) === false) {
        $messageStack->add('addressbook', ENTRY_TOKEN_ERROR);
        $error = true;
    }

    if (false == $error) {
        $sql_data_array = array(
            'entry_firstname'       => $firstname,
            'entry_lastname'        => $lastname,
            'entry_street_address'  => $street_address,
            'entry_postcode'        => $postcode,
            'entry_city'            => $city,
            'entry_country_id'      => (int) $country,
            'address_last_modified' => 'now()',
        );

        if (ACCOUNT_GENDER == 'true') {
            $sql_data_array['entry_gender'] = $gender;
        }

        if (ACCOUNT_COMPANY == 'true') {
            $sql_data_array['entry_company'] = $company;
        }

        if (ACCOUNT_SUBURB == 'true') {
            $sql_data_array['entry_suburb'] = $suburb;
        }

        if (ACCOUNT_STATE == 'true') {
            $sql_data_array['entry_zone_id'] = (isset($zone_id) ? (int)$zone_id : 0);
            $sql_data_array['entry_state']   = ((isset($state) && !empty($state)) ? $state : '');
        }

        if ('update' == $_POST['action']) {
            xtc_db_perform(
                TABLE_ADDRESS_BOOK,
                $sql_data_array,
                'update',
                "address_book_id = '" . (int) $_GET['edit'] . "' AND customers_id ='" . (int) $_SESSION['customer_id'] . "'"
            );

            // reregister session variables
            if (
                   ($_POST['primary']) && 'on' == $_POST['primary']
                || ((int) $_GET['edit'] == $_SESSION['customer_default_address_id'])
            ) {
                $sql_data_array = array(
                    'customers_firstname'          => $firstname,
                    'customers_lastname'           => $lastname,
                    'customers_default_address_id' => (int) $_GET['edit'],
                    'customers_last_modified'      => 'now()',
                );

                if (ACCOUNT_GENDER == 'true') {
                    $sql_data_array['customers_gender'] = $gender;
                }

                xtc_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int) $_SESSION['customer_id'] . "'");
            }
        } else {
            $sql_data_array['customers_id']       = (int) $_SESSION['customer_id'];
            $sql_data_array['address_date_added'] = 'now()';

            xtc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

            $new_address_book_id = xtc_db_insert_id();

            // reregister session variables
            if (isset($_POST['primary']) && ('on' == $_POST['primary'])) {
                $sql_data_array = array(
                    'customers_firstname'     => $firstname,
                    'customers_lastname'      => $lastname,
                    'customers_last_modified' => 'now()',
                    'customers_date_added'    => 'now()',
                );

                if (ACCOUNT_GENDER == 'true') {
                    $sql_data_array['customers_gender'] = $gender;
                }

                if (isset($_POST['primary']) && ('on' == $_POST['primary'])) {
                    $sql_data_array['customers_default_address_id'] = $new_address_book_id;
                }

                xtc_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int) $_SESSION['customer_id'] . "'");
            }
        }

        // write customers session
        write_customers_session((int)$_SESSION['customer_id']);

        $messageStack->add_session('addressbook', SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED, 'success');

        xtc_redirect(xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
    }
}

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $entry_query = xtc_db_query(
        "SELECT *
           FROM " . TABLE_ADDRESS_BOOK . "
          WHERE customers_id    = '" . (int) $_SESSION['customer_id'] . "'
            AND address_book_id = '" . (int) $_GET['edit'] . "'"
    );

    if (xtc_db_num_rows($entry_query) == false) {
        $messageStack->add_session('addressbook', ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY);

        xtc_redirect(xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
    }

    $entry = xtc_db_fetch_array($entry_query);
} elseif (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if ($_GET['delete'] == $_SESSION['customer_default_address_id']) {
        $messageStack->add_session('addressbook', WARNING_PRIMARY_ADDRESS_DELETION, 'error');

        xtc_redirect(xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
    } else {
        $check_query = xtc_db_query(
            "SELECT count(*) AS total
               FROM " . TABLE_ADDRESS_BOOK . "
              WHERE address_book_id = '" . (int) $_GET['delete']          . "'
                AND customers_id    = '" . (int) $_SESSION['customer_id'] . "'"
        );
        $check       = xtc_db_fetch_array($check_query);

        if ($check['total'] < 1) {
            $messageStack->add_session('addressbook', ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY);

            xtc_redirect(xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
        }
    }
} else {
    $entry = array();
}

if (!isset($_GET['delete']) && !isset($_GET['edit'])) {
    if (xtc_count_customer_address_book_entries() >= MAX_ADDRESS_BOOK_ENTRIES) {
        $messageStack->add_session('addressbook', ERROR_ADDRESS_BOOK_FULL);

        xtc_redirect(xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
    }
}

// include boxes
require DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php';

$breadcrumb->add(NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS, xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $breadcrumb->add(
        NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS,
        xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . (int) $_GET['edit'], 'SSL')
    );
} elseif (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $breadcrumb->add(
        NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS,
        xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . (int) $_GET['delete'], 'SSL')
    );
} else {
    $breadcrumb->add(
        NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS,
        xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL')
    );
}

require DIR_WS_INCLUDES . 'header.php';

if (!isset($_GET['delete'])) {
    $action = xtc_draw_form(
        'addressbook',
        xtc_href_link(
            FILENAME_ADDRESS_BOOK_PROCESS,
            isset($_GET['edit']) ? 'edit=' . $_GET['edit'] : '',
            'SSL'
        ),
        'post',
        'onsubmit="return check_form(addressbook);"'
    )
    . secure_form('address_book_process');
}

$smarty->assign('FORM_ACTION', $action);

if ($messageStack->size('addressbook') > 0) {
    $smarty->assign('error_message', $messageStack->output('addressbook'));
}

if (isset($_GET['delete'])) {
    $smarty->assign('delete', '1');
    $smarty->assign(
        'ADDRESS',
        xtc_address_label($_SESSION['customer_id'], (int) $_GET['delete'], true, ' ', '<br />')
    );
    $smarty->assign(
        'BUTTON_BACK',
        '<a href="' . xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">'
        . xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK)
        . '</a>'
    );
    $smarty->assign(
        'BUTTON_DELETE',
        '<a href="' . xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . (int) $_GET['delete'] . '&action=deleteconfirm', 'SSL') . '">'
        . xtc_image_button('button_delete.gif', IMAGE_BUTTON_DELETE)
        . '</a>'
    );
} else {
    include DIR_WS_MODULES . 'address_book_details.php';

    if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
        $smarty->assign(
            'BUTTON_BACK',
            '<a href="' . xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">'
            . xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK)
            . '</a>'
        );
        $smarty->assign(
            'BUTTON_UPDATE',
            xtc_draw_hidden_field('action', 'update')
            . xtc_draw_hidden_field('edit', $_GET['edit'])
            . xtc_image_submit('button_update.gif', IMAGE_BUTTON_UPDATE)
        );
    } else {
        $smarty->assign(
            'BUTTON_BACK',
            '<a href="' . xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">'
            . xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK)
            . '</a>'
        );
        $smarty->assign(
            'BUTTON_UPDATE',
            xtc_draw_hidden_field('action', 'process')
            . xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE)
        );
    }
    $smarty->assign('FORM_END', '</form>');
}

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$main_content    = $smarty->fetch(CURRENT_TEMPLATE . '/module/address_book_process.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;

if (!defined('RM')) {
    $smarty->load_filter('output', 'note');
}

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include 'includes/application_bottom.php';
