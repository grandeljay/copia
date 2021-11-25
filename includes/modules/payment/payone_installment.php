<?php
/* -----------------------------------------------------------------------------------------
   $Id: payone_installment.php 10256 2016-08-20 15:02:28Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
 	 based on:
	  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
	  (c) 2002-2003 osCommerce - www.oscommerce.com
	  (c) 2001-2003 TheMedia, Dipl.-Ing Thomas Plänkers - http://www.themedia.at & http://www.oscommerce.at
	  (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com
    (c) 2013 Gambio GmbH - http://www.gambio.de
  
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once (DIR_FS_EXTERNAL.'payone/classes/PayonePayment.php');

class payone_installment extends PayonePayment {
	var $payone_genre = 'installment';

	function __construct() {
	  global $order;
	  
		$this->code = 'payone_installment';
		parent::__construct();
		$this->form_action_url = '';

		$this->installmenttypes = array(
			'billsafe' => 'BSV',
			'commerzfinanz' => 'CFR',
			'klarna' => 'KLV',
			'payolution_financing' => 'PYS',
			'payolution_monthly' => 'PYM',
		);
		
		$this->klarnalocale = array(
		  'DE' => array('locale' => 'de_DE',
		                'agb' => 'true',
		                'confirm' => 'true',
		                'required' => array('addressaddition' => ((isset($_SESSION[$this->code]['installment_addressaddition'])) ? $_SESSION[$this->code]['installment_addressaddition'] : '')),
		                ),
		  'AT' => array('locale' => 'de_AT',
		                'agb' => 'true',
		                'confirm' => 'true',
		                'required' => array(),
		                ),
		  'NL' => array('locale' => 'en_NL',
		                'agb' => 'true',
		                'confirm' => 'false',
		                'required' => array('addressaddition' => ((isset($_SESSION[$this->code]['installment_addressaddition'])) ? $_SESSION[$this->code]['installment_addressaddition'] : '')),
		                ),
		  'DK' => array('locale' => 'en_DK',
		                'agb' => 'true',
		                'confirm' => 'false',
		                'required' => array('personalid' => ((isset($_SESSION[$this->code]['installment_personalid'])) ? $_SESSION[$this->code]['installment_ainstallment_personalidddressaddition'] : '')),
		                ),
		  'FI' => array('locale' => 'en_FI',
		                'agb' => 'true',
		                'confirm' => 'false',
		                'required' => array('personalid' => ((isset($_SESSION[$this->code]['installment_personalid'])) ? $_SESSION[$this->code]['installment_ainstallment_personalidddressaddition'] : '')),
		                ),
		  'NO' => array('locale' => 'en_NO',
		                'agb' => 'true',
		                'confirm' => 'false',
		                'required' => array('personalid' => ((isset($_SESSION[$this->code]['installment_personalid'])) ? $_SESSION[$this->code]['installment_ainstallment_personalidddressaddition'] : '')),
		                ),
		  'SE' => array('locale' => 'en_SE',
		                'agb' => 'true',
		                'confirm' => 'false',
		                'required' => array('personalid' => ((isset($_SESSION[$this->code]['installment_personalid'])) ? $_SESSION[$this->code]['installment_ainstallment_personalidddressaddition'] : '')),
		                ),
		);
	}
  
  function _payment_plan($active_genre_identifier) {
		$financingtype = $this->installmenttypes[$_SESSION[$this->code]['installment_type']];
		$standard_parameters = parent::_standard_parameters('preauthorization');

		$this->personal_data = new Payone_Api_Request_Parameter_Authorization_PersonalData();
		parent::_set_customers_standard_params();
		    
		$this->delivery_data = new Payone_Api_Request_Parameter_Authorization_DeliveryData();
		parent::_set_customers_shipping_params();

    $paydata = new Payone_Api_Request_Parameter_Paydata_Paydata();
    $paydata->addItem(
      new Payone_Api_Request_Parameter_Paydata_DataItem(
        array('key' => 'action', 'data' => 'calculation')
      )
    );
    
		$financing = new Payone_Api_Request_Parameter_Authorization_PaymentMethod_Financing();
		$financing->setFinancingtype($financingtype);
    
    $request_parameters = parent::_request_parameters('fnc');
    $request_parameters['paydata'] = $paydata;
    $request_parameters['financingtype'] = $financing;

		$this->params = array_merge($standard_parameters, $request_parameters);		
		
		$this->builder = new Payone_Builder($this->payone->getPayoneConfig());

    $this->service = $this->builder->buildServicePaymentGenericpayment();
    $this->params['request'] = 'genericpayment';
    
    $this->request = new Payone_Api_Request_Genericpayment($this->params);
    $this->response = $this->service->request($this->request);

    if ($this->response instanceof Payone_Api_Response_Genericpayment_Ok) {
      $_SESSION[$this->code]['workorderid'] = $this->response->getWorkorderId();
      $payment_plan = $this->response->getPaydata();
      $payment_plan_array = $payment_plan->toAssocArray();
      ksort($payment_plan_array);
      foreach ($payment_plan_array as $key => $value) {
        preg_match_all('!\d+!', $key, $matches);
        
        $index = $matches[0][0];
        if (count($matches[0]) == 1) {
          $name = str_replace('PaymentDetails_'.$index.'_', '', $key);
          $payment_array[$index][$name] = $value;
          if ($name == 'StandardCreditInformationUrl') {
            $payment_array[$index][$name] = $this->save_contract($active_genre_identifier, $value, $index);
          }
        } else {
          $name = str_replace('PaymentDetails_'.$index.'_Installment_'.$matches[0][1].'_', '', $key);
          $payment_array[$index]['plan'][$matches[0][1]][$name] = $value;
          ksort($payment_array[$index]['plan']);
        }        
      }
      
      return $payment_array;

    } elseif ($this->response instanceof Payone_Api_Response_Error) {
      $_SESSION['payone_error'] = $this->response->getCustomermessage();
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code, 'SSL', true));		
    } else {
			die('unhandled response type');
    }
  }
  
  function save_contract($active_genre_identifier, $url, $id) {
    $filename = 'contract_'.strtolower($_SESSION[$this->code]['workorderid']).'_'.$id.'.pdf';
    
    $fp = fopen(SQL_CACHEDIR.$filename, 'w+');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_USERPWD, $this->config[$active_genre_identifier]['genre_specific']['payolution']['channelid'].':'.$this->config[$active_genre_identifier]['genre_specific']['payolution']['channelpwd']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    
    return xtc_href_link('cache/'.$filename, '', 'SSL', false);
  }
  
	function _paymentDataFormProcess($active_genre_identifier) {
	  global $order;
	  
	  require_once(DIR_FS_INC.'xtc_date_short.inc.php');
	  
	  $payment_smarty = new Smarty();
	  $payment_smarty->template_dir = DIR_FS_EXTERNAL.'payone/templates/';

		$error = parent::get_error();
		if ($error != '') {
		  $payment_smarty->assign('error', $error['error']);
		}
    
    $genre_config = $this->config[$active_genre_identifier];
    $global_config = $genre_config['global_override'] == 'true' ? $genre_config['global'] : $this->config['global'];
        
    foreach ($genre_config['types'] as $type_name => $type_config) {
      if ($type_config['active'] == 'true') {
        if ($type_name == 'payolution_financing' && $_SESSION[$this->code]['installment_type'] == 'payolution_financing') {
            $required_fields = array(
              'customers_telephone' => $_SESSION[$this->code]['installment_customers_telephone'],
              'iban' => $_SESSION[$this->code]['installment_iban'],
              'bic' => $_SESSION[$this->code]['installment_bic'],
            );
            
            if ($order->billing['company'] != '' || $order->customer['company'] != '') {
              $required_fields['company_uid'] = $_SESSION[$this->code]['installment_company_uid'];
              $required_fields['company_trade_registry_number'] = $_SESSION[$this->code]['installment_company_trade_registry_number'];
              $required_fields['company_register_key'] = $_SESSION[$this->code]['installment_company_register_key'];
            } else {
              $required_fields = array_reverse($required_fields, true);
              $required_fields['customers_dob'] = $_SESSION[$this->code]['installment_customers_dob'];
              $required_fields = array_reverse($required_fields, true);
            }
            $payment_smarty->assign('required_fields', $required_fields);                        
            $payment_smarty->assign('installment_plan', $this->_payment_plan($active_genre_identifier));                        
            $payment_smarty->assign('confirm_text', TEXT_PAYOLUTION_CONFIRM);
        }
        if ($type_name == 'payolution_monthly' && $_SESSION[$this->code]['installment_type'] == 'payolution_monthly') {
            $required_fields = array(
              'customers_telephone' => $_SESSION[$this->code]['installment_customers_telephone'],
            );
            if ($order->billing['company'] != '' || $order->customer['company'] != '') {
              $required_fields['company_uid'] = $_SESSION[$this->code]['installment_company_uid'];
              $required_fields['company_trade_registry_number'] = $_SESSION[$this->code]['installment_company_trade_registry_number'];
              $required_fields['company_register_key'] = $_SESSION[$this->code]['installment_company_register_key'];
            } else {
              $required_fields = array_reverse($required_fields, true);
              $required_fields['customers_dob'] = $_SESSION[$this->code]['installment_customers_dob'];
              $required_fields = array_reverse($required_fields, true);
            }
            $payment_smarty->assign('required_fields', $required_fields);                        
            $payment_smarty->assign('confirm_text', TEXT_PAYOLUTION_CONFIRM);
        }
        if ($type_name == 'klarna' && $_SESSION[$this->code]['installment_type'] == 'klarna') {
          if (in_array($order->billing['country']['iso_code_2'], $genre_config['genre_specific']['klarna']['countries'])) {
            $required_fields = array(
              'customers_dob' => $_SESSION[$this->code]['installment_customers_dob'], 
              'customers_telephone' => $_SESSION[$this->code]['installment_customers_telephone']
            );
            $required_fields = array_merge($required_fields, $this->klarnalocale[$order->billing['country']['iso_code_2']]['required']);

            $payment_smarty->assign('required_fields', $required_fields);                        
            $payment_smarty->assign('invoice_js', '<script>
                                                     new Klarna.Terms.Invoice({  
                                                       el: \'invoice\',
                                                       eid: \''.$genre_config['genre_specific']['klarna']['storeid'].'\',
                                                       locale: \''.$this->klarnalocale[$order->billing['country']['iso_code_2']]['locale'].'\',
                                                       charge: 0
                                                     });
                                                   </script>');
            if ($this->klarnalocale[$order->billing['country']['iso_code_2']]['confirm'] == 'true') {
              $payment_smarty->assign('confirm_text', sprintf(TEXT_KLARNA_CONFIRM, '<span id="conset"></span>'));
              $payment_smarty->assign('confirm_js', '<script>
                                                       new Klarna.Terms.Consent({  
                                                         el: \'conset\',
                                                         eid: \''.$genre_config['genre_specific']['klarna']['storeid'].'\',
                                                         locale: \''.$this->klarnalocale[$order->billing['country']['iso_code_2']]['locale'].'\'
                                                       });
                                                     </script>');
            }
          }
        }
      }
    }
		
    $payment_smarty->assign('payonecss', DIR_WS_EXTERNAL.'payone/css/payone.css');
        
    $payment_smarty->caching = 0;
    $module_form = $payment_smarty->fetch('checkout_payone_installment_form.html');
		
		return $module_form;
	}
  
	function _paymentDataForm($active_genre_identifier) {
	  global $order;
	  	  
	  $payment_smarty = new Smarty();
    $payment_smarty->template_dir = DIR_FS_EXTERNAL.'payone/templates/';
    
		$genre_config = $this->config[$active_genre_identifier];		
    
		foreach ($genre_config['types'] as $key => $value) {
		  switch ($key) {
        case 'klarna':
          if ($genre_config['types']['klarna']['active'] == 'true') {
            if ($genre_config['genre_specific']['klarna']['storeid'] == '' || !in_array($order->billing['country']['iso_code_2'], $genre_config['genre_specific']['klarna']['countries'])) {            
              unset($genre_config['types']['klarna']);
            }
          }
          break;
          
        case 'payolution_monthly':
        case 'payolution_financing':
          if ($order->billing['company'] != '' || $order->customer['company'] != '') {
              unset($genre_config['types']['payolution_monthly']);
              unset($genre_config['types']['payolution_financing']);
          }
          break;
        
        default:
          if ($genre_config['types'][$key]['active'] != 'true') {
            unset($genre_config['types'][$key]);
          }
          break;
		  }
		}
		
		if (count($genre_config['types']) > 0) {
      $payment_smarty->assign('genre_config', $genre_config['types']);
      $payment_smarty->assign('code', $this->code);
    
      $payment_smarty->assign('payonecss', DIR_WS_EXTERNAL.'payone/css/payone.css');
      $payment_smarty->caching = 0;
      $module_form = $payment_smarty->fetch('checkout_payone_type_selection.html');
        
      $return = array(
        array('title' => '', 
              'field' => $module_form),
      );
      return $return;
		}
	}

	function pre_confirmation_check() {
	  global $order;
	  
		parent::pre_confirmation_check();

		if ($_SESSION['sendto'] != $_SESSION['billto']) {
			$_SESSION['payone_error'] = ADDRESSES_MUST_BE_EQUAL; 
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code, 'SSL', true));
		}
		if (isset($_POST['payone_installment_type'])) {
			$_SESSION[$this->code]['installment_type'] = $_POST['payone_installment_type'];
		}
		if (empty($_SESSION[$this->code]['installment_type'])) {
			$_SESSION['payone_error'] = INSTALLMENT_TYPE_NOT_SELECTED;
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code, 'SSL', true));
		}
		if ($_SESSION[$this->code]['installment_type'] == 'klarna' && !isset($this->klarnalocale[$order->billing['country']['iso_code_2']])) {
			$_SESSION['payone_error'] = INSTALLMENT_TYPE_COUNTRY_NOT_ALLOWED;
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code, 'SSL', true));		
		}
	}

	function confirmation() {
    $confirmation = array('title' => constant('MODULE_PAYMENT_'.strtoupper($this->code).'_TEXT_TITLE'),
                          'fields' => array(array('title' => '',
                                                  'field' => constant('paymenttype_'.$_SESSION[$this->code]['installment_type']),
                                            )));
		return $confirmation;
	}

	function process_button() {
	  if ($_SESSION[$this->code]['installment_type'] == 'klarna' 
	      || $_SESSION[$this->code]['installment_type'] == 'payolution_financing'
	      || $_SESSION[$this->code]['installment_type'] == 'payolution_monthly'
	      )
	  {
      $active_genre = $this->_getActiveGenreIdentifier();
      if ($active_genre === false) {
        return false;
      }
          
      return $this->_paymentDataFormProcess($active_genre);
    }
	}

	function before_process() {
		parent::before_process();    

    $valid_request = array(
      'customers_dob', 
      'customers_telephone', 
      'conditions', 
      'addressaddition', 
      'personalid', 
      'iban', 
      'bic', 
      'duration', 
      'company_uid', 
      'company_trade_registry_number', 
      'company_register_key',
    );
    
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		  foreach ($valid_request as $key) {
		    if (isset($_POST[$key])) {
		      $_SESSION[$this->code]['installment_'.$key] = $_POST[$key];
		    }
		  }
		}
		
	  if ($_SESSION[$this->code]['installment_type'] == 'klarna' 
	      || $_SESSION[$this->code]['installment_type'] == 'payolution_financing'
	      || $_SESSION[$this->code]['installment_type'] == 'payolution_monthly'
	      )
	  {
		  //check
		  if (isset($_SESSION[$this->code]['installment_customers_dob'])) {
        if (is_numeric(xtc_date_raw($_SESSION[$this->code]['installment_customers_dob'])) == false || (@checkdate(substr(xtc_date_raw($_SESSION[$this->code]['installment_customers_dob']), 4, 2), substr(xtc_date_raw($_SESSION[$this->code]['installment_customers_dob']), 6, 2), substr(xtc_date_raw($_SESSION[$this->code]['installment_customers_dob']), 0, 4)) == false)) {
          $_SESSION['payone_error'] = ENTRY_DATE_OF_BIRTH_ERROR;
          xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_CONFIRMATION, 'conditions=true&payment_error='.$this->code, 'SSL', true));		
        }
      }
      if (strlen($_SESSION[$this->code]['installment_customers_telephone']) < ENTRY_TELEPHONE_MIN_LENGTH) {
        $_SESSION['payone_error'] = ENTRY_TELEPHONE_NUMBER_ERROR;
        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_CONFIRMATION, 'conditions=true&payment_error='.$this->code, 'SSL', true));		
      }
      if ((!isset($_SESSION[$this->code]['installment_conditions']) || $_SESSION[$this->code]['installment_conditions'] == false)) {
        if ($_SESSION[$this->code]['installment_type'] == 'klarna') {
          $_SESSION['payone_error'] = TEXT_KLARNA_ERROR_CONDITIONS;
        } else {
          $_SESSION['payone_error'] = TEXT_PAYOLUTION_ERROR_CONDITIONS;
        }
        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_CONFIRMATION, 'conditions=true&payment_error='.$this->code, 'SSL', true));		
      }
      if ($_SESSION[$this->code]['installment_type'] == 'payolution_financing') {
        if ((!isset($_SESSION[$this->code]['installment_iban']) || $_SESSION[$this->code]['installment_iban'] == '')
            || (!isset($_SESSION[$this->code]['installment_bic']) || $_SESSION[$this->code]['installment_bic'] == '')
            )
        {
          $_SESSION['payone_error'] = CHECK_BANKDATA;
          xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_CONFIRMATION, 'conditions=true&payment_error='.$this->code, 'SSL', true));		
        }
		  }
		}
	}

	function payment_action() {
	  global $order, $insert_id;
    
    if (!isset($insert_id) || $insert_id == '') {
		  $insert_id = $_SESSION['tmp_oID'];
		}

		$this->payone->log("(pre-)authorizing $this->code payment");
		$standard_parameters = parent::_standard_parameters('preauthorization');

		$this->personal_data = new Payone_Api_Request_Parameter_Authorization_PersonalData();
		parent::_set_customers_standard_params();
		
		// set manually for klarna
	  if ($_SESSION[$this->code]['installment_type'] == 'klarna' 
	      || $_SESSION[$this->code]['installment_type'] == 'payolution_financing'
	      || $_SESSION[$this->code]['installment_type'] == 'payolution_monthly'
	      )
	  {
      $this->personal_data->setBirthday(xtc_date_raw($_SESSION[$this->code]['installment_customers_dob']));
      $this->personal_data->setTelephonenumber($_SESSION[$this->code]['installment_customers_telephone']);
    }
    
		$this->delivery_data = new Payone_Api_Request_Parameter_Authorization_DeliveryData();
		parent::_set_customers_shipping_params();

		$this->payment_method = new Payone_Api_Request_Parameter_Authorization_PaymentMethod_Financing();
		$this->payment_method->setSuccessurl(((ENABLE_SSL == true) ? HTTPS_SERVER : HTTP_SERVER).DIR_WS_CATALOG.FILENAME_CHECKOUT_PROCESS.'?'.xtc_session_name().'='.xtc_session_id());
		$this->payment_method->setBackurl(((ENABLE_SSL == true) ? HTTPS_SERVER : HTTP_SERVER).DIR_WS_CATALOG.FILENAME_CHECKOUT_PAYMENT.'?'.xtc_session_name().'='.xtc_session_id());
		$this->payment_method->setErrorurl(((ENABLE_SSL == true) ? HTTPS_SERVER : HTTP_SERVER).DIR_WS_CATALOG.FILENAME_CHECKOUT_PAYMENT.'?'.xtc_session_name().'='.xtc_session_id().'&payment_error='.$this->code);

    // set order_id for deleting canceld order
    $_SESSION['tmp_payone_oID'] = $_SESSION['tmp_oID'];
		
		$financingtype = $this->installmenttypes[$_SESSION[$this->code]['installment_type']];
		$this->payment_method->setFinancingtype($financingtype);

    $request_parameters = parent::_request_parameters('fnc');
    if (!isset($request_parameters['invoicing']) 
        && $_SESSION[$this->code]['installment_type'] != 'payolution_financing'
        && $_SESSION[$this->code]['installment_type'] != 'payolution_monthly'
        )
    {
      $request_parameters['invoicing'] = $this->_getInvoicingTransaction($insert_id);
    }
    
    if ($_SESSION[$this->code]['installment_type'] == 'payolution_financing') {
      $standard_parameters['workorderid'] = $_SESSION[$this->code]['workorderid'];
     
      $paydata_item = array(
        array('key' => 'b2b', 'data' => (($order->billing['company'] != '' || $order->customer['company'] != '') ? 'yes' : 'no')),
        array('key' => 'company_uid', 'data' => $_SESSION[$this->code]['installment_company_uid']),
        array('key' => 'company_trade_registry_number', 'data' => $_SESSION[$this->code]['installment_company_trade_registry_number']),
        array('key' => 'company_register_key', 'data' => $_SESSION[$this->code]['installment_company_register_key']),
        array('key' => 'installment_duration', 'data' => $_SESSION[$this->code]['installment_duration']),        
      );
      $paydata = new Payone_Api_Request_Parameter_Paydata_Paydata();
      foreach ($paydata_item as $item) {
        $paydata->addItem(
          new Payone_Api_Request_Parameter_Paydata_DataItem($item)
        );
      }
      $this->payment_method->setPaydata($paydata);

			$debit = new Payone_Api_Request_Parameter_Authorization_PaymentMethod_DebitPayment();
      $debit->setIban($_SESSION[$this->code]['installment_iban']);
      $debit->setBic($_SESSION[$this->code]['installment_bic']);
      
      $this->payment_method->setBankData($debit);
    }
    
		$this->params = array_merge($standard_parameters, $request_parameters);		
		$this->builder = new Payone_Builder($this->payone->getPayoneConfig());
        
    parent::_build_service_authentification('fnc');
    parent::_parse_response_payone_api();

		xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL'));
	}

	function after_process() {
		parent::after_process();
		unset($_SESSION[$this->code]);
	}
}
?>