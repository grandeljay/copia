<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtcPrice.php 13226 2021-01-22 08:25:09Z GTB $

   modified eCommerce Shopsoftware  
   http://www.modified-shop.org     

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.15 2003/03/17); www.oscommerce.com
   (c) 2003 nextcommerce (currencies.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2006 XT-Commerce (xtcPrice.php 1316 2005-10-21)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------
   modified by:
   2006 - Gunnar Tillmann - http://www.gunnart.de
   
   Everywhere a price is displayed you see any existing kind of discount in percent and
   in saved money in your chosen currency
   ---------------------------------------------------------------------------------------*/

/**
 * This class calculates and formates all prices within the shop frontend
 *
 */
class xtcPrice {

  var $currencies;
  
  /**
   * Constructor initialises all required values like currencies, tax classes, tax zones etc.
   *
   * @param String $currency
   * @param Integer $cGroup
   * @return xtcPrice
   */
  function __construct($currency, $cGroup) {

    //new module support
    require_once (DIR_FS_CATALOG.'includes/classes/xtcPriceModules.class.php');
    $this->priceModules = new priceModules();
    
    $this->currencies = array();
    $this->cStatus = array();
    $this->actualGroup = (int) $cGroup;
    $this->actualCurr = $currency;
    $this->TAX = array();
    $this->showFrom_Attributes = true;
    $this->flagSpecial = false;
    $this->show_price_tax = 0;
    $this->country_id = STORE_COUNTRY;
    $this->zone_id = STORE_ZONE;

    if (!defined('HTTP_CATALOG_SERVER') 
        && isset($_SESSION['cart'])
        && is_object($_SESSION['cart'])
        )
    {
      $this->content_type = $_SESSION['cart']->get_content_type();
    }

    if (isset($_SESSION['customer_id'])) {
      $this->country_id = $_SESSION['customer_country_id'];
      $this->zone_id = $_SESSION['customer_zone_id'];
    }

    $currencies_query = xtDBquery("SELECT * 
                                     FROM " . TABLE_CURRENCIES . " 
                                    WHERE status = '1'");
    while ($currencies = xtc_db_fetch_array($currencies_query, true)) {
      $this->currencies[$currencies['code']] = $currencies;
    }

    // if the currency in user's preference is not existing use default
    if (!isset($this->currencies[$this->actualCurr])) {
      $this->actualCurr = DEFAULT_CURRENCY;
    }

    // select Customers Status data
    $customers_status_query = xtDBquery("SELECT *
                                           FROM " . TABLE_CUSTOMERS_STATUS . "
                                          WHERE customers_status_id = '" . $this->actualGroup . "'
                                            AND language_id = '" . (int) $_SESSION['languages_id'] . "'");
    $this->cStatus = xtc_db_fetch_array($customers_status_query, true);    
    
    // prefetch tax rates for standard zone
    $zones_query = xtDBquery("SELECT tax_class_id as class FROM " . TABLE_TAX_CLASS);
    while ($zones_data = xtc_db_fetch_array($zones_query, true)) {
      // calculate tax based on shipping or deliverey country (for downloads) 
      if (isset($this->content_type) 
          && isset($_SESSION['billto']) 
          && isset($_SESSION['sendto'])
          )
      {
        $tax_address_query = xtc_db_query("SELECT ab.entry_country_id,
                                                  ab.entry_zone_id
                                             FROM " . TABLE_ADDRESS_BOOK . " ab
                                        LEFT JOIN " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                            WHERE ab.customers_id = '" . $_SESSION['customer_id'] . "'
                                              AND ab.address_book_id = '" . ($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'");
        if (xtc_db_num_rows($tax_address_query) == 1) {
          $tax_address = xtc_db_fetch_array($tax_address_query);

          $this->country_id = $tax_address['entry_country_id'];
          $this->zone_id = $tax_address['entry_zone_id'];
          
          $this->TAX[$zones_data['class']] = xtc_get_tax_rate($zones_data['class'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']);
        } else {
          $this->TAX[$zones_data['class']] = xtc_get_tax_rate($zones_data['class']);      
        }
      } else {
        $country_id = -1;
        if (isset($_SESSION['country'])) {
          $country_id = $_SESSION['country'];
          $this->country_id = $country_id;
          $this->zone_id = -1;
        }
        $this->TAX[$zones_data['class']] = xtc_get_tax_rate($zones_data['class'], $country_id);        
      }
    }
        
    $currency = $this->priceModules->construct($currency, $cGroup);
  }
  
  /**
   * This function searchs the inividual price for a product using the product id $pID
   *
   * @param Integer $pID product id
   * @param Boolean $format Format the result?
   * @param Double $qty quantity
   * @param Integer $tax_class tax class id
   * @param Double $pPrice product price
   * @param Integer $vpeStatus vpe status
   * @param Integer $cedit_id customer specify tax conditions
   * @return String/Array Price (if format = true both plain and formatted)
   */
  function xtcGetPrice($pID, $format = true, $qty = 1, $tax_class = '', $pPrice = 0, $vpeStatus = 0, $cedit_id = 0) {
    
    $this->tax_class = $tax_class;
    
    // check if group is allowed to see prices
    if ($this->cStatus['customers_status_show_price'] == '0') {
      return $this->xtcShowNote($vpeStatus);
    }
    
    $this->show_price_tax = ($this->tax_class == '') ? 0 : $this->cStatus['customers_status_show_price_tax'];
 
    // get Tax rate
    if ($cedit_id != 0) {
      if (defined('HTTP_CATALOG_SERVER')) {
        global $order; // edit orders in admin guest account
        $cinfo = get_c_infos($order->customer['ID'], trim($order->delivery['country_iso_2']));
      } else {
        $cinfo = xtc_oe_customer_infos($cedit_id);
      }
      if ($this->cStatus['customers_status_show_price_tax'] == 1
          && $this->cStatus['customers_status_add_tax_ot'] == 0
          && $this->get_content_type_product($pID) == 'virtual'
          ) 
      {
        $this->tax_class = xtc_get_tax_class($this->tax_class, $cinfo['country_id'], $cinfo['zone_id']);
      }
      $products_tax = xtc_get_tax_rate($this->tax_class, $cinfo['country_id'], $cinfo['zone_id']);
    } else {
      if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1
          && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0
          && $this->get_content_type_product($pID) == 'virtual'
          ) 
      {
        $this->tax_class = xtc_get_tax_class($this->tax_class);
      }
      $products_tax = isset($this->tax_class) && isset($this->TAX[$this->tax_class]) ? $this->TAX[$this->tax_class] : 0;
    }
    
    if ($this->cStatus['customers_status_show_price_tax'] == '0') {
      $products_tax = 0;
    }
    
    // add taxes
    if ((float)$pPrice == 0) {
      $pPrice = $this->getPprice($pID);
    }

    $pPrice = $this->xtcAddTax($pPrice, $products_tax);
    
    // check extension
    if ($ePrice = $this->xtcCheckExtension($pID)) {
      return $this->xtcFormatExtension($pID, $this->xtcAddTax($ePrice, $products_tax), $pPrice, $format, $vpeStatus);
    }

    // check specialprice
    if ($sPrice = $this->xtcCheckSpecial($pID)) {
      return $this->xtcFormatSpecial($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus);
    }
    
    // check graduated
    if ($this->cStatus['customers_status_graduated_prices'] == '1') {
      if ($sPrice = $this->xtcGetGraduatedPrice($pID, $qty)) {
        return $this->xtcFormatSpecialGraduated($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $this->tax_class);
      }
    } else {
      // check Group Price
      if ($sPrice = $this->xtcGetGroupPrice($pID, 1)) {
        return $this->xtcFormatSpecialGraduated($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $this->tax_class);
      }
    }

    // check Product Discount
    if ($discount = $this->xtcCheckDiscount($pID)) {
      return $this->xtcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus);
    }
    return $this->xtcFormat($pPrice, $format, 0, false, $vpeStatus, $pID);
  }
  
  /**
   * This function returns the reqular price of a product,
   * no mather if its a special offer or has graduated prices
   *
   * @param Integer $pID product id
   * @return Double price
   */
  function getPprice($pID) {
    $pQuery = xtDBquery("SELECT products_price 
                           FROM ".TABLE_PRODUCTS." 
                          WHERE products_id='".(int)$pID."'");
    $pData = xtc_db_fetch_array($pQuery, true);
    $pData = $this->priceModules->getPprice($pData, $pID);
    return $pData['products_price'];
  }
  
  /**
   * Adding a tax percentage to a price
   * This function also converts the price with currency factor,
   * so take care to avoid double conversions!
   *
   * @param Double $price net price
   * @param Double $tax tax value(%)
   * @return Double gross price
   */
  function xtcAddTax($price, $tax) {
    $price += $price / 100 * $tax;
    $price = $this->xtcCalculateCurr($price);
    return $this->show_price_tax ? round($price, $this->currencies[$this->actualCurr]['decimal_places']) : $price;
  }
  
  /**
   * Returns the product sepcific discount
   *
   * @param Integer $pID product id
   * @return Mixed boolean false if not found or 0.00, double if found and > 0.00
   */
  function xtcCheckDiscount($pID) {
    static $discount_array;
    
    if (!isset($discount_array)) {
      $discount_array = array();
    }
    
    if (!isset($discount_array[$pID])) {
      $discount_array[$pID] = 0;
      
      if ($this->cStatus['customers_status_discount'] != '0.00') {
        $discount_query = xtDBquery("SELECT products_discount_allowed 
                                       FROM ".TABLE_PRODUCTS." 
                                      WHERE products_id = '".(int)$pID."'");
        $discount = xtc_db_fetch_array($discount_query, true);
      
        $discount_value = $discount['products_discount_allowed'];
        if ($this->cStatus['customers_status_discount'] < $discount_value) {
          $discount_value = $this->cStatus['customers_status_discount'];
        }
      
        if ($discount_value != '0.00') {
          $discount_array[$pID] = $discount_value;
        }
      }
    }
    
    return $discount_array[$pID];
  }
  
  /**
   * Searches the graduated price of a product for a specified quantity
   *
   * @param Integer $pID product id
   * @param Double $qty quantity
   * @return Double graduated price
   */
  function xtcGetGraduatedPrice($pID, $qty, $graduated = true) {
    static $graduated_price_array;
    
    if (!isset($graduated_price_array)) {
      $graduated_price_array = array();
    }

    if (defined('GRADUATED_ASSIGN') && GRADUATED_ASSIGN == 'true' && $graduated === true) {
      $actual_content_qty = xtc_get_qty($pID);
      $qty = $actual_content_qty > $qty ? $actual_content_qty : $qty;
    }
    
    if (empty($this->actualGroup)) {
      $this->actualGroup = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
    }
    
    if (!isset($graduated_price_array[$pID])) {
      $graduated_price_array[$pID] = array();
      $graduated_price_query = xtDBquery("SELECT *
                                            FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
                                           WHERE products_id = '".(int)$pID."'");
      while ($graduated_price  = xtc_db_fetch_array($graduated_price_query, true)) {
        if ($graduated_price['personal_offer'] > 0) {
          $graduated_price_array[$pID][$graduated_price['quantity']] = $graduated_price['personal_offer'];
        }
      }
      krsort($graduated_price_array[$pID]);
    }
    
    if (count($graduated_price_array[$pID]) > 0) {
      foreach ($graduated_price_array[$pID] as $quantity => $personal_offer) {
        if ($quantity <= $qty) {
          $key = $quantity;
          break;
        }
      }
      
      if (isset($key)) {
        return $graduated_price_array[$pID][$key];
      }
    }
  }
  
  /**
   * Searches the group price of a product
   *
   * @param Integer $pID product id
   * @param Double $qty quantity
   * @return Double group price
   */
  function xtcGetGroupPrice($pID, $qty) {
    return $this->xtcGetGraduatedPrice($pID, $qty, false);
  }

  /**
   * Returns the option price of a selected option
   *
   * @param Integer $pID product id
   * @param Integer $option option id
   * @param Integer $value value id
   * @return Double option price
   */
  function xtcGetOptionPrice($pID, $option, $value, $qty = 1) {
    $price = $discount = $attributes_weight = 0;
    
    $dataArr = array(
      'weight' => 0,
      'price' => 0,
      'discount' => 0,
      'qty' => $qty,
      'weight_prefix' => '',
      'price_prefix' => ''
    );
    
    $attribute_query = xtDBquery("SELECT p.products_discount_allowed,
                                         p.products_tax_class_id,
                                         p.products_price,
                                         p.products_weight,
                                         pa.*
                                    FROM " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                    JOIN " . TABLE_PRODUCTS . " p
                                         ON p.products_id = pa.products_id
                                   WHERE pa.products_id = '" . (int)$pID . "'
                                     AND pa.options_id = '" . (int)$option . "'
                                     AND pa.options_values_id = '" . (int)$value . "'");
    
    if (xtc_db_num_rows($attribute_query, true) > 0) {
      $attribute_data  = xtc_db_fetch_array($attribute_query, true);
      
      // calculate weight
      $attributes_weight = $attribute_data['options_values_weight'];
      if ($attribute_data['weight_prefix'] != '+') {
        $attributes_weight *= -1;
      }
      
      // calculate discount
      if ($this->cStatus['customers_status_discount_attributes'] == '1') {
        $discount = $this->xtcCheckDiscount($pID);
      }
      
      // calculate price and several currencies on product attributes
      $CalculateCurr = (($attribute_data['products_tax_class_id'] == 0) ? true : false);
      $price = $this->xtcFormat($attribute_data['options_values_price'], false, $attribute_data['products_tax_class_id'], $CalculateCurr);
      if ($discount <> 0) {
        $price = $price - ($price / 100 * $discount);
      }
      if ($attribute_data['price_prefix'] == '-') {
        $price *= -1;
      }
    
      $dataArr = array(
        'weight' => $attributes_weight,
        'price' => $price,
        'discount' => $discount,
        'qty' => $qty,
        'weight_prefix' => $attribute_data['weight_prefix'],
        'price_prefix' => $attribute_data['price_prefix']
      );
      
      $dataArr = $this->priceModules->GetOptionPrice($dataArr, $attribute_data, $pID, $option, $value, $qty);
    }
    return $dataArr;
  }
  
  /**
   * Returns the text info for customers, whose customer group isn't allowed to see prices
   *
   * @param Integer $vpeStatus
   * @param Boolean $format
   * @return String / Array of String
   */
  function xtcShowNote($vpeStatus = 0) {
    if ($vpeStatus == 1) {
      return array(
        'formated' => NOT_ALLOWED_TO_SEE_PRICES,
        'not_allowed' => NOT_ALLOWED_TO_SEE_PRICES,
        'plain' => 0,
        'from' =>  '',
        'flag' => 'NotAllowed'
      );
    }
    
    return NOT_ALLOWED_TO_SEE_PRICES;
  }
  
  /**
   * Returns the special offer price of a product
   *
   * @param Integer $pID product id
   * @return Double special offer
   */
  function xtcCheckSpecial($pID) {
    $this->flagSpecial = false;
    if ($this->cStatus['customers_status_specials'] == '1') {
      $special_price = 0;
      $product_query = xtc_db_query("SELECT *
                                       FROM ".TABLE_SPECIALS."
                                      WHERE products_id = '".(int)$pID."'
                                            ".SPECIALS_CONDITIONS);
      if (xtc_db_num_rows($product_query) > 0) {
        $product = xtc_db_fetch_array($product_query);
        $this->flagSpecial = true;
        
        $product = $this->priceModules->CheckSpecial($product, $pID);
      
        $special_price = $product['specials_new_products_price'];
      }
      
      $special_price = $this->priceModules->CheckSpecialPrice($special_price, $pID);
      
      return $special_price;
    }
  }

  /**
   * Returns the extension price of a product
   *
   * @param Integer $pID product id
   * @return Double extension price
   */
  function xtcCheckExtension($pID) {     
    $price = $this->priceModules->CheckExtension(0, $pID);
    return $price;
  }
  
  /**
   * Converts the price  with the currency factor
   *
   * @param Double $price
   * @return Double converted price
   */
  function xtcCalculateCurr($price) {
    return $this->currencies[$this->actualCurr]['value'] * $price;
  }
  
  /**
   * Returns the tax part of a net price
   *
   * @param Double $price price
   * @param Double $tax tax value
   * @return Double tax part
   */
  function calcTax($price, $tax) {
    return $price * $tax / 100;
  }
  
  /**
   * Removes the currency factor of a price
   *
   * @param Double $price
   * @return Double
   */
  function xtcRemoveCurr($price) {
    if (DEFAULT_CURRENCY != $this->actualCurr) {
      if ($this->currencies[$this->actualCurr]['value'] > 0) {
        return $price * (1 / $this->currencies[$this->actualCurr]['value']);
      }
    } else {
      return $price;
    }
  }
  
  /**
   * Removes the tax from a price, e.g. to calculate a net price from gross price
   *
   * @param Double $price price
   * @param Double $tax tax value
   * @return Double net price
   */
  function xtcRemoveTax($price, $tax) {
    $price = ($price / (($tax + 100) / 100));
    return $price;
  }
  
  /**
   * Returns the tax part of a gross price
   *
   * @param Double $price price
   * @param Double $tax tax value
   * @return Double tax part
   */
  function xtcGetTax($price, $tax) {
    $tax = $price - $this->xtcRemoveTax($price, $tax);
    return $tax;
  }
  
  /**
   * Removes the discount part of a price
   *
   * @param Double $price price
   * @param Double $dc discount
   * @return Double discount part
   */
  function xtcRemoveDC($price, $dc) {
    $price = $price - ($price / 100 * $dc);
    return $price;
  }
  
  /**
   * Returns the discount part of a price
   *
   * @param Double $price price
   * @param Double $dc discount
   * @return Double discount part
   */
  function xtcGetDC($price, $dc) {
    $dc = $price / 100 * $dc;
    return $dc;
  }
  
  /**
   * Returns a non rounded price
   *
   * @param Double $price price
   * @param integer $decimal_places
   * @return Double price non rounded
   */
  function xtcPriceCut($price, $decimal_places = 0) {
    $decimal_places = ($decimal_places > 0) ? $decimal_places : $this->currencies[$this->actualCurr]['decimal_places'];

    return substr($price, 0, strpos($price, '.') + 1 + $decimal_places);
  }

  /**
   * Check if the product has attributes which can modify the price
   * If so, it returns a prefix ' from '
   *
   * @param Integer $pID product id
   * @return String
   */
  function checkAttributes($pID) {
    global $product;
    
    if (!$this->showFrom_Attributes || $pID == 0) return;
    
    $pID = $this->priceModules->checkAttributes($pID);
    $total = $product->getAttributesCount($pID, true);
    
    if ($total > 0) {
      return ' ' . FROM . ' ';
    }
  }
  
  /**
   * xtcCalculateCurrEx
   *
   * @param double $price
   * @param string $curr
   * @return double
   */
  function xtcCalculateCurrEx($price, $curr) {
    return $price * ($this->currencies[$curr]['value'] / $this->currencies[$this->actualCurr]['value']);
  }
  
  /**
   * xtcFormatCurrency
   *
   * @param double $price
   * @param integer $decimal_places
   * @return unknown
   */
  function xtcFormatCurrency($price, $decimal_places = 0, $round = true) {
    $decimal_places = ($decimal_places > 0) ? $decimal_places : $this->currencies[$this->actualCurr]['decimal_places'];
    if ($round === false) {
      $price_array = explode('.', $price, 2);
      $price = intval($price);
      if (count($price_array) > 1) {
        $price .= '.'.substr($price_array[1], 0, $decimal_places);
      }
    }
    $Pprice = number_format(floatval($price), $decimal_places, $this->currencies[$this->actualCurr]['decimal_point'], $this->currencies[$this->actualCurr]['thousands_point']);
    $Pprice = $this->currencies[$this->actualCurr]['symbol_left'] . ' ' . $Pprice . ' ' . $this->currencies[$this->actualCurr]['symbol_right'];
    
    return trim($Pprice);
  }
  
  /**
   * xtcFormat
   *
   * @param double $price
   * @param boolean $format
   * @param integer $tax_class
   * @param boolean $curr
   * @param integer $vpeStatus
   * @param integer $pID
   * @param integer $decimal_places
   * @return unknown
   */
  function xtcFormat($price, $format, $tax_class = 0, $curr = false, $vpeStatus = 0, $pID = 0, $decimal_places = 0) {
    if ($curr) {
      $price = $this->xtcCalculateCurr($price);
    }
    if ($tax_class != 0) {
      $products_tax = ($this->cStatus['customers_status_show_price_tax'] == '0') ? 0 : $this->TAX[$tax_class];
      $price = $this->xtcAddTax($price, $products_tax);
    }
    $decimal_places = ($decimal_places > 0) ? $decimal_places : $this->currencies[$this->actualCurr]['decimal_places'];
    if ($format) {
      $from = $this->checkAttributes($pID);

      if ((int)$pID > 0) {
        $sQuery = xtDBquery("SELECT max(po.quantity) AS qty,
                                    p.products_tax_class_id
                               FROM " . TABLE_PERSONAL_OFFERS_BY . $this->actualGroup . " po
                               JOIN " . TABLE_PRODUCTS . " p
                                    ON po.products_id = p.products_id
                              WHERE po.products_id = '" . (int)$pID . "'
                           GROUP BY p.products_id");
        if (xtc_db_num_rows($sQuery, true) > 0) {
          $sQuery = xtc_db_fetch_array($sQuery, true);
          if (($this->cStatus['customers_status_graduated_prices'] == '1') && ($sQuery['qty'] > 1)) {
            $from = ' ' . FROM . ' ';
            $price = $this->xtcGetGraduatedPrice($pID, $sQuery['qty']);
            if ($curr) {
              $price = $this->xtcCalculateCurr($price);
            }
            if ($sQuery['products_tax_class_id'] > 0) {
              $products_tax = ($this->cStatus['customers_status_show_price_tax'] == '0') ? 0 : $this->TAX[$sQuery['products_tax_class_id']];
              $price = $this->xtcAddTax($price, $products_tax);
            }
          }
        }
      }
      $Pprice = $this->xtcFormatCurrency($price, $decimal_places);
      
      if ($this->cStatus['customers_status_show_price_tax'] == '0') {
        $Bprice = $this->xtcFormatCurrency($this->xtcAddTax($price, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)), $decimal_places);
        $Nprice = $Pprice;
      } else {
        $Bprice = $Pprice;
        $Nprice = $this->xtcFormatCurrency($this->xtcRemoveTax($price, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)), $decimal_places);
      }
      
      if ($vpeStatus == 0) {
        return $from.$Pprice;
      } else {
        return array(
          'formated' => $from.$Pprice,
          'standard_price' => $Pprice,
          'plain' => $price,
          'from' =>  $from,
          'flag' => 'standard',
          'netto' => $Nprice,
          'brutto' => $Bprice
        );
      }
    } else {
      return $this->show_price_tax ? round($price, $decimal_places) : $price;
    }
  }
  
  /**
   * xtcFormatSpecialDiscount
   *
   * @param integer $pID
   * @param unknown_type $discount
   * @param double $pPrice
   * @param boolean $format
   * @param integer $vpeStatus
   * @return unknown
   */
  function xtcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus, $qty = 1) {
    $sPrice = $this->xtcFormat($pPrice - ($pPrice / 100) * $discount, false) * $qty;
    if ($format) {
      $old_price = $this->xtcFormat($pPrice * $qty, $format);
      $special_price = $this->xtcFormat($sPrice, $format);
      $save_percent = round(($pPrice * $qty - $sPrice) / $pPrice * 100 / $qty);
      $save_diff = $this->xtcFormat($pPrice * $qty - $sPrice, $format);
      $from = $this->checkAttributes($pID);
      $price = '<span class="productOldPrice"><small>' . INSTEAD . '</small><del>' . $old_price . '</del></span><br /><span class="productNewPrice">' . ONLY . $from . $special_price . '</span><br /><small class="productSavePrice">' . YOU_SAVE . $save_percent . ' % /' . $save_diff;
      if ($discount != 0) {
        // customer group discount
        $price .= '<br />' . BOX_LOGINBOX_DISCOUNT . ': ' . round($discount) . ' %';
      }
      $price .= '</small>';

      if ($this->cStatus['customers_status_show_price_tax'] == '0') {
        $Bprice = $this->xtcFormatCurrency($this->xtcAddTax($sPrice, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)));
        $Nprice = $special_price;
      } else {
        $Bprice = $special_price;
        $Nprice = $this->xtcFormatCurrency($this->xtcRemoveTax($sPrice, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)));
      }

      if ($vpeStatus == 0) {
        return $price;
      } else {
        return array(
          'formated' => $price,
          'plain' => $sPrice,
          'special_price' =>  $special_price,
          'old_price' =>  $old_price,
          'save_percent' =>  $save_percent,
          'save_diff' =>  $save_diff,
          'group_discount' => round($discount),
          'from' =>  $from,
          'flag' => 'SpecialDiscount',         
          'netto' => $Nprice,
          'brutto' => $Bprice
        );
      }
    } else {
      return $this->show_price_tax ? round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']) : $sPrice;
    }
  }
  
  /**
   * xtcFormatSpecial
   *
   * @param integer $pID
   * @param double $sPrice
   * @param double $pPrice
   * @param bpplean $format
   * @param integer $vpeStatus
   * @return unknown
   */
  function xtcFormatSpecial($pID, $sPrice, $pPrice, $format, $vpeStatus) {
    if ($format) {      
      if (!isset($pPrice) || $pPrice == 0) {
        $discount = 0;
      } else {
        $discount = ($pPrice - $sPrice) / $pPrice * 100;
      }
      $old_price = $this->xtcFormat($pPrice, $format);
      $special_price = $this->xtcFormat($sPrice, $format);
      $save_percent = round($discount);
      $save_diff = $this->xtcFormat($pPrice - $sPrice, $format);
      $from = $this->checkAttributes($pID);
      $price = '<span class="productOldPrice"><small>' . INSTEAD . '</small><del>' . $old_price . '</del></span><br /><span class="productNewPrice">' . ONLY . $from . $special_price . '</span><br /><small class="productSavePrice">' . YOU_SAVE . $save_percent . ' % /' . $save_diff . '</small>';

      if ($this->cStatus['customers_status_show_price_tax'] == '0') {
        $Bprice = $this->xtcFormatCurrency($this->xtcAddTax($sPrice, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)));
        $Nprice = $special_price;
      } else {
        $Bprice = $special_price;
        $Nprice = $this->xtcFormatCurrency($this->xtcRemoveTax($sPrice, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)));
      }

      if ($vpeStatus == 0) {
        $return = $price;
      } else {
        $return = array(
          'formated' => $price,
          'plain' => $sPrice,
          'special_price' =>  $special_price,
          'old_price' =>  $old_price,
          'save_percent' =>  $save_percent,
          'save_diff' =>  $save_diff,
          'from' =>  $from,
          'flag' => 'Special',
          'netto' => $Nprice,
          'brutto' => $Bprice
        );
      }
    } else {
      $return = $this->show_price_tax ? round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']) : $sPrice;
    }
    
    $return = $this->priceModules->FormatSpecial($return, $pID, $sPrice, $pPrice, $format, $vpeStatus);
    
    return $return;
  }
  
  /**
   * xtcFormatSpecialGraduated
   *
   * @param integer $pID
   * @param double $sPrice
   * @param double $pPrice
   * @param boolean $format
   * @param integer $vpeStatus
   * @param integer $pID
   * @return unknown
   */
  function xtcFormatSpecialGraduated($pID, $sPrice, $pPrice, $format, $vpeStatus, $tax_class) {
    if ($pPrice == 0) {
      return $this->xtcFormat($sPrice, $format, 0, false, $vpeStatus);
    }
    if ($discount = $this->xtcCheckDiscount($pID)) {
      $sPrice -= $sPrice / 100 * $discount;
    }
    if ($format) {
      $sQuery = xtDBquery("SELECT max(quantity) AS qty
                             FROM " . TABLE_PERSONAL_OFFERS_BY . $this->actualGroup . "
                            WHERE products_id='" . $pID . "'");
      $sQuery = xtc_db_fetch_array($sQuery, true);
      $old_price = '';
      $special_price = '';
      $from = '';
      $uvp = '';
      if (($this->cStatus['customers_status_graduated_prices'] == '1') && ($sQuery['qty'] > 1)) {
        $bestPrice = $this->xtcGetGraduatedPrice($pID, $sQuery['qty']);
        if ($discount) {
          $bestPrice -= $bestPrice / 100 * $discount;
        }
        $old_price_plain = $this->xtcFormat($bestPrice, false, $tax_class);
        $old_price = $this->xtcFormat($old_price_plain, true);
        $special_price = $this->xtcFormat($sPrice, $format);
        $price = FROM . $old_price . ' <br /><small>' . UNIT_PRICE . $special_price . '</small>';
      } elseif ($sPrice != $pPrice) {
        $old_price_plain = $this->xtcFormat($pPrice, false);
        $old_price = $this->xtcFormat($old_price_plain, true);
        $special_price = $this->xtcFormat($sPrice, $format);
        $from = $this->checkAttributes($pID);
        $uvp = MSRP;
        $price = '<span class="productOldPrice">' . $uvp . ' ' . $old_price . '</span><br />' . YOUR_PRICE . $from . $special_price;
      } else {
        return $this->xtcFormat($sPrice, $format, 0, false, $vpeStatus, $pID);
        //$price = $this->xtcFormat($sPrice, $format);
      }

      if ($this->cStatus['customers_status_show_price_tax'] == '0') {
        $Bprice = $this->xtcFormatCurrency($this->xtcAddTax($old_price_plain, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)));
        $Nprice = $this->xtcFormatCurrency($old_price_plain);
        $Bspecial_price = $this->xtcFormatCurrency($this->xtcAddTax($sPrice, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)));
        $Nspecial_price = $this->xtcFormatCurrency($sPrice);
      } else {
        $Bprice = $this->xtcFormatCurrency($old_price_plain);
        $Nprice = $this->xtcFormatCurrency($this->xtcRemoveTax($old_price_plain, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)));
        $Bspecial_price = $this->xtcFormatCurrency($sPrice);
        $Nspecial_price = $this->xtcFormatCurrency($this->xtcRemoveTax($sPrice, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)));
      }
      
      if ($vpeStatus == 0) {
        return $price;
      } else {
        return array(
          'formated' => $price,
          'plain' => $sPrice,
          'special_price' =>  $special_price,
          'special_price_netto' =>  $Nspecial_price,
          'special_price_brutto' =>  $Bspecial_price,
          'old_price' =>  $old_price,
          'from' =>  $from,
          'uvp' =>  $uvp,
          'flag' => 'SpecialGraduated',
          'netto' => $Nprice,
          'brutto' => $Bprice
        );
      }
    } else {
      return $this->show_price_tax ? round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']) : $sPrice;
    }
  }
  
  /**
   * xtcFormatExtension
   *
   * @param integer $pID
   * @param double $ePrice
   * @param double $pPrice
   * @param bpplean $format
   * @param integer $vpeStatus
   * @return unknown
   */
  function xtcFormatExtension($pID, $ePrice, $pPrice, $format, $vpeStatus) {
    if ($format) {      
      $from = $this->checkAttributes($pID);
      $price = $this->xtcFormat($ePrice, $format);

      if ($this->cStatus['customers_status_show_price_tax'] == '0') {
        $Bprice = $this->xtcFormatCurrency($this->xtcAddTax($ePrice, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)));
        $Nprice = $ePrice;
      } else {
        $Bprice = $ePrice;
        $Nprice = $this->xtcFormatCurrency($this->xtcRemoveTax($ePrice, ((isset($this->tax_class) && isset($this->TAX[$this->tax_class])) ? $this->TAX[$this->tax_class] : 0)));
      }

      if ($vpeStatus == 0) {
        $return = $price;
      } else {
        $return = array(
          'formated' => $from.$price,
          'standard_price' => $price,
          'plain' => $ePrice,
          'from' =>  $from,
          'flag' => 'standard',
          'netto' => $Nprice,
          'brutto' => $Bprice
        );
      }
    } else {
      $return = $this->show_price_tax ? round($ePrice, $this->currencies[$this->actualCurr]['decimal_places']) : $ePrice;
    }
    
    $return = $this->priceModules->FormatExtension($return, $pID, $ePrice, $pPrice, $format, $vpeStatus);
    
    return $return;
  }

  /**
   * get_decimal_places
   *
   * @param unknown_type $code
   * @return unknown
   */
  function get_decimal_places($code) {
    return $this->currencies[$this->actualCurr]['decimal_places'];
  }

  /**
   * get_content_type_product
   *
   * @return unknown
   */
  function get_content_type_product($products_id) {
    $this->content_type_product = array(); 

    if (DOWNLOAD_ENABLED == 'true') {
      if (defined('DOWNLOAD_MULTIPLE_ATTRIBUTES_ALLOWED') && DOWNLOAD_MULTIPLE_ATTRIBUTES_ALLOWED == 'true') {
        // new routine for multiple attributes for downloads
        $virtual_check_query = xtc_db_query("SELECT pa.products_attributes_id
                                               FROM ".TABLE_PRODUCTS_ATTRIBUTES." pa
                                               JOIN ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad
                                                    ON pa.products_attributes_id = pad.products_attributes_id
                                              WHERE pa.products_id = '".(int)$products_id."'");
        if (xtc_db_num_rows($virtual_check_query) > 0) {
          $this->content_type_product[$products_id] = 'virtual';
        } else {
          $this->content_type_product[$products_id] = 'physical';
        }
      } else {
        // old routine as standard
        $virtual_check_query1 = xtc_db_query("SELECT products_attributes_id
                                               FROM ".TABLE_PRODUCTS_ATTRIBUTES."
                                              WHERE products_id = '".(int)$products_id."'");
        $total_attributes = xtc_db_num_rows($virtual_check_query1);

        $virtual_check_query = xtc_db_query("SELECT pa.products_attributes_id
                                               FROM ".TABLE_PRODUCTS_ATTRIBUTES." pa
                                               JOIN ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad
                                                    ON pa.products_attributes_id = pad.products_attributes_id
                                              WHERE pa.products_id = '".(int)$products_id."'
                                           GROUP BY pa.options_values_id");
        $total_virtual = xtc_db_num_rows($virtual_check_query);
        
        if ($total_virtual == 0) {
          $this->content_type_product[$products_id] = 'physical';
        } elseif ($total_attributes == $total_virtual) {
          $this->content_type_product[$products_id] = 'virtual';
        } elseif ($total_attributes > $total_virtual) {
          $this->content_type_product[$products_id] = 'mixed';
        }          
      }
    } else {
      $this->content_type_product[$products_id] = 'physical';
    }
    
    return $this->content_type_product[$products_id];
  }
  
}
?>