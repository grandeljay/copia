<?php
/* -----------------------------------------------------------------------------------------
   $Id: class.easybill.php 10091 2016-07-17 15:26:40Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  // Archivierung
  define('EASYBILL_INVOICE_ARCHIV', DIR_FS_CATALOG.(defined('DIR_ADMIN') ? DIR_ADMIN : 'admin/').'archives/invoice/');

  class easybill extends order {

    var $error = array();
    var $connection = false;
    var $search = false;
    
    
    protected function makeConnection () {

      // multilanguage
      include_once (DIR_FS_EXTERNAL.'easybill/lang/'.$this->info['language'].'/easybill.php');
    
      @ini_set('soap.wsdl_cache_enabled', '0');
      $this->client = new SoapClient("https://soap.easybill.de/soap.easybill.php?wsdl", array('trace' => 1, 
                                                                                              'exceptions' => 1,
                                                                                              'cache_wsdl' => WSDL_CACHE_NONE));
      $header = new SoapHeader('http://www.easybill.de/webservice', 'UserAuthKey', MODULE_EASYBILL_API);
      $this->client->__setSoapHeaders($header);
      $this->connection = true; 
    }
    
    
    public function setCustomer() {				
      
      if ($this->connection != true) {
        $this->makeConnection();
      }
      
      $this->getCustomerDatevId();
      
      //SOAP Call
      try {
        $customer = $this->client->getCustomerByCustomerNumber($this->customer['datev_id']);
      }		
      catch(SoapFault $e) {
        $this->error[] = 'customer not found';
      }   		
  
      $customer_details_query = xtc_db_query("SELECT customers_gender, 
                                                     customers_fax 
                                                FROM ".TABLE_CUSTOMERS." 
                                               WHERE customers_id='".$this->customer['id']."'
                                            ");
      $customer_details = xtc_db_fetch_array($customer_details_query);
      
      $customer->salutation     = str_replace(array('m', 'f'), array('1', '2'), $customer_details['customers_gender']);
      $customer->fax            = utf8_encode($customer_details['customers_fax']);

      if (!xtc_not_null($this->billing['country_iso_2'])) {
        $this->billing['country_iso_2'] = $this->getCountryIso($this->billing['billing_country']);
      }
  
      $customer->firstName      = utf8_encode((($this->billing['firstname'] != '') ? $this->billing['firstname'] : $this->customer['firstname']));
      $customer->lastName       = utf8_encode((($this->billing['lastname'] != '') ? $this->billing['lastname'] : $this->customer['lastname']));
      $customer->street         = utf8_encode((($this->billing['street_address'] != '') ? $this->billing['street_address'] : $this->customer['street_address']));
      $customer->zipCode        = utf8_encode((($this->billing['postcode'] != '') ? $this->billing['postcode'] : $this->customer['postcode']));
      $customer->city           = utf8_encode((($this->billing['city'] != '') ? $this->billing['city'] : $this->customer['city']));
      $customer->country        = utf8_encode((($this->billing['country_iso_2'] != '') ? $this->billing['country_iso_2'] : $this->customer['country_iso_2']));
      $customer->companyName    = utf8_encode((($this->billing['company'] != '') ? $this->billing['company'] : $this->customer['company']));
      $customer->phone_1        = utf8_encode($this->customer['telephone']);
      $customer->email          = utf8_encode($this->customer['email_address']);
      $customer->customerNumber = utf8_encode($this->customer['datev_id']);
  
      if (xtc_not_null($this->customer['vat_id'])) {
        $customer->ustid = utf8_encode($this->customer['vat_id']);
        if ($this->customer['status'] == DEFAULT_CUSTOMERS_VAT_STATUS_ID) {
          $customer->taxOptions = '2';   // without VAT  
        } else {
          $customer->taxOptions = '1';  // with VAT
        }
      }	else {
        $customer->taxOptions = '0';  // undefined VAT
      }
      
      $customer->groupID = $this->getCustomerGroupID($this->info['status']);
          
      //SOAP Call
      try {
        $this->customers = $this->client->setCustomer($customer);
      }
      catch(SoapFault $e) {
        $this->error[] = $e;
      }
    }
 
 
 		protected function getCustomerDatevId() {
 		
      $datev_query = xtc_db_query("SELECT customers_datev_id 
                                     FROM " . TABLE_EASYBILL_DATEV . " 
                                    WHERE customers_id = '" . $this->customer['id'] . "'");
      if (xtc_db_num_rows($datev_query)>0) {
     		$datev = xtc_db_fetch_array($datev_query);
     		$this->customer['datev_id'] = $datev['customers_datev_id'];
     	} else {
     		$this->getNewCustomerDatevId();
     	}
 		}     
 
		
		protected function getNewCustomerDatevId() {
		
			$error = false;	
			if ($this->search === false) {
				$datev_query = xtc_db_query("SELECT MAX(customers_datev_id) AS last_datev_id FROM ".TABLE_EASYBILL_DATEV);
				$datev = xtc_db_fetch_array($datev_query);
				if ($datev['last_datev_id']>0) {
					$this->search = ($datev['last_datev_id']+1);
				} else {
					$this->search = '10000';
				}
			}

      if ($this->connection != true) {
        $this->makeConnection();
      }
      
      //SOAP Call
      try {
        $this->client->getCustomerByCustomerNumber($this->search);
      }		
      catch(SoapFault $e) {
        $error=$e;
      } 
		  		
  		if ($error !== false) {
				$this->customer['datev_id'] = $this->search;
				$sql_data_array = array('customers_datev_id' => $this->customer['datev_id'],
				                        'customers_id' => $this->customer['id']);
				xtc_db_perform(TABLE_EASYBILL_DATEV, $sql_data_array);                     
			} else {
			  $this->search ++;
				$this->getNewCustomerDatevId();
			}
		}
		
		
    protected function getCountryIso($country_name) {
    
      $country_query = xtc_db_query("SELECT countries_iso_code_2 
                                       FROM " . TABLE_COUNTRIES . " 
                                      WHERE countries_name = '" . xtc_db_input($country_name) . "'");
      $country = xtc_db_fetch_array($country_query);
      
      return $country['countries_iso_code_2'];
    } 

     
    protected function getCustomerGroupID($status_id) {
    
      if (xtc_not_null($status_id)) {
        
        //SOAP Call
        try {
          $group = $this->client->getAllCustomerGroups();
        }
        catch(SoapFault $e) {
          $this->error[] = $e;
        }
        
        if (is_object($group->CustomerGroup)) {
          //only 1 Group exists
          if ($group->CustomerGroup->number == $status_id) {
            return $group->CustomerGroup->groupID;
          }
        } elseif (is_array($group->CustomerGroup)) {
          for ($i=0; $n=sizeof($group->CustomerGroup), $i<$n; $i++) {
            if ($group->CustomerGroup[$i]->number == $status_id) {
              return $group->CustomerGroup[$i]->groupID;
            }      
          }
        }
        
        // CoustomerGroup not found
        $this->createCustomerGroup($status_id);
      }
    }
  
  
    protected function createCustomerGroup($status_id) { 
    
      $customers_statuses_query = xtc_db_query("SELECT customers_status_id,
                                                       customers_status_name
                                                  FROM ".TABLE_CUSTOMERS_STATUS."
                                                 WHERE language_id='2'
                                                   AND customers_status_id='".$status_id."'
                                              ");
      $customers_statuses = xtc_db_fetch_array($customers_statuses_query);
      
      $customergroup->number  = utf8_encode($customers_statuses['customers_status_id']);
      $customergroup->name    = utf8_encode($customers_statuses['customers_status_name']);
      
      //SOAP Call
      try {
        $this->client->setCustomerGroup($customergroup);
      }
      catch(SoapFault $e) {
        $this->error[] = $e;
      }
    }
  
  
    public function createDocument($bill_nr='', $save=false, $download=false) {
    
      require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');
      require_once (DIR_FS_INC.'xtc_get_tax_rate.inc.php');
      
      if ($this->connection != true) {
        $this->makeConnection();
      }
  
      if (!is_object($xtPrice)) {
        require_once (DIR_FS_CATALOG . 'includes/classes/xtcPrice.php');
        $xtPrice = new xtcPrice($this->info['currency'], $this->info['status']);
      }

      $this->setCustomersTaxRate();
      $this->info['tax'] = false;
      
      if (!is_object($document)) {
        $document = new stdClass();
      }
      
      $document->documentID = $this->getDocumentID($bill_nr);		
      $document->customerID = $this->customers->customerID;
      $document->currency   = $this->info['currency'];
      $document->documentNumber = $bill_nr;
      
      $positions = array();
      for ($i = 0, $n = sizeof($this->products); $i < $n; $i++) {
        
        $attributes = '';
        $attributes_total = 0;
        if ((isset ($this->products[$i]['attributes'])) && (sizeof($this->products[$i]['attributes']) > 0)) {
          for ($j = 0, $n2 = sizeof($this->products[$i]['attributes']); $j < $n2; $j++) {
            $attributes_value = trim($this->products[$i]['attributes'][$j]['value']);
            //$products_array attributes output adjustments (overrides)
            $products_array[$i]['attributes'][$j]['value'] = $attributes_value;
            $products_array[$i]['attributes'][$j]['price'] = $attributes_price;
            if ($attributes_value != '') {
              $attributes .= ' ' . $this->products[$i]['attributes'][$j]['option'] . ': ' . $attributes_value;
              $attributes_total += $this->products[$i]['attributes'][$j]['price'];
            }
          }
        }
  
        $positions[$i]->positionType      = 'POSITION';
        $positions[$i]->itemNumber        = (xtc_not_null($this->products[$i]['model']) ? $this->products[$i]['model'] : $this->products[$i]['id']);
        $positions[$i]->companyPositionID = $this->products[$i]['id'];
        $positions[$i]->itemDescription   = utf8_encode($this->products[$i]['name'].$attributes);
        $positions[$i]->count             = $this->products[$i]['qty'];
        $positions[$i]->unit              = utf8_encode(((xtc_not_null($this->products[$i]['vpe']) && $this->products[$i]['vpe']!='0')?xtc_get_vpe_name($this->products[$i]['vpe']):EASYBILL_UNIT));
        $positions[$i]->ustPercent        = $this->products[$i]['tax'];
        if ($this->products[$i]['allow_tax'] == 1) {
        	$this->customer['allow_tax'] = 1;
        	$positions[$i]->singlePriceNetto  = floatval($xtPrice->xtcRemoveTax($this->products[$i]['price'], $positions[$i]->ustPercent)*100);      	
      	} else {
        	$positions[$i]->singlePriceNetto  = floatval($this->products[$i]['price']*100);
      	}
      }
      
      for ($t=0, $n=sizeof($this->totals); $t<$n; $t++) {
        switch ($this->totals[$t]['class']) {
          
          case 'ot_tax':
            $this->info['tax'] = true;
            break;

          case 'ot_subtotal':
          case 'ot_subtotal_no_tax':
          case 'ot_total':
            // muss nicht übergeben werden
            break;
   
          case 'ot_shipping':        
            $positions[$i]->positionType      = 'POSITION';
            $positions[$i]->count             = 1;
            $positions[$i]->unit              = utf8_encode(EASYBILL_UNIT);
            $positions[$i]->itemDescription   = utf8_encode(rtrim(strip_tags($this->totals[$t]['title']), ':'));
            $positions[$i]->ustPercent        = $this->getShippingTax();
            if ($this->customer['allow_tax'] == 1)
            {
            	$positions[$i]->singlePriceNetto  = floatval($xtPrice->xtcRemoveTax($this->totals[$t]['value'], $positions[$i]->ustPercent)*100);
            }
            else
            {
            	$positions[$i]->singlePriceNetto  = floatval($this->totals[$t]['value']*100);
            }        
						// delete Shipping if cost = 0
            if ($positions[$i]->singlePriceNetto == 0) {
              unset($positions[$i]);
              $i--;
            }
            $i++;
            break;
  
          case 'ot_payment':
            $positions[$i]->positionType      = 'POSITION';
            $positions[$i]->count             = 1;
            $positions[$i]->unit              = utf8_encode(EASYBILL_UNIT);
            $positions[$i]->itemDescription   = utf8_encode(rtrim(strip_tags($this->totals[$t]['title']), ':'));
            $positions[$i]->ustPercent        = 0;  
            $positions[$i]->singlePriceNetto  = floatval($this->totals[$t]['value']*100);
            $i++;
            break;
           	
          case 'ot_billpay_fee':
          case 'ot_billpaybusiness_fee':
          case 'ot_billpaydebit_fee':
          case 'ot_billpaytc_surcharge':
          case 'ot_coupon':
          case 'ot_discount':
          case 'ot_gv':
          case 'ot_ps_fee':
          case 'ot_loworderfee':
          case 'ot_cod_fee':
          case 'ot_shippingfee':
            $positions[$i]->positionType      = 'POSITION';
            $positions[$i]->count             = 1;
            $positions[$i]->unit              = utf8_encode(EASYBILL_UNIT);
            $positions[$i]->itemDescription   = utf8_encode(rtrim(strip_tags($this->totals[$t]['title']), ':'));
            $positions[$i]->ustPercent        = $this->getOrderTotalTax($this->totals[$t]['class']);
            if ($this->customer['allow_tax'] == 1)
            {
            	$positions[$i]->singlePriceNetto  = floatval($xtPrice->xtcRemoveTax($this->totals[$t]['value'], $positions[$i]->ustPercent)*100);
            }
            else
            {
            	$positions[$i]->singlePriceNetto  = floatval($this->totals[$t]['value']*100);
            }        
            $i++;
            break;

          default:
            $positions[$i]->positionType      = 'POSITION';
            $positions[$i]->count             = 1;
            $positions[$i]->unit              = utf8_encode(EASYBILL_UNIT);
            $positions[$i]->itemDescription   = utf8_encode(rtrim(strip_tags($this->totals[$t]['title']), ':'));
            $positions[$i]->ustPercent        = xtc_get_tax_rate(MODULE_EASYBILL_STANDARD_TAX_CLASS, $this->customer['country_id'], $this->customer['zone_id']);
            if ($this->customer['allow_tax'] == 1)
            {
            	$positions[$i]->singlePriceNetto  = floatval($xtPrice->xtcRemoveTax($this->totals[$t]['value'], $positions[$i]->ustPercent)*100);
            }
            else
            {
            	$positions[$i]->singlePriceNetto  = floatval($this->totals[$t]['value']*100);
            }        
            $i++;
            break;
          
        }
      }
        
      $document->documentPosition = $positions;

      // set Tax Options for document
      if (!isset($this->customer['allow_tax'])) {
        require_once (DIR_FS_INC.'xtc_get_customers_country.inc.php');
        require_once (DIR_FS_INC.'xtc_get_geo_zone_code.inc.php');

        $country_id = xtc_get_customers_country($this->customer['id']);

        if (xtc_get_geo_zone_code($country_id) == xtc_get_geo_zone_code(STORE_COUNTRY)) {
          if ($this->info['tax'] !== true) {
            if (xtc_not_null($this->customer['vat_id'])) {
              $document->taxOptions = 'IG';
            } else {
              $document->taxOptions = 'sStfr';
            }
          }
        } else {
          $document->taxOptions = 'AL';
        }
      }
      
      // Text before Positions
      $textPrefix = EASYBILL_PAYMENT_HEADING . $this->getPaymentMethod();
      $textPrefix .= EASYBILL_EOL;
      $textPrefix .= EASYBILL_PAYMENT_HEADING_II . $this->info['order_id'];
      $document->textPrefix = utf8_encode($textPrefix);
      
      // Text after Positions
      $document->text = ((defined(strtoupper('MODULE_EASYBILL_PAYMENT_TEXT_'.$this->info['payment_method']))) ? utf8_encode(constant(strtoupper('MODULE_EASYBILL_PAYMENT_TEXT_'.$this->info['payment_method']))) : '');
      
      if ($this->info['payment_method'] == 'billpay') {
        $document->text .= EASYBILL_EOL.$this->getBankData();
      }

      if ($this->info['payment_method'] == 'paypalplus') {
        $document->text .= EASYBILL_EOL.$this->getBankDataPayPal();
      }
      
      //SOAP Call
      try {
        $this->document = $this->client->CreateDocument($document);	
      }
      catch(SoapFault $e) {
        $this->error[] = $e;
      }
            
      if ($save == true) {
        $this->saveDocument($this->document->document->documentID, $download);
      } elseif ($download == true) {
        $this->downloadDocument($this->document->document->documentID);
      }
      
      // After Process
      $this->after_process();
      
      if (MODULE_EASYBILL_DO_AUTO_PAYMENT == 'True') {
        $check = explode(';', MODULE_EASYBILL_NO_AUTO_PAYMENT);
        if (!in_array($this->info['payment_method'], $check)) {
          $this->setPayment($this->document->document->documentID);
        }
      }
    }


    protected function getBankDataPayPal() {
    
      require_once(DIR_FS_EXTERNAL.'paypal/classes/PayPalInfo.php');
      $paypal = new PayPalInfo($order->info['payment_method']);      
      $bankdata_array = $paypal->get_payment_instructions($this->info['order_id']);
      
      $bank = '';
      if (isset($bankdata_array[0]['fields'])) {
        $bank .= $bankdata_array[0]['title'].EASYBILL_EOL.EASYBILL_EOL;

        $bankdata = $bankdata_array[0]['fields'];        
        for ($i=0, $n=count($bankdata); $i<$n; $i++) {
          $bank .= $bankdata[$i]['title'].' '.$bankdata[$i]['field'].EASYBILL_EOL;
        }
      }
     
      return $bank; 
    }


    protected function getBankData() {
    
      $bankdata_query = xtc_db_query("SELECT * 
                                        FROM billpay_bankdata 
                                       WHERE orders_id='".$this->info['order_id']."'");
      $bankdata = xtc_db_fetch_array($bankdata_query);
      
      $bank  = $bankdata['bank_name'];
      $bank .= EASYBILL_INVOICE_ACCOUNT_HOLDER.$bankdata['account_holder'];    
      $bank .= EASYBILL_INVOICE_BANK_CODE.$bankdata['bank_code'];    
      $bank .= EASYBILL_INVOICE_ACCOUNT_NUMBER.$bankdata['account_number'];    
      $bank .= EASYBILL_INVOICE_REFERENCE.$bankdata['invoice_reference'];    
     
      return $bank; 
    }
    
      
    protected function setCustomersTaxRate() {
    
      $country_query = xtc_db_query("SELECT entry_country_id, 
                                            entry_zone_id 
                                       FROM ".TABLE_ADDRESS_BOOK." 
                                      WHERE customers_id = '".(int) $this->customer['id']."' 
                                        AND entry_firstname = '".xtc_db_input($this->customer['firstName'])."'
                                        AND entry_lastname = '".xtc_db_input($this->customer['lastName'])."'
                                        AND entry_street_address = '".xtc_db_input($this->customer['street'])."'
                                        AND entry_postcode = '".xtc_db_input($this->customer['zipCode'])."'
                                        AND entry_company = '".xtc_db_input($this->customer['companyName'])."'
                                        AND entry_city = '".xtc_db_input($this->customer['city'])."'                                      
                                    ");
			$country = xtc_db_fetch_array($country_query);
			$this->customer['country_id'] = $country['entry_country_id'];
			$this->customer['zone_id'] = $country['entry_zone_id'];
    }
    
  
    protected function getShippingTax() {
    
      require_once (DIR_FS_INC.'xtc_get_tax_rate.inc.php');
      $shipping_class = explode('_', $this->info['shipping_class']);
      if (defined(strtoupper('MODULE_SHIPPING_'.$shipping_class[0].'_TAX_CLASS'))) {
        return xtc_get_tax_rate(constant(strtoupper('MODULE_SHIPPING_'.$shipping_class[0].'_TAX_CLASS')), $this->customer['country_id'], $this->customer['zone_id']);
      } else {
        return '0';
      }
    }

    
    protected function getOrderTotalTax($type) {
    
      $type = explode('_', $type, 2);
      require_once (DIR_FS_INC.'xtc_get_tax_rate.inc.php');
      if (defined(strtoupper('MODULE_ORDER_TOTAL_'.$type[1].'_TAX_CLASS'))) {
        return xtc_get_tax_rate(constant(strtoupper('MODULE_ORDER_TOTAL_'.$type[1].'_TAX_CLASS')), $this->customer['country_id'], $this->customer['zone_id']);
      } else {
        return '0';
      }
    }

    
    public function getDocumentID($bill_nr) {
        
      //SOAP Call
      try {
        $document = $this->client->getDocumentsByCustomer($this->customers->customerID);
      }
      catch(SoapFault $e) {
        $this->error[] = $e;
      }
          
      if (is_object($document->Document)) {
        //only 1 Document exists
        if ($document->Document->documentNumber == $bill_nr) {
          return $document->Document->documentID;
        }
      } elseif (is_array($document->Document)) {
        for ($i=0; $n=sizeof($document->Document), $i<$n; $i++) {
          if ($document->Document[$i]->documentNumber == $bill_nr) {
            return $document->Document[$i]->documentID;
          }      
        }  
      }   
    }
    
    
    public function saveDocument($documentID, $download) {
  
      //SOAP Call
      try {
        $document = $this->client->getDocument($documentID);
      }
      catch(SoapFault $e) {
        $this->error[] = $e;
      }
   
      # Rechung als Datei speichern
      $handle = fopen(EASYBILL_INVOICE_ARCHIV.$document->fileName, "w");
      fwrite($handle, base64_decode($document->file));
      fclose($handle);
      
      if ($download == true) {
        # Datei downloaden
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$document->fileName.'"');
        readfile(EASYBILL_INVOICE_ARCHIV.$document->fileName);
      }  
    }
  
  
    public function downloadDocument($documentID) {
      
      //SOAP Call
      try {
        $document = $this->client->getDocument($documentID);
      }
      catch(SoapFault $e) {
        $this->error[] = $e;
      }
   
      # Rechung als Datei speichern
      $handle = fopen(DIR_FS_DOWNLOAD.$document->fileName, "w");
      fwrite($handle, base64_decode($document->file));
      fclose($handle);
  
      # Datei downloaden
      header('Content-type: application/pdf');
      header('Content-Disposition: attachment; filename="'.$document->fileName.'"');
      readfile(DIR_FS_DOWNLOAD.$document->fileName);
      unlink(DIR_FS_DOWNLOAD.$document->fileName);
    }
  
  
    protected function after_process() {
    
    	if (isset($this->document->document->documentNumber) && xtc_not_null($this->document->document->documentNumber)) 
    	{
				$process_array = array ('orders_id'             => xtc_db_prepare_input($this->info['order_id']),
																'customers_id'          => xtc_db_prepare_input($this->customer['id']),
																'easybill_customers_id' => xtc_db_prepare_input($this->customers->customerID),
																'billing_id'            => xtc_db_prepare_input($this->document->document->documentNumber),
																'billing_date'          => 'now()'
															 );
				xtc_db_perform(TABLE_EASYBILL, $process_array);
	
				if (MODULE_EASYBILL_DO_STATUS_CHANGE=='True') {
					$status_array = array('orders_id'         => $this->info['order_id'],
																'orders_status_id'  => MODULE_EASYBILL_STATUS_CHANGE,
																'date_added'        => 'now()',
																'customer_notified' => '0',
																'comments'          => EASYBILL_STATUS_CHANGE_COMMENT
																);
					xtc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $status_array);
					xtc_db_query("UPDATE ".TABLE_ORDERS."
														SET orders_status = ".MODULE_EASYBILL_STATUS_CHANGE.",
																last_modified = now()
														WHERE orders_id = ".$this->info['order_id']);
				}
      }
    }
    
    
    public function checkOrder() {
      
      $check_query = xtc_db_query("SELECT * 
                                     FROM ".TABLE_EASYBILL." 
                                    WHERE orders_id='".$this->info['order_id']."'");
      if (xtc_db_num_rows($check_query)>0) {
        $this->details = xtc_db_fetch_array($check_query);
        return true;
      }
    }
  
  
    protected function getPaymentMethod() {

      $payment_method = $this->info['payment_method'];
      if (file_exists(DIR_FS_CATALOG . 'lang/'.$this->info['language'].'/modules/payment/'.$this->info['payment_method'].'.php')) {
        include_once (DIR_FS_CATALOG . 'lang/'.$this->info['language'].'/modules/payment/'.$this->info['payment_method'].'.php');
        if (defined(strtoupper('MODULE_PAYMENT_'.$this->info['payment_method'].'_TEXT_TITLE'))) {
          $payment_method = constant(strtoupper('MODULE_PAYMENT_'.$this->info['payment_method'].'_TEXT_TITLE'));
        }
      }

      return $payment_method;
    }


    public function setPayment($documentID) {
      
      $payment_method = $this->info['payment_method'];
      if (file_exists(DIR_FS_CATALOG . 'lang/'.$this->info['language'].'/modules/payment/'.$this->info['payment_method'].'.php')) {
        include_once (DIR_FS_CATALOG . 'lang/'.$this->info['language'].'/modules/payment/'.$this->info['payment_method'].'.php');
        if (defined(strtoupper('MODULE_PAYMENT_'.$this->info['payment_method'].'_TEXT_TITLE'))) {
          $payment_method = constant(strtoupper('MODULE_PAYMENT_'.$this->info['payment_method'].'_TEXT_TITLE'));
        }
      }

      if (!is_object($payment)) {
        $payment = new stdClass();
      }
        
      $payment->documentID = $documentID;
      $payment->amount = floatval($this->info['pp_total']*100);
      $payment->paymentdate = date('Y-m-d');
      $payment->paymenttype = $payment_method;
      $payment->notice = '';
      $payment->payed = true;
  
      //SOAP Call
      try {
        $document = $this->client->setDocumentAddPayment($payment);
      }
      catch(SoapFault $e) {
        $this->error[] = $e;
      }

      xtc_db_query("UPDATE ".TABLE_EASYBILL."
                       SET payment = '1'
                     WHERE orders_id = ".$this->info['order_id']);
    }
  }
?>