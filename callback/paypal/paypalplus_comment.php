<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypalplus_comment.php 10343 2016-10-26 11:54:18Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

chdir('../../');
include('includes/application_top.php');

if (!isset($_SESSION['customer_id'])) {
  xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));
}

require (DIR_WS_INCLUDES.'checkout_requirements.php');

$url_request = parse_url($_SERVER['HTTP_REFERER']);
$url_host = parse_url(constant(strtoupper($url_request['scheme']).'_SERVER'));

if ($url_host['host'] == $url_request['host']
    && basename($url_request['path']) == FILENAME_CHECKOUT_PAYMENT
    && isset($_POST['comments'])
    )
{
  $_SESSION['comments'] = $_POST['comments'];  
  session_write_close();
  xtc_db_close();
}
?>