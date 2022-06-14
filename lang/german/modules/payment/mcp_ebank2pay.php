<?php
/**
 *
 * @package    micropayment
 * @copyright  Copyright (c) 2015 Micropayment GmbH (http://www.micropayment.de)
 * @author     micropayment GmbH <shop-plugins@micropayment.de>
 */
require_once('mcp_service.php');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_DESCRIPTION', 'micropayment&trade; Sofort&uuml;berweisung Modul
<br /><br />
Links<br />
<b>Tools</b><br />
<a target="_new" href="../callback/micropayment/cleanup.php">
    <input type="button" value="Bestellungen aufr&auml;umen">
</a><br />
<br />
<b>Extern</b><br />
<a href="http://ecommerce.micropayment.de/download/modified/micropayment_modified-shop_current.pdf">
    <input type="button" value="Handbuch">
</a>&nbsp;
<a target="_new" href="https://r120.micropayment.de">
    <input type="button" value="Micropayment Registrierung">
    </a>
');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_TITLE', 'micropayment&trade; Sofort&uuml;berweisung<br /><img src="http://www.micropayment.de/resources/?what=img&group=eb2p&show=type-h.4" />');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_TITLE_EXTERN', 'Sofort&uuml;berweisung');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_INFO', '
<div style="margin:10px;">
<div style="float:right;"><img src="./images/micropayment/logo_small.png" width="150"/></div><div style="float:left;">
    <b>Bitte halten Sie die Online-Banking Zugangsdaten bereit.</b><br />
    Um Ihre Bestellung abzuschlie&szlig;en, leiten wir Sie nun auf die Webseite<br /> unseres Zahlungsdienstleisters micropayment&trade; weiter.<br /><br />
    &#10004; sicher &nbsp; &#10004; einfach &nbsp; &#10004; registrierungsfrei
</div>
');

define('MODULE_PAYMENT_MCP_EBANK2PAY_STATUS_TITLE','Sofort&uuml;berweisung');
define('MODULE_PAYMENT_MCP_EBANK2PAY_STATUS_DESC','Sofort&uuml;berweisung-Modul von micropayment&trade;');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MINIMUM_AMOUNT_TITLE','Minimum Warenkorbwert');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MINIMUM_AMOUNT_DESC','Mindestwert des Warenkorbs für diese Bezahlmethode');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MAXIMUM_AMOUNT_TITLE','Maximum Warenkorbwert');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MAXIMUM_AMOUNT_DESC','Maximalwert des Warenkorbs für diese Bezahlmethode');
define('MODULE_PAYMENT_MCP_EBANK2PAY_SORT_ORDER_TITLE','Positionierung');
define('MODULE_PAYMENT_MCP_EBANK2PAY_SORT_ORDER_DESC','Positionierung in der Bezahlmethodenauswahl');
define('MODULE_PAYMENT_MCP_EBANK2PAY_ALLOWED_TITLE','L&auml;nderauswahl');
define('MODULE_PAYMENT_MCP_EBANK2PAY_ALLOWED_DESC','Bestellungen nur aus den L&auml;ndern erlauben (Komma separierte Liste z.b. DE,EN)');

?>
