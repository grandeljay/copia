<?php

/**
 * specials.php
 */

include 'includes/application_top.php';

$smarty = new Smarty();

// include boxes
require DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php';

if ($language_not_found === true) {
    $site_error = TEXT_SITE_NOT_FOUND;
    include DIR_WS_MODULES . FILENAME_ERROR_HANDLER;
} else {
    $breadcrumb->add(NAVBAR_TITLE_SPECIALS, xtc_href_link(FILENAME_SPECIALS));

    include DIR_WS_MODULES . 'default.php';
}

require DIR_WS_INCLUDES . 'header.php';

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;

if (!defined('RM')) {
    $smarty->load_filter('output', 'note');
}

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include 'includes/application_bottom.php';
