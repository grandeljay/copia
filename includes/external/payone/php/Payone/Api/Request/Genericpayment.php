<?php
/**
 * For PayPal ECS the request type genericpayment ist mandatory 
 * 
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License (GPL 3)
 * that is bundled with this package in the file LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Payone to newer
 * versions in the future. If you wish to customize Payone for your
 * needs please refer to http://www.payone.de for more information.

 * @category        Payone
 * @package         Payone_Api
 * @subpackage      Request
 * @author          Ronny Schröder
 * @license         <http://www.gnu.org/licenses/> GNU General Public License (GPL 3)
 */
class Payone_Api_Request_Genericpayment extends Payone_Api_Request_Abstract {
    
    /**
     * Sub account ID
     *
     * @var int
     */
    protected $aid = NULL;

    /**
     * @var string
     */
    protected $clearingtype = NULL;

    /**
     * Total amount (in smallest currency unit! e.g. cent)
     *
     * @var int
     */
    protected $amount = NULL;

    /**
     * Currency (ISO-4217)
     *
     * @var string
     */
    protected $currency = NULL;

    /**
     * Enum FinancingType
     * @var string
     */
    protected $financingtype = NULL;

    /**
     * dynamic text for debit and creditcard payments
     *
     * @var string
     */
    protected $narrative_text = NULL;

    /**
     * @var Payone_Api_Request_Parameter_Authorization_DeliveryData
     */
    protected $deliveryData = null;

    /**
     * @var Payone_Api_Request_Parameter_Authorization_PersonalData
     */
    protected $personalData = null;

    /**
     * With the first genericpayment the workorderid will be generated from the 
     * PAYONE platform and will be sent to you in the response. The ID is unique. 
     * The returned workorderid is mandatory for the following requests of 
     * PayPal Express Checkout.
     * 
     * @var string
     */
    protected $workorderid = NULL;

    /**
     * Wallet provider PPE: PayPal Express
     * @var Payone_Api_Request_Parameter_Authorization_PaymentMethod_Wallet 
     */
    protected $wallet = null;

    /**
     * Mandatory for PayPal ECS:
     * 1. action=setexpresscheckout
     * 2. action=getexpresscheckoutdetails
     * 
     * @var Payone_Api_Request_Parameter_Paydata_Paydata 
     */
    protected $paydata = NULL;
    
    
    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->request = Payone_Api_Enum_RequestType::GENERICPAYMENT;
        parent::__construct($data);
    }
    

    /**
     * @param int $aid
     */
    public function setAid($aid) {
        $this->aid = $aid;
    }

    /**
     * @return int
     */
    public function getAid() {
        return $this->aid;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @param string $clearingtype
     */
    public function setClearingtype($clearingtype) {
        $this->clearingtype = $clearingtype;
    }

    /**
     * @return string
     */
    public function getClearingtype() {
        return $this->clearingtype;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @param string $narrative_text
     */
    public function setNarrativeText($narrative_text) {
        $this->narrative_text = $narrative_text;
    }

    /**
     * @return string
     */
    public function getNarrativeText() {
        return $this->narrative_text;
    }

    /**
     * @param Payone_Api_Request_Parameter_Authorization_DeliveryData $deliveryData
     */
    public function setDeliveryData(Payone_Api_Request_Parameter_Authorization_DeliveryData $deliveryData) {
        $this->deliveryData = $deliveryData;
    }

    /**
     * @return Payone_Api_Request_Parameter_Authorization_DeliveryData
     */
    public function getDeliveryData() {
        return $this->deliveryData;
    }

    /**
     * @param Payone_Api_Request_Parameter_Authorization_PersonalData $personalData
     */
    public function setPersonalData(Payone_Api_Request_Parameter_Authorization_PersonalData $personalData) {
        $this->personalData = $personalData;
    }

    /**
     * @return Payone_Api_Request_Parameter_Authorization_PersonalData
     */
    public function getPersonalData() {
        return $this->personalData;
    }

    /**
     * 
     * @return string
     */
    function getWorkorderId() {
        return $this->workorderid;
    }

    /**
     * 
     * @param string $workorderid
     */
    function setWorkorderId($workorderid) {
        $this->workorderid = $workorderid;
    }

    /**
     * 
     * @return Payone_Api_Request_Parameter_Authorization_PaymentMethod_Wallet
     */
    function getWallet() {
        return $this->wallet;
    }

    /**
     * 
     * @param Payone_Api_Request_Parameter_Authorization_PaymentMethod_Wallet $wallet
     */
    function setWallet(Payone_Api_Request_Parameter_Authorization_PaymentMethod_Wallet $wallet) {
        $this->wallet = $wallet;
    }

    /**
     * @param Payone_Api_Request_Parameter_Paydata_Paydata $paydata
     */
    public function setPaydata($paydata) {
        $this->paydata = $paydata;
    }

    /**
     * 
     * @return Payone_Api_Request_Parameter_Paydata_Paydata
     */
    public function getPaydata() {
        return $this->paydata;
    }

    /**
     * @param string $financingtype
     */
    public function setFinancingtype($financingtype)
    {
        $this->financingtype = $financingtype;
    }

    /**
     * @return string
     */
    public function getFinancingtype()
    {
        return $this->financingtype;
    }

}
