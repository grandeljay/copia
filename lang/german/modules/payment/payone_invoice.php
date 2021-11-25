<?php
/* --------------------------------------------------------------
	payone.php 2013-08-02 mabr
	Gambio GmbH
	http://www.gambio.de
	Copyright (c) 2013 Gambio GmbH
	Released under the GNU General Public License (Version 2)
	[http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------


	based on:
	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
	(c) 2002-2003 osCommerce(ot_cod_fee.php,v 1.02 2003/02/24); www.oscommerce.com
	(C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Pl�nkers ; http://www.themedia.at & http://www.oscommerce.at
	(c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_cod_fee.php 1003 2005-07-10 18:58:52Z mz $)

	Released under the GNU General Public License
	---------------------------------------------------------------------------------------*/

require_once (dirname(__FILE__).'/payone.php');

define('MODULE_PAYMENT_PAYONE_INVOICE_TEXT_TITLE', 'Rechnung');
define('MODULE_PAYMENT_PAYONE_INVOICE_TEXT_DESCRIPTION', 'Zahlung auf Rechnung &uuml;ber PayOne');
define('MODULE_PAYMENT_PAYONE_INVOICE_TEXT_INFO', 'Zahlung auf Rechnung');
define('MODULE_PAYMENT_PAYONE_INVOICE_STATUS_TITLE', MODULE_PAYMENT_PAYONE_STATUS_TITLE);
define('MODULE_PAYMENT_PAYONE_INVOICE_STATUS_DESC', MODULE_PAYMENT_PAYONE_STATUS_DESC);
define('MODULE_PAYMENT_PAYONE_INVOICE_ALLOWED_TITLE', MODULE_PAYMENT_PAYONE_ALLOWED_TITLE);
define('MODULE_PAYMENT_PAYONE_INVOICE_ALLOWED_DESC', MODULE_PAYMENT_PAYONE_ALLOWED_DESC);
define('MODULE_PAYMENT_PAYONE_INVOICE_ZONE_TITLE', MODULE_PAYMENT_PAYONE_ZONE_TITLE);
define('MODULE_PAYMENT_PAYONE_INVOICE_ZONE_DESC', MODULE_PAYMENT_PAYONE_ZONE_DESC);
define('MODULE_PAYMENT_PAYONE_INVOICE_SORT_ORDER_TITLE', MODULE_PAYMENT_PAYONE_SORT_ORDER_TITLE);
define('MODULE_PAYMENT_PAYONE_INVOICE_SORT_ORDER_DESC', MODULE_PAYMENT_PAYONE_SORT_ORDER_DESC);
