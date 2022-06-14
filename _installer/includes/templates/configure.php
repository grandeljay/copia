<?php
$file_contents = 
'<?php' . PHP_EOL .
'/* --------------------------------------------------------------' . PHP_EOL .
'   $Id: configure.php 10303 2016-09-27 09:51:16Z web28 $' . PHP_EOL .
'' . PHP_EOL .
'   modified eCommerce Shopsoftware' . PHP_EOL .
'   http://www.modified-shop.org' . PHP_EOL .
'' . PHP_EOL .
'   Copyright (c) 2009 - 2013 [www.modified-shop.org]' . PHP_EOL .
'   --------------------------------------------------------------' . PHP_EOL .
'   based on:' . PHP_EOL .
'   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)' . PHP_EOL .
'   (c) 2002-2003 osCommerce (configure.php,v 1.13 2003/02/10); www.oscommerce.com' . PHP_EOL .
'   (c) 2003 XT-Commerce (configure.php)' . PHP_EOL .
'' . PHP_EOL .
'   Released under the GNU General Public License' . PHP_EOL .
'   --------------------------------------------------------------*/' . PHP_EOL .
'' . PHP_EOL .
'  // Define the webserver and path parameters' . PHP_EOL .
'  // * DIR_FS_* = Filesystem directories (local/physical)' . PHP_EOL .
'  // * DIR_WS_* = Webserver directories (virtual/URL)' . PHP_EOL .
'' . PHP_EOL .
'  // global defines' . PHP_EOL .
'  define(\'DIR_FS_DOCUMENT_ROOT\', \'' . DIR_FS_DOCUMENT_ROOT . '\'); // absolut path required' . PHP_EOL .
'  define(\'DIR_WS_CATALOG\', \'' . $_POST['DIR_WS_CATALOG'] . '\'); // relative path required' . PHP_EOL .
'  define(\'DIR_FS_CATALOG\', DIR_FS_DOCUMENT_ROOT);' . PHP_EOL .
'' . PHP_EOL .
'  // define our database connection' . PHP_EOL .
'  define(\'DB_MYSQL_TYPE\', \'' . $_POST['DB_MYSQL_TYPE'] . '\'); // define mysql type set to \'mysql\' or \'mysqli\'' . PHP_EOL .
'  define(\'DB_SERVER\', \'' . $_POST['DB_SERVER'] . '\'); // eg, localhost - should not be empty for productive servers' . PHP_EOL .
'  define(\'DB_SERVER_USERNAME\', \'' . $_POST['DB_SERVER_USERNAME'] . '\');' . PHP_EOL .
'  define(\'DB_SERVER_PASSWORD\', \'' . $_POST['DB_SERVER_PASSWORD']. '\');' . PHP_EOL .
'  define(\'DB_DATABASE\', \'' . $_POST['DB_DATABASE']. '\');' . PHP_EOL .
'  define(\'DB_SERVER_CHARSET\', \'' . DB_SERVER_CHARSET . '\'); // set db charset \'utf8\' or \'latin1\'' . PHP_EOL .
'  define(\'USE_PCONNECT\', \'' . (($_POST['USE_PCONNECT'] == 'true') ? 'true' : 'false') . '\'); // use persistent connections?' . PHP_EOL .
'' . PHP_EOL .
'  if (DB_DATABASE != \'\') {' . PHP_EOL . 
'    // auto include' . PHP_EOL .
'    require_once (DIR_FS_CATALOG.\'inc/auto_include.inc.php\');' . PHP_EOL .
'' . PHP_EOL .
'    foreach(auto_include(DIR_FS_CATALOG.\'includes/extra/configure/\',\'php\') as $file) require_once ($file);' . PHP_EOL .
'  }'. PHP_EOL .
'' . PHP_EOL .
'  // server' . PHP_EOL .
'  defined(\'HTTP_SERVER\') or define(\'HTTP_SERVER\', \'' . $http_server . '\'); // eg, http://localhost - should not be empty for productive servers' . PHP_EOL .
'  defined(\'HTTPS_SERVER\') or define(\'HTTPS_SERVER\', \'' . $https_server . '\'); // eg, https://localhost - should not be empty for productive servers' . PHP_EOL .
'' . PHP_EOL .
'  // secure SSL' . PHP_EOL .
'  defined(\'ENABLE_SSL\') or define(\'ENABLE_SSL\', ' . (($_POST['ENABLE_SSL'] == 'true') ? 'true' : 'false') . '); // secure webserver for checkout procedure?' . PHP_EOL .
'  defined(\'USE_SSL_PROXY\') or define(\'USE_SSL_PROXY\', ' . (($_POST['USE_SSL_PROXY'] == 'true') ? 'true' : 'false') . '); // using SSL proxy?' . PHP_EOL .
'' . PHP_EOL .
'  // session handling' . PHP_EOL .
'  defined(\'STORE_SESSIONS\') or define(\'STORE_SESSIONS\', \'' . (($_POST['STORE_SESSIONS'] == 'files') ? '' : 'mysql') . '\'); // leave empty \'\' for default handler or set to \'mysql\'' . PHP_EOL .                     
'' . PHP_EOL .
'  if (DB_DATABASE != \'\') {' . PHP_EOL . 
'    // set admin directory DIR_ADMIN' . PHP_EOL . 
'    require_once(DIR_FS_CATALOG.\'inc/set_admin_directory.inc.php\');' . PHP_EOL .
'' . PHP_EOL .
'    // include standard settings' . PHP_EOL .
'    require(DIR_FS_CATALOG.(defined(\'RUN_MODE_ADMIN\')? DIR_ADMIN : \'\').\'includes/paths.php\');'. PHP_EOL .
'  }'. PHP_EOL .
'?>';
?>