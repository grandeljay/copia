<?php
/* -----------------------------------------------------------------------------------------
   $Id: PayPalCommon.php 14191 2022-03-24 07:03:40Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


// include needed classes
require_once(DIR_FS_EXTERNAL.'paypal/classes/PayPalAuth.php');


// used classes
use PayPal\Api\FlowConfig; 
use PayPal\Api\Presentation; 
use PayPal\Api\WebProfile; 
use PayPal\Api\InputFields; 


class PayPalCommon extends PayPalAuth {


  function __construct() {

  }
  
  
  function link_encoding($string) {
    $string = str_replace('&amp;', '&', $string);
    
    return $string;
  }
  
  
  function encode_utf8($string) {
    if (is_array($string)) {
      foreach ($string as $key => $value) {
        $string[$key] = $this->encode_utf8($value);
      }
    } else {
      if (!is_bool($string)) {
        $string = decode_htmlentities($string);
        $cur_encoding = mb_detect_encoding($string);
        if ($cur_encoding == "UTF-8" && mb_check_encoding($string, "UTF-8")) {
          return $string;
        } else {
          return mb_convert_encoding($string, "UTF-8", $_SESSION['language_charset']);
        }
      }
    }
    
    return $string;  
  }

  
  function decode_utf8($string) {   
    if (is_array($string)) {
      foreach ($string as $key => $value) {
        $string[$key] = $this->decode_utf8($value);
      }
    } else {
      if (!is_bool($string)) {
        $string = decode_utf8($string);
      }
    }
    
    return $string;
  }
  
  
  function format_price_currency($price) {
    $xtPrice = new xtcPrice('EUR', $_SESSION['customers_status']['customers_status_id']);
    return $xtPrice->xtcFormat($price, true);
  }


	function get_min_installment_amount() {
		return array(
		  'amount' => 99.00, 
		  'currency' => 'EUR',
		);
	}


	function get_max_installment_amount() {
		return array(
		  'amount' => 5000.00, 
		  'currency' => 'EUR',
		);
	}


  function save_config($sql_data_array) {
    if (is_array($sql_data_array) && count($sql_data_array) > 0) {
      foreach ($sql_data_array as $sql_data) {        
        $this->delete_config($sql_data['config_key']);
        xtc_db_perform(TABLE_PAYPAL_CONFIG, $sql_data);
      }
    }
  }


  function delete_config($value, $col = 'config_key') {
    xtc_db_query("DELETE FROM ".TABLE_PAYPAL_CONFIG." WHERE ".$col." = '".xtc_db_input($value)."'");
  }


  function get_config($config_key) {
    static $config_array;
    
    if (!is_array($config_array)) {
      $config_array = array();
    }
    
    if (!isset($config_array[$config_key])) {
      $config_array[$config_key] = '';
      $config_query = xtDBquery("SELECT config_value 
                                   FROM ".TABLE_PAYPAL_CONFIG." 
                                  WHERE config_key = '".xtc_db_input($config_key)."'");
      if (xtc_db_num_rows($config_query, true) > 0) {
        $config = xtc_db_fetch_array($config_query, true);
        $config_array[$config_key] = $config['config_value'];
      }
    }
    
    return $config_array[$config_key];
  }


  function get_totals($totals, $calc_total = false, $subtotal = 0) {
    global $order;
    
    for ($i = 0, $n = sizeof($totals); $i < $n; $i ++) {
      switch(((isset($totals[$i]['code'])) ? $totals[$i]['code'] : $totals[$i]['class'])) {
        case 'ot_subtotal':
          $sortorder_subtotal = $totals[$i]['sort_order'];
          break;
      }
    }
    
    for ($i = 0, $n = sizeof($totals); $i < $n; $i ++) {
      switch(((isset($totals[$i]['code'])) ? $totals[$i]['code'] : $totals[$i]['class'])) {
        case 'ot_subtotal_no_tax':
          break;
        case 'ot_subtotal':
          $this->details->setSubtotal((($subtotal > 0) ? $subtotal : $totals[$i]['value']));
          break;
        case 'ot_total':
          $this->amount->setTotal($totals[$i]['value']);
          break;
        case 'ot_shipping':
          $this->details->setShipping($totals[$i]['value']);
          break;
        case 'ot_tax':
          if (($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 
               && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1
               ) || ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 
                     && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0
                     && $order->delivery['country_id'] == STORE_COUNTRY
                     )
              ) 
          {
            $this->details->setTax($this->details->getTax() + $totals[$i]['value']);
          }
          break;
        default:
          if ($totals[$i]['sort_order'] > $sortorder_subtotal) {
            if($totals[$i]['value'] < 0) {
              $this->details->setDiscount($this->details->getDiscount() + ($totals[$i]['value'] * (-1)));
            } else {
              $this->details->setHandlingFee($this->details->getHandlingFee() + $totals[$i]['value']);
            }
          }
          break;
      }
    }
    
    $total = $this->calc_total();
    $amount_total = $this->amount->getTotal();

    if ($calc_total === true && $this->details->getSubtotal() > 0) {
      $this->amount->setTotal($total);
    } elseif ((($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 
                && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1
                ) || ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 
                      && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0
                      && $order->delivery['country_id'] == STORE_COUNTRY
                      )
              ) && $this->details->getDiscount() == 0
             ) 
    {      
      if ((string)$amount_total != (string)$total) {
        $this->details->setTax($this->details->getTax() + ($amount_total - $total));
      } 
    } else {
      if ((string)$amount_total != (string)$total) {
        if ($this->details->getDiscount() > 0) {
          $this->details->setDiscount($this->details->getDiscount() + (($amount_total - $total) * (-1)));
        } elseif ($this->details->getHandlingFee() > 0) {
          $this->details->setHandlingFee($this->details->getHandlingFee() + ($amount_total - $total));
        }
      }
    }
  }

  
  function calc_total() {
    $total = 0;
    $total += $this->details->getSubtotal();
    $total += $this->details->getShipping();
    $total += $this->details->getTax();
    $total += $this->details->getHandlingFee();
    $total += $this->details->getShippingDiscount();
    $total += $this->details->getInsurance();
    $total += $this->details->getGiftWrap();
    $total += $this->details->getFee();
    $total -= $this->details->getDiscount();
    
    return $total;
  }
  
  
  function fix_totals($totals) {
          
    for ($i = 0, $n = sizeof($totals); $i < $n; $i ++) {
      switch(((isset($totals[$i]['code'])) ? $totals[$i]['code'] : $totals[$i]['class'])) {
        case 'ot_tax':
          $this->details->setTax($this->details->getTax() + $totals[$i]['value']);
          $this->amount->setTotal($this->amount->getTotal() + $totals[$i]['value']);
          break;            
      }
    }
  }


  function check_discount() {
    if ($this->details->getHandlingFee() > 0
        || $this->details->getShippingDiscount() < 0
        || $this->details->getInsurance() > 0
        || $this->details->getGiftWrap() > 0
        || $this->details->getFee() > 0
        || $this->details->getDiscount() > 0
        )
    {
      return true;
    }
    return false;
  }


  function get_shipping_cost() {
    global $order, $PHP_SELF;
    
    $shipping_cost = $order->info['shipping_cost'];
    
    if ($shipping_cost > 0) {
      if (basename($PHP_SELF) == FILENAME_CHECKOUT_PAYMENT) {
        $shipping_modul = explode('_',$order->info['shipping_class']);
        $shipping_tax_class = constant('MODULE_SHIPPING_'.strtoupper($shipping_modul[0]).'_TAX_CLASS');
        $shipping_tax_rate = xtc_get_tax_rate($shipping_tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        $shipping_cost = $order->info['shipping_cost'] * (1 + ($shipping_tax_rate / 100));
      }
    }
    return $shipping_cost;
  }


  function calculate_total($mode = 1) {
    global $order, $free_shipping, $free_shipping_value_over;
    
    $order_backup = $order;
    
    if (isset($_SESSION['shipping'])) {
      if (!class_exists('shipping')) {
        require_once (DIR_WS_CLASSES . 'shipping.php');
      }
      $shipping_modules = new shipping($_SESSION['shipping']);
    }
    
    if (!class_exists('order')) {
      require_once (DIR_WS_CLASSES . 'order.php');
    }
    $order = new order();
    
    if (!class_exists('order_total')) {
      require_once (DIR_WS_CLASSES . 'order_total.php');
    }
    $free_shipping = false;
    $order_total_modules = new order_total();
    $order_total = $order_total_modules->process();
    
    $this->free_shipping = $free_shipping;
    $this->free_shipping_value_over = $free_shipping_value_over;
    
    $total = $order->info['total'];

    $order = $order_backup;
    
    if ($mode == 1) return $total;
    if ($mode == 2) return $order_total;
    if ($mode == 3) return $free_shipping;
  }

  
  function get_payment_profile_data() {
    $address_override = false;
    $profile_id = $this->get_config('PAYPAL_'.strtoupper($this->code.'_'.$_SESSION['language_code']).'_PROFILE');
    
    if ($profile_id == '') {
      $profile_id = $this->get_config('PAYPAL_STANDARD_PROFILE');
    }
    
    if ($profile_id != '') {
      if ($this->get_config(strtoupper($profile_id).'_TIME') < (time() - (3600 * 24))) {
        $profile = $this->get_profile($profile_id);
        
        if (count($profile) > 0) {
          $sql_data_array = array(
            array(
              'config_key' => strtoupper($profile_id).'_TIME', 
              'config_value' => time(),
            ),
            array(
              'config_key' => strtoupper($profile_id).'_ADDRESS', 
              'config_value' => $profile[0]['input_fields']['address_override'],
            ),
          );
          $this->save_config($sql_data_array);
          $address_override = (($profile[0]['input_fields']['address_override'] == '0') ? true : false);
        } else {
          $profile_id = $this->delete_profile($profile_id);
        }
      } else {
        $address_override = (($this->get_config(strtoupper($profile_id).'_ADDRESS') == '0') ? true : false);
      }
    }
    
    return array(
      'profile_id' => $profile_id,
      'address_override' => $address_override,
    );
  }
  
  
  function get_profile($id) {
  
    // auth
    $apiContext = $this->apiContext();
  
    // set WebProfile
    $webProfile = new WebProfile();
      
    try {
      $webProfileList = $webProfile->get($id, $apiContext);
      $valid = true;
    } catch (Exception $ex) {
      $this->LoggingManager->log('DEBUG', 'Profile', array('exception' => $ex));
      $valid = false;
    }
  
    // set array
    $list_array = array();
  
    if ($valid === true) {      
      $profile = $webProfileList;        
      $flowConfig = $profile->getFlowConfig();
      $inputFields = $profile->getInputFields();
      $presentation = $profile->getPresentation();
    
      $list_array[] = array(
        'id' => $profile->getId(),
        'name' => $profile->getName(),
        'status' => (($this->get_config('PAYPAL_STANDARD_PROFILE') == $profile->getId()) ? true : false),
        'flow_config' => array(
          'landing_page_type' => ((is_object($flowConfig)) ? $flowConfig->getLandingPageType() : ''),
          'user_action' => ((is_object($flowConfig)) ? $flowConfig->getUserAction() : ''),
        ),
        'input_fields' => array(
          'allow_note' => ((is_object($inputFields)) ? $inputFields->getAllowNote() : ''),
          'no_shipping' => ((is_object($inputFields)) ? $inputFields->getNoShipping() : ''),
          'address_override' => ((is_object($inputFields)) ? $inputFields->getAddressOverride() : ''),
        ),
        'presentation' => array(
          'brand_name' => ((is_object($presentation)) ? $presentation->getBrandName() : ''),
          'logo_image' => ((is_object($presentation)) ? $presentation->getLogoImage() : ''),
          'locale_code' => ((is_object($presentation)) ? $presentation->getLocaleCode() : ''),
        ),
      );
    }
      
    return $list_array;    
  }


  function delete_profile($id) {

    // auth
    $apiContext = $this->apiContext();

    // set WebProfile
    $webProfile = new WebProfile();
    $webProfile->setId($id);

    try {
      $webProfile->delete($apiContext);
    } catch (Exception $ex) {
      $this->LoggingManager->log('DEBUG', 'Profile', array('exception' => $ex));
    }
    
    if ($id == $this->get_config('PAYPAL_STANDARD_PROFILE')) {
      $this->delete_config('PAYPAL_STANDARD_PROFILE');
    }

    $this->delete_config($id, 'config_value');
  }


  function login_customer($customer, $customer_id = '') {
    global $econda, $messageStack;
    
    // include needed function
    require_once (DIR_FS_INC.'xtc_write_user_info.inc.php');
    require_once (DIR_FS_INC.'write_customers_session.inc.php');
    
    $where = " WHERE customers_email_address = '".xtc_db_input($customer['info']['email_address'])."' AND account_type = '0' ";
    if ($customer_id != '') {
      $where = " WHERE customers_id = '".(int)$customer_id."' ";
    }
    
    // check if customer exists
    $check_customer_query = xtc_db_query("SELECT *
                                            FROM ".TABLE_CUSTOMERS." 
                                                 ".$where);
    if (xtc_db_num_rows($check_customer_query) < 1) {
      $this->create_account($customer);
    } else {
      if (SESSION_RECREATE == 'True') {
        xtc_session_recreate();
      }
      $check_customer = xtc_db_fetch_array($check_customer_query);
 
			$_SESSION['customer_id'] = $check_customer['customers_id'];
      
      if (isset($check_customer['customers_password_time'])) {
        $_SESSION['customer_time'] = $check_customer['customers_password_time'];
        if ($_SESSION['customer_time'] == 0) {
          $_SESSION['customer_time'] = time();
          xtc_db_query("UPDATE ".TABLE_CUSTOMERS."
                           SET customers_password_time = '".(int)$_SESSION['customer_time']."'
                         WHERE customers_id = '".(int)$_SESSION['customer_id']."' ");
        }
      }
      
			xtc_db_query("UPDATE ".TABLE_CUSTOMERS_INFO." 
			                 SET customers_info_date_of_last_logon = now(), 
			                     customers_info_number_of_logons = customers_info_number_of_logons+1 
			               WHERE customers_info_id = '".(int)$_SESSION['customer_id']."'");
			               
      // write customers status session
      require(DIR_WS_INCLUDES.'write_customers_status.php');

      // write customers session
      write_customers_session((int)$_SESSION['customer_id']);

      // user info
			xtc_write_user_info((int)$_SESSION['customer_id']);

			// restore cart contents
			$_SESSION['cart']->restore_contents();
      
      // set cartID
      $_SESSION['paypal']['cartID'] = $_SESSION['cart']->cartID;
      
			// restore wishlist contents
			if (isset($_SESSION['wishlist'])
			    && is_object($_SESSION['wishlist'])
			    )
			{
			  $_SESSION['wishlist']->restore_contents();
			}
			
			if (isset($econda) && is_object($econda)) {
			  $econda->_loginUser();			
      }
      if ($_SESSION['old_customers_basket_cart'] === true) {
        unset($_SESSION['old_customers_basket_cart']);
        unset($_SESSION['paypal']);
        
        $messageStack->add_session('info_message_3', TEXT_SAVED_BASKET);
        xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, ''), 'NONSSL'); 
      }
    }
     
  }
  
  
  function create_account($customer) {
        
    // include needed function
    require_once (DIR_FS_INC.'xtc_encrypt_password.inc.php');
    require_once (DIR_FS_INC.'xtc_create_password.inc.php');
    require_once (DIR_FS_INC.'generate_customers_cid.inc.php');

    $password = xtc_create_password(8);
    
    $sql_data_array = array(
      'customers_status' => DEFAULT_CUSTOMERS_STATUS_ID_GUEST,
      'customers_gender' => $customer['info']['gender'],
      'customers_firstname' => $customer['customers']['customers_firstname'],
      'customers_lastname' => $customer['customers']['customers_lastname'],
      'customers_email_address' => $customer['info']['email_address'],
      'customers_telephone' => $customer['info']['telephone'],
      'customers_dob' => xtc_date_raw($customer['info']['dob']),
      'customers_password' => xtc_encrypt_password($password),
      'customers_date_added' => 'now()',
      'customers_last_modified' => 'now()',
      'account_type' => '1',
    );

    if (ACCOUNT_OPTIONS == 'account') {
      $sql_data_array['account_type'] = '0';
      $sql_data_array['customers_cid'] = generate_customers_cid(true);
      $sql_data_array['customers_status'] = DEFAULT_CUSTOMERS_STATUS_ID;
      $sql_data_array['password_request_time'] = 'now()';
      
      // send password with order mail
      $_SESSION['paypal_express_new_customer'] = 'true';
    }

    if (is_file(DIR_FS_INC.'get_database_version.inc.php')) {
      require_once (DIR_FS_INC.'get_database_version.inc.php');
      $version = get_database_version();
      if (version_compare('2.0.5.1', $version['plain'], '<')) {
        $_SESSION['customer_time'] = time();
        $sql_data_array['customers_password_time'] = $_SESSION['customer_time'];
      }    
    }
    
    xtc_db_perform(TABLE_CUSTOMERS, $sql_data_array);

    $customer_id = xtc_db_insert_id();
    
    $data = $customer['customers'];
    $data['gender'] = $customer['info']['gender'];
    
    $address_id = $this->create_address_book($customer_id, $data);
    
    xtc_db_query("UPDATE " . TABLE_CUSTOMERS . " 
                     SET customers_default_address_id = '" . (int)$address_id . "' 
                   WHERE customers_id = '" . (int)$customer_id . "'");
    
    $sql_data_array = array(
      'customers_info_id' => (int)$customer_id,
      'customers_info_number_of_logons' => '1',
      'customers_info_date_account_created' => 'now()',
      'customers_info_date_of_last_logon' => 'now()'
    );
    xtc_db_perform(TABLE_CUSTOMERS_INFO, $sql_data_array);
        
    // login
    $this->login_customer($customer, $customer_id);
  }


  function create_address_book($customer_id, $data, $shipping = false) {
    
    $type = 'customers';
    if ($shipping === true) {
      $type = 'delivery';
    }
    
    $sql_data_array = array(
      'customers_id' => $customer_id,
      'entry_gender' => ((isset($data['gender'])) ? $data['gender'] : ''),
      'entry_firstname' => $data[$type.'_firstname'],
      'entry_lastname' => $data[$type.'_lastname'],
      'entry_company' => $data[$type.'_company'],
      'entry_street_address' => $data[$type.'_street_address'],
      'entry_suburb' => $data[$type.'_suburb'],
      'entry_postcode' => $data[$type.'_postcode'],
      'entry_city' => $data[$type.'_city'],
      'entry_country_id' => $data[$type.'_country_id'],
      'entry_zone_id' => $data[$type.'_zone_id'],
      'entry_state' => $data[$type.'_state'],
      'address_date_added' => 'now()',
      'address_last_modified' => 'now()'
    );
        
    xtc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

    $address_id = xtc_db_insert_id();
    
    return $address_id;
  }
  

  function get_shipping_address($customer_id, $data) {
    
    $where = '';
    if (ACCOUNT_COMPANY == 'true' && isset($data['delivery_company'])) {
      $where .= " AND entry_company = '".xtc_db_input($data['delivery_company'])."'";
    }
    if (ACCOUNT_SUBURB == 'true' && isset($data['delivery_suburb'])) {
      $where .= " AND entry_suburb = '".xtc_db_input($data['delivery_suburb'])."'";
    }
    if (ACCOUNT_STATE == 'true' && isset($data['delivery_zone_id'])) {
      $where .= " AND entry_zone_id = '".xtc_db_input($data['delivery_zone_id'])."'";
      $where .= " AND entry_state = '".xtc_db_input($data['delivery_state'])."'";
    }

    $check_address_query = xtc_db_query("SELECT address_book_id
                                           FROM ".TABLE_ADDRESS_BOOK."
                                          WHERE customers_id = '".$customer_id."'
                                                ".$where."
                                            AND entry_firstname = '".xtc_db_input($data['delivery_firstname'])."'
                                            AND entry_lastname = '".xtc_db_input($data['delivery_lastname'])."'
                                            AND entry_street_address = '".xtc_db_input($data['delivery_street_address'])."'
                                            AND entry_postcode = '".xtc_db_input($data['delivery_postcode'])."'
                                            AND entry_city = '".xtc_db_input($data['delivery_city'])."'
                                            AND entry_lastname = '".xtc_db_input($data['delivery_lastname'])."'
                                            AND entry_lastname = '".xtc_db_input($data['delivery_lastname'])."'");
    if (xtc_db_num_rows($check_address_query) == 1) {
      $check_address = xtc_db_fetch_array($check_address_query);
      $address_id = $check_address['address_book_id'];
    } else {
      $address_id = $this->create_address_book($customer_id, $data, true);
    }
        
    return $address_id;
  }
  
}
?>