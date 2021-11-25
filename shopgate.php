<?php

/**
 * shopgate.php
 */

if (!defined('_VALID_XTC')) {
    define('_VALID_XTC', true);
}

$shopgatePath = dirname(__FILE__) . '/includes/external/shopgate';
date_default_timezone_set("Europe/Berlin");

include_once $shopgatePath . '/shopgate_library/shopgate.php';
ob_start();
include_once 'includes/application_top.php';
ob_end_clean();
include_once $shopgatePath . '/plugin.php';

$ShopgateFramework = new ShopgateModifiedPlugin();
$ShopgateFramework->handleRequest($_REQUEST);
