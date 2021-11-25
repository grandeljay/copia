<?php
require_once(DIR_FS_CATALOG . 'includes/external/billpay/base/BillpayOT.php');
require_once(DIR_FS_CATALOG . 'includes/external/billpay/base/billpayBase.php');

class ot_z_paylater_fee extends BillpayOT
{
    public function __construct()
    {
        $this->_paymentIdentifier = 'Z_PAYLATER_FEE';
        $this->paymentMethod = billpayBase::PAYMENT_METHOD_PAY_LATER;
        $this->config = array(
            'STATUS'    => $this->config['STATUS'],
            'SORT_ORDER'=> $this->config['SORT_ORDER'],
            'TAX_CLASS' => $this->config['TAX_CLASS'],
        );
        $this->config['SORT_ORDER']['default'] = 151;
        parent::__construct();

        /** @var BillpayPayLater $billpay */
        $billpay = billpayBase::PaymentInstance(billpayBase::PAYMENT_METHOD_PAY_LATER);
        $billpay->requireLang();

        $this->code = 'ot_z_paylater_fee';
        $this->title = constant('MODULE_PAYMENT_BILLPAY_OT_PAYLATER_FEE');
        $this->description = "";
        $this->enabled = true;
        $this->output = array();
    }

    /**
     * Executed on checkout_payment and checkout_confirmation
     * @return bool
     */
    function process()
    {
        global $xtPrice;
        if (!$this->isPaymentMethod()) return false;
        $value = $_SESSION['billpaypaylater_feeamount'] * 0.01;
        if (empty($value)) {
            return false;
        }
        $this->output[] = array(
            'title' =>  $this->title.':',
            'text'  =>  $xtPrice->xtcFormat($value, true),
            'value' =>  $value,
        );
        return true;
    }
}
