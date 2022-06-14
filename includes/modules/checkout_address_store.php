<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout_address_store.php 10398 2016-11-08 11:11:27Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
     Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

    require_once (DIR_FS_INC.'check_country_required_zones.inc.php');

    $valid_params = array(
      'gender',
      'firstname',
      'lastname',
      'street_address',
      'postcode',
      'city',
      'country',
      'company',
      'suburb',
      'state',
    );

    // prepare variables
    foreach ($_POST as $key => $value) {
      if (!is_object(${$key}) && in_array($key , $valid_params)) {
        ${$key} = xtc_db_prepare_input($value);
      }
    }

    $required_zones = check_country_required_zones($country);

    $process = true;

    if (ACCOUNT_GENDER == 'true' && $gender == '') {
      $error = true;
      $messageStack->add('checkout_address', ENTRY_GENDER_ERROR);
    }

    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;
      $messageStack->add('checkout_address', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;
      $messageStack->add('checkout_address', ENTRY_LAST_NAME_ERROR);
    }

    if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      $error = true;
      $messageStack->add('checkout_address', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      $error = true;
      $messageStack->add('checkout_address', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;
      $messageStack->add('checkout_address', ENTRY_CITY_ERROR);
    }

    if (ACCOUNT_STATE == 'true') {
      $zone_id = 0;
      $check_query = xtc_db_query("SELECT count(*) AS total  
                                     FROM ".TABLE_ZONES." z 
                                     JOIN ".TABLE_COUNTRIES." c 
                                          ON c.countries_id = z.zone_country_id 
                                             AND c.required_zones = '1' 
                                    WHERE z.zone_country_id = '".(int)$country."'"); 
      $check = xtc_db_fetch_array($check_query);
      $entry_state_has_zones = ($check['total'] > 0);
      if ($entry_state_has_zones == true) {
          $zone_query = xtc_db_query("SELECT DISTINCT zone_id
                                                 FROM ".TABLE_ZONES."
                                                WHERE zone_country_id = '".(int)$country ."'
                                                  AND (zone_id = '" . (int)$state . "'
                                                       OR zone_code = '" . xtc_db_input($state) . "'
                                                       OR zone_name LIKE '" . xtc_db_input($state) . "%'
                                                       )");
        if (xtc_db_num_rows($zone_query) == 1) {
          $zone = xtc_db_fetch_array($zone_query);
          $zone_id = $zone['zone_id'];
          $state = '';
        } else {
          $error = true;
          $messageStack->add('checkout_address', ENTRY_STATE_ERROR_SELECT);
        }
      } else {
        if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
          $error = true;
          $messageStack->add('checkout_address', ENTRY_STATE_ERROR);
        }
      }
    }

    if ((is_numeric($country) == false) || ($country < 1)) {
      $error = true;
      $messageStack->add('checkout_address', ENTRY_COUNTRY_ERROR);
    } else {
      $check_country_query = xtc_db_query("SELECT countries_id
                                             FROM ".TABLE_COUNTRIES."
                                            WHERE countries_id = '".(int)$country."'
                                              AND status = '1'");
      if (xtc_db_num_rows($check_country_query) < 1) {
        $error = true;
        $messageStack->add('checkout_address', ENTRY_COUNTRY_ERROR);
      }
    }

    if (check_secure_form($_POST) === false) {
      $messageStack->add('checkout_address', ENTRY_TOKEN_ERROR);
      $error = true;
    }

    if ($error == false) {
      $sql_data_array = array ('customers_id' => (int)$_SESSION['customer_id'],
                               'entry_firstname' => $firstname,
                               'entry_lastname' => $lastname,
                               'entry_street_address' => $street_address,
                               'entry_postcode' => $postcode,
                               'entry_city' => $city,
                               'entry_country_id' => (int)$country,
                               'address_date_added' => 'now()');

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
        $sql_data_array['entry_state'] = (isset($state) ? $state : '');
      }

      xtc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);      
      
      //SWITCH shipping/payment
      switch ($checkout_page) {
        case 'shipping':
          $_SESSION['sendto'] = xtc_db_insert_id();
          xtc_redirect(xtc_href_link($link_checkout_shipping, $params, 'SSL'));
          break;
        case 'payment':
          $_SESSION['billto'] = xtc_db_insert_id();
          if ($_SESSION['shipping'] === false) {
            $_SESSION['sendto'] = $_SESSION['billto'];
          }
          if (isset ($_SESSION['payment']) && !isset($_SESSION['paypal']['PayerID'])) {
            unset ($_SESSION['payment']);
          } 
          xtc_redirect(xtc_href_link($link_checkout_payment, $params, 'SSL'));          
          break;      
      }       
    }
