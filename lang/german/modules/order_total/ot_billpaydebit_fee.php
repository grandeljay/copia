<?php
require_once('ot_billpay_fee.php');

$prefix = 'MODULE_ORDER_TOTAL_BILLPAYDEBIT_';
$parent = 'MODULE_ORDER_TOTAL_BILLPAY_';

define($prefix.'FEE_TITLE', 'Zahlartenzuschlag Lastschrift (BillPay)');
define($prefix.'FEE_DESCRIPTION', 'Berechnung der Geb&uuml;hr f&uuml;r Bestellungen mit der Zahlart Lastschrift (BillPay)');

// config options
$fields = array(
    'FEE_DESCRIPTION', 'FEE_STATUS_TITLE', 'FEE_STATUS_DESC', 'FEE_SORT_ORDER_TITLE', 'FEE_SORT_ORDER_DESC',
    'FEE_TYPE_TITLE', 'FEE_TYPE_DESC', 'FEE_PERCENT_TITLE', 'FEE_PERCENT_DESC', 'FEE_VALUE_TITLE', 'FEE_VALUE_DESC',
    'FEE_TAX_CLASS_TITLE', 'FEE_TAX_CLASS_DESC',
    'FEE_FROM_TOTAL'
);
foreach ($fields as $field)
{
    defined($prefix.$field) OR define($prefix.$field, constant($parent.$field));
}