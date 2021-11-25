<?php
/* -----------------------------------------------------------------------------------------
   $Id: general_bottom.css.php 56 2016-04-28 11:45:58Z Tomcraft $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2006 XT-Commerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

   // This CSS file get includes at the BOTTOM of every template page in shop
   // you can add your template specific css scripts here

  $css_array = array(
    DIR_TMPL_CSS.'jquery.colorbox.css',
    DIR_TMPL_CSS.'jquery.sumoselect.css',
    DIR_TMPL_CSS.'jquery.alertable.css',
    DIR_TMPL_CSS.'jquery.slick.css',
    DIR_TMPL_CSS.'fontawesome-all.css',
    DIR_TMPL_CSS.'cookieconsent.css',
  );
  $css_min = DIR_TMPL_CSS.'tpl_plugins.min.css';

  $this_f_time = filemtime(DIR_FS_CATALOG.DIR_TMPL_CSS.'general_bottom.css.php');

  if (COMPRESS_STYLESHEET == 'true') {
    require_once(DIR_FS_BOXES_INC.'combine_files.inc.php');
    $css_array = combine_files($css_array,$css_min,true,$this_f_time);
  }
  
  foreach ($css_array as $css) {
    $css .= strpos($css,$css_min) === false ? '?v=' . filemtime(DIR_FS_CATALOG.$css) : '';
    echo '<link rel="stylesheet" property="stylesheet" href="'.DIR_WS_BASE.$css.'" type="text/css" media="screen" />'.PHP_EOL;
  }
?>
<!--[if lte IE 8]>
<link rel="stylesheet" property="stylesheet" href="<?php echo DIR_WS_BASE.DIR_TMPL_CSS; ?>ie8fix.css" type="text/css" media="screen" />
<![endif]-->