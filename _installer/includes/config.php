<?php

/* -----------------------------------------------------------------------------------------
   $Id: config.php 14154 2022-03-17 14:50:05Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODIFIED_SQL', 'includes/sql/modified.sql');

// config
define('EMAIL_SQL_ERRORS', 'false');
define('TEMPLATE_ENGINE', 'smarty_3');
define('SEARCH_ENGINE_FRIENDLY_URLS', 'false');
define('DEFAULT_TEMPLATE', 'tpl_modified_responsive');

// min / max
define('SSL_VERSION_MIN', '1.2');
define('PHP_VERSION_MIN', '7.4.0');
define('PHP_VERSION_MAX', '8.1.99');

// permission
define('CHMOD_WRITEABLE', 0775);

// update
define('UPDATE_MAX_RELOADS', 100000000);

define('ENTRY_FIRST_NAME_MIN_LENGTH', 2);
define('ENTRY_LAST_NAME_MIN_LENGTH', 2);
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH', 6);
define('ENTRY_STREET_ADDRESS_MIN_LENGTH', 4);
define('ENTRY_POSTCODE_MIN_LENGTH', 4);
define('ENTRY_CITY_MIN_LENGTH', 3);
define('ENTRY_PASSWORD_MIN_LENGTH', 8);

define('RM', true);
