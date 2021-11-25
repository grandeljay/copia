<?php
/* --------------------------------------------------------------
   $Id: content_manager.php 13378 2021-02-03 13:22:09Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (content_manager.php,v 1.8 2003/08/25); www.nextcommerce.org
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
 defined('HEADING_TITLE') OR define('HEADING_TITLE','Content Manager');
 define('HEADING_CONTENT','Site');
 define('HEADING_PRODUCTS_CONTENT','Products content');
 define('HEADING_CONTENT_MANAGER_CONTENT','Site content');
 define('HEADING_EMAIL_CONTENT','E-Mail Content');
 define('TABLE_HEADING_CONTENT_ID','ID');
 define('TABLE_HEADING_CONTENT_TITLE','Title');
 define('TABLE_HEADING_CONTENT_FILE','File');
 define('TABLE_HEADING_CONTENT_STATUS','Visible in box');
 define('TABLE_HEADING_CONTENT_BOX','Box');
 define('TABLE_HEADING_PRODUCTS_ID','ID');
 define('TABLE_HEADING_PRODUCTS','Product');
 define('TABLE_HEADING_PRODUCTS_CONTENT_ID','ID');
 define('TABLE_HEADING_CONTENT_MANAGER_ID','ID');
 define('TABLE_HEADING_CONTENT_MANAGER','Seiten');
 define('TABLE_HEADING_CONTENT_MANAGER_CONTENT_ID','ID');
 define('TABLE_HEADING_EMAIL_ID','ID');
 define('TABLE_HEADING_EMAIL','E-Mail');
 define('TABLE_HEADING_LANGUAGE','Language');
 define('TABLE_HEADING_CONTENT_NAME','Name/Filename');
 define('TABLE_HEADING_CONTENT_LINK','Link');
 define('TABLE_HEADING_CONTENT_HITS','Viewed');
 define('TABLE_HEADING_CONTENT_GROUP','coID');
 define('TABLE_HEADING_CONTENT_SORT','Sort Order');
 defined('TEXT_YES') OR define('TEXT_YES','Yes');
 defined('TEXT_NO') OR define('TEXT_NO','No');
 define('TABLE_HEADING_CONTENT_ACTION','Action');
 defined('TEXT_DELETE') OR define('TEXT_DELETE','Delete');
 define('TEXT_EDIT','Edit');
 define('TEXT_PREVIEW','Preview');
 define('CONFIRM_DELETE','Delete Content?');
 define('CONTENT_NOTE','Content marked with <span class="col-red">*</span> is a part of the system and cannot be deleted!');


 // edit
 define('TEXT_LANGUAGE','Language:');
 define('TEXT_STATUS','Visible:');
 define('TEXT_STATUS_DESCRIPTION','Show link in the information box?');
 define('TEXT_TITLE','Title:');
 define('TEXT_TITLE_FILE','Title/Filename:');
 define('TEXT_HEADING','Heading:');
 define('TEXT_CONTENT','Text:');
 define('TEXT_UPLOAD_FILE','Upload File:');
 define('TEXT_UPLOAD_FILE_LOCAL','(from local system)');
 define('TEXT_CHOOSE_FILE','Choose File:');
 define('TEXT_CHOOSE_FILE_DESC','You also can choose an existing file from the list.');
 defined('TEXT_NO_FILE') OR define('TEXT_NO_FILE','Delete Selection');
 define('TEXT_CHOOSE_FILE_SERVER','(If you uploaded your files already via FTP to <i>(media/content)</i>, you can select the file here.');
 define('TEXT_CURRENT_FILE','Current File:');
 define('TEXT_FILE_DESCRIPTION','<b>Info:</b><br />You also have the option to include a <b>.html</b> or <b>.htm</b> file as content.<br />If you select or upload a file, you have the option to create additional text in the text box.<br />This will then appear before the text from the uploaded file.<br />If you do not want additional text, please leave the text field empty.');
 define('ERROR_FILE','Wrong file format (only .html or .htm)');
 define('ERROR_TITLE','Please enter a title');
 define('ERROR_COMMENT','Please enter a file description!');
 define('TEXT_FILE_FLAG','Box:');
 define('TEXT_PARENT','Main Document:');
 define('TEXT_PARENT_DESCRIPTION','Assign to this document as sub-content');
 define('TEXT_PRODUCT','Product:');
 define('TEXT_LINK','Link:');
 defined('TEXT_SORT_ORDER') OR define('TEXT_SORT_ORDER','Sort:'); 
 define('TEXT_GROUP','coID');
 define('TEXT_GROUP_DESC','With this ID you link togehther similar subjects from different languages.');

 define('TEXT_CONTENT_DESCRIPTION','With this Content Manager you can add any filetype to a product, like technical sheets, productdetails, videos. These elements will be displayed on the products detailpage.<br /><br />');
 define('TEXT_CONTENT_MANAGER_CONTENT', 'Content:');
 define('TEXT_CONTENT_MANAGER_DESCRIPTION','With this Content Manager you can add any filetype to a content page.<br />E.g. PDF for legal texts, etc...<br />These elements will be displayed on the content page.<br /><br />');
 define('TEXT_EMAIL_CONTENT', 'E-Mail Content:');
 define('TEXT_EMAIL_DESCRIPTION','With this Content Manager you can add any filetype as an E-Mail attachment.<br />E.g. PDF for legal texts, etc...<br /><br />');

 define('TEXT_FILENAME','Used File:');
 define('TEXT_FILE_DESC','Description:');
 define('USED_SPACE','Used Space:');
 define('TABLE_HEADING_CONTENT_FILESIZE','Filesize');
 define('TEXT_CONTENT_NOINDEX','noindex (Disallow search engines from showing this page in their results.)');
 define('TEXT_CONTENT_NOFOLLOW','nofollow (Tells the search engines robots to not follow any links on the page at all.)');
 define('TEXT_CONTENT_NOODP','noodp (Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.)');
 define('TEXT_CONTENT_META_ROBOTS','Meta Robots');
 
 define('TABLE_HEADING_STATUS_ACTIVE', 'Status');
 define('TEXT_STATUS_ACTIVE', 'Status active:'); 	 
 define('TEXT_STATUS_ACTIVE_DESCRIPTION', 'Enable content?');
 
 define('TEXT_CONTENT_DOUBLE_GROUP_INDEX', 'Duplicate Content Group Index! Please save again. The problem is thus automatically corrected!');
 defined('TEXT_CHARACTERS') OR define('TEXT_CHARACTERS','Signs');
 define('TEXT_KEEP_FILENAME', 'Keep filename:');
?>