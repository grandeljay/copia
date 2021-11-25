<?php
/* --------------------------------------------------------------
   $Id: module_export.php 12077 2019-08-16 10:04:03Z GTB $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(modules.php,v 1.8 2002/04/09); www.oscommerce.com 
   (c) 2003	 nextcommerce (modules.php,v 1.5 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE_MODULES_EXPORT', 'Export Modules');
define('HEADING_TITLE_MODULES_SYSTEM', 'System Modules');

define('TABLE_HEADING_MODULES', 'Modules');
define('TABLE_HEADING_SORT_ORDER', 'Sort Order');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_MODULE_DIRECTORY', 'Module Directory:');

define('TABLE_HEADING_FILENAME','Module name (for internal usage)');
define('ERROR_EXPORT_FOLDER_NOT_WRITEABLE','Folder "export/" is not writeable!');
define('TEXT_MODULE_INFO','Please check the vendor of the modules for the latest version!');

define('TABLE_HEADING_MODULES_INSTALLED', 'Modules installed');
define('TABLE_HEADING_MODULES_NOT_INSTALLED', 'Modules not installed');
define('TEXT_MODULE_UPDATE_NEEDED', 'The following modules have been updated and need to update the database. For this please save the settings and reinstall these modules.');
?>