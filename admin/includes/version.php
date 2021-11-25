<?php
  /* --------------------------------------------------------------
   $Id: version.php 13499 2021-04-01 16:14:59Z Tomcraft $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org] 
   --------------------------------------------------------------*/

// DB version, used for updates (_installer)
define('DB_VERSION', 'MOD_2.0.6.0'); // ToDo before release!

define('PROJECT_MAJOR_VERSION', '2');
define('PROJECT_MINOR_VERSION', '0.6.0');
define('PROJECT_REVISION', '13500'); // ToDo before release!
define('PROJECT_SERVICEPACK_VERSION', ''); // currently not in use since new version numbers
define('PROJECT_RELEASE_DATE', '2021-04-01'); // ToDo before release!
define('MINIMUM_DB_VERSION', '200'); // currently not in use

// Define the project version
$version = 'modified eCommerce Shopsoftware v' . PROJECT_MAJOR_VERSION . '.' . PROJECT_MINOR_VERSION . ' rev ' . PROJECT_REVISION . ((PROJECT_SERVICEPACK_VERSION != '') ? ' SP' . PROJECT_SERVICEPACK_VERSION : ''). ' dated: ' . PROJECT_RELEASE_DATE;
defined('PROJECT_VERSION') OR define('PROJECT_VERSION', $version);

define('PROJECT_VERSION_NO', PROJECT_MAJOR_VERSION . '.' . PROJECT_MINOR_VERSION);
