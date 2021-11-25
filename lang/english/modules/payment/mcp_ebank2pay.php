<?php
/**
 *
 * @package    micropayment
 * @copyright  Copyright (c) 2015 Micropayment GmbH (http://www.micropayment.de)
 * @author     micropayment GmbH <shop-plugins@micropayment.de>
 */
require_once('mcp_service.php');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_DESCRIPTION', 'micropayment&trade; online bank transfer module
<br /><br />
links<br />
<b>tools</b><br />
<a target="_new" href="../callback/micropayment/cleanup.php">
  <input type="button" value="clear old orders">
</a><br />
<br />
<b>Extern</b><br />
<a href="http://ecommerce.micropayment.de/download/modified/micropayment_modified-shop_2.x.pdf?version=2.1.0">
  <input type="button" value="Manual">
</a>&nbsp;
<a target="_new" href="https://r120.micropayment.de">
  <input type="button" value="Micropayment register">
</a>');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_TITLE', 'micropayment&trade; online bank transfer');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_TITLE_EXTERN', 'Online bank transfer');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_INFO', '
<div style="margin:10px; height:140px;">
  <div style="float:right;"><img src="./images/micropayment/logo_small.png" width="150"/></div>
  <div style="float:left;">
    <b>Please have your online banking details at hand.</b><br />
    To conclude your order, you will now be forwarded to our payment service provider, micropayment&trade; in cooperation with sofort.com.<br /><br />
    &#10004; secure &nbsp; &#10004; simple &nbsp; &#10004; no registration needed
  </div>
</div>');
define('MODULE_PAYMENT_MCP_EBANK2PAY_STATUS_TITLE','Online bank transfer');
define('MODULE_PAYMENT_MCP_EBANK2PAY_STATUS_DESC','Online bank transfer module by micropayment&trade;');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MINIMUM_AMOUNT_TITLE','Minimum amount');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MINIMUM_AMOUNT_DESC','Minimum amount for this payment method');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MAXIMUM_AMOUNT_TITLE','Maximum amount');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MAXIMUM_AMOUNT_DESC','Maximum amount for this payment method');
define('MODULE_PAYMENT_MCP_EBANK2PAY_SORT_ORDER_TITLE','Positioning');
define('MODULE_PAYMENT_MCP_EBANK2PAY_SORT_ORDER_DESC','Positioning in the payment method selection');
define('MODULE_PAYMENT_MCP_EBANK2PAY_ALLOWED_TITLE','Country selection');
define('MODULE_PAYMENT_MCP_EBANK2PAY_ALLOWED_DESC','Allow orders only from these countries (Comma seperated list DE,EN)');

?>