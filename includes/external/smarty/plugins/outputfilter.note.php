<?php
/* -----------------------------------------------------------------------------------------
   $Id: outputfilter.note.php 14372 2022-04-25 17:00:00Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2006 xt:Commerce (campaigns.php 1117 2005-07-25)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

# Die modified eCommerce Shopsoftware ist eine freie Software, mit der zahlreiche H�ndler
# und Entwickler bares Geld verdienen. 
# Damit wir die laufende Weiterentwicklung erm�glichen k�nnen, sind wir aber ebenfalls auf
# Unterst�tzung angewiesen.
# Wenn Sie den nachfolgenden Backlink umformatieren m�chten, so k�nnen Sie dies tun und / 
# oder einen Link in Ihrem Impressum einf�gen.
# Gerne k�nnen Sie uns auch mit einer Spende unterst�tzen:
# http://www.modified-shop.org/spenden.html
# Vielen Dank f�r Ihre Fairness!

function smarty_outputfilter_note($tpl_output, $smarty) {
  global $PHP_SELF;
  
  $cop  = '<div class="copyright">';
  $cop .= ((MODULE_SMALL_BUSINESS == 'true') ? '<span class="small_bussiness">'.TAX_INFO_SMALL_BUSINESS_FOOTER.'</span><br/>' : '');
  $cop .= sprintf(((basename($PHP_SELF)=='index.php' && ($_SERVER['QUERY_STRING'] == '' || $_SERVER['QUERY_STRING'] == 'language='.$_SESSION['language_code'])) ? '<a rel="nofollow noopener" href="https://www.modified-shop.org" target="_blank">%s</a>' : '%s'), '<span class="cop_magenta">mod</span><span class="cop_grey">ified eCommerce Shopsoftware &copy; 2009-' . date('Y') . '</span>');
  $cop .= '</div>';

  //making output W3C-Conform: replace ampersands, rest is covered by the modified shopstat_functions.php - preg_replace by cYbercOsmOnauT: don't replace &&
  $tpl_output = preg_replace("/((?<!&))&(?!(&|amp;|#[0-9]+;|[a-z0-9]+;))/i", "&amp;", $tpl_output);

  if (TEMPLATE_HTML_ENGINE == 'html5') {
    $tpl_output = str_replace(' type="text/javascript"', '', $tpl_output); 
  }

  // compress HTML
  if (COMPRESS_HTML_OUTPUT == 'true') {
    require_once(DIR_FS_EXTERNAL.'compactor/compactor.php');
    $compactor = new Compactor();
    $tpl_output = $compactor->squeeze($tpl_output);
  }
  
  return $tpl_output.$cop;
}

# Die modified eCommerce Shopsoftware ist eine freie Software, mit der zahlreiche H�ndler
# und Entwickler bares Geld verdienen. 
# Damit wir die laufende Weiterentwicklung erm�glichen k�nnen, sind wir aber ebenfalls auf
# Unterst�tzung angewiesen.
# Wenn Sie den nachfolgenden Backlink umformatieren m�chten, so k�nnen Sie dies tun und / 
# oder einen Link in Ihrem Impressum einf�gen.
# Gerne k�nnen Sie uns auch mit einer Spende unterst�tzen:
# http://www.modified-shop.org/spenden.html
# Vielen Dank f�r Ihre Fairness!
?>