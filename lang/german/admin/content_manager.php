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
 define('HEADING_CONTENT','Seiten');
 define('HEADING_PRODUCTS_CONTENT','Artikel Content');
 define('HEADING_CONTENT_MANAGER_CONTENT','Seiten Content');
 define('HEADING_EMAIL_CONTENT','E-Mail Content');
 define('TABLE_HEADING_CONTENT_ID','ID');
 define('TABLE_HEADING_CONTENT_TITLE','Titel');
 define('TABLE_HEADING_CONTENT_FILE','Datei');
 define('TABLE_HEADING_CONTENT_STATUS','In Box sichtbar');
 define('TABLE_HEADING_CONTENT_BOX','Box');
 define('TABLE_HEADING_PRODUCTS_ID','ID');
 define('TABLE_HEADING_PRODUCTS','Artikel');
 define('TABLE_HEADING_PRODUCTS_CONTENT_ID','ID');
 define('TABLE_HEADING_CONTENT_MANAGER_ID','ID');
 define('TABLE_HEADING_CONTENT_MANAGER','Seiten');
 define('TABLE_HEADING_CONTENT_MANAGER_CONTENT_ID','ID');
 define('TABLE_HEADING_EMAIL_ID','ID');
 define('TABLE_HEADING_EMAIL','E-Mail');
 define('TABLE_HEADING_LANGUAGE','Sprache');
 define('TABLE_HEADING_CONTENT_NAME','Name/Dateiname');
 define('TABLE_HEADING_CONTENT_LINK','Link');
 define('TABLE_HEADING_CONTENT_HITS','Hits');
 define('TABLE_HEADING_CONTENT_GROUP','coID');
 define('TABLE_HEADING_CONTENT_SORT','Reihenfolge');
 defined('TEXT_YES') OR define('TEXT_YES','Ja');
 defined('TEXT_NO') OR define('TEXT_NO','Nein');
 define('TABLE_HEADING_CONTENT_ACTION','Aktion');
 defined('TEXT_DELETE') OR define('TEXT_DELETE','L&ouml;schen');
 define('TEXT_EDIT','Bearbeiten');
 define('TEXT_PREVIEW','Vorschau');
 define('CONFIRM_DELETE','Wollen Sie den Content wirklich l&ouml;schen?');
 define('CONTENT_NOTE','Content markiert mit <span class="col-red">*</span> geh&ouml;rt zum System und kann nicht gel&ouml;scht werden!');

 
 // edit
 define('TEXT_LANGUAGE','Sprache:');
 define('TEXT_STATUS','Sichtbar:');
 define('TEXT_STATUS_DESCRIPTION','Link in der Info Box angezeigen?');
 define('TEXT_TITLE','Titel:');
 define('TEXT_TITLE_FILE','Titel/Dateiname:');
 define('TEXT_HEADING','&Uuml;berschrift:');
 define('TEXT_CONTENT','Text:');
 define('TEXT_UPLOAD_FILE','Datei hochladen:');
 define('TEXT_UPLOAD_FILE_LOCAL','(von Ihrem lokalen System)');
 define('TEXT_CHOOSE_FILE','Datei w&auml;hlen:');
 define('TEXT_CHOOSE_FILE_DESC','Sie k&ouml;nnen ebenfalls eine bereits verwendete Datei aus der Liste ausw&auml;hlen.');
 defined('TEXT_NO_FILE') OR define('TEXT_NO_FILE','Auswahl L&ouml;schen');
 define('TEXT_CHOOSE_FILE_SERVER','(Falls Sie Ihre Dateien selbst via FTP auf Ihren Server gespeichert haben <i>(media/content)</i>, k&ouml;nnen Sie hier die Datei ausw&auml;hlen.');
 define('TEXT_CURRENT_FILE','Aktuelle Datei:');
 define('TEXT_FILE_DESCRIPTION','<b>Info:</b><br />Sie haben ebenfalls die M&ouml;glichkeit eine <b>.html</b> oder <b>.htm</b> Datei als Content einzubinden.<br />Falls Sie eine Datei ausw&auml;hlen oder hochladen, haben Sie die M&ouml;glichkeit zus&auml;tzlichen Text im Textfeld zu erstellen.<br />Dieser erscheint dann vor dem Text aus der hochgeladenen Datei.<br />Sollten Sie keine zus&auml;tzlichen Text w&uuml;nschen, lassen Sie das Textfeld bitte leer.');
 define('ERROR_FILE','Falsches Dateiformat (nur .html od .htm)');
 define('ERROR_TITLE','Bitte geben Sie einen Titel ein');
 define('ERROR_COMMENT','Bitte geben Sie eine Dateibeschreibung ein!');
 define('TEXT_FILE_FLAG','Box:');
 define('TEXT_PARENT','Hauptdokument:');
 define('TEXT_PARENT_DESCRIPTION','Diesem Dokument als Unter-Content zuweisen');
 define('TEXT_PRODUCT','Artikel:');
 define('TEXT_LINK','Link:');
 defined('TEXT_SORT_ORDER') OR define('TEXT_SORT_ORDER','Sortierung:');
 define('TEXT_GROUP','coID:');
 define('TEXT_GROUP_DESC','Mit dieser ID verkn&uuml;pfen Sie gleiche Themen unterschiedlicher Sprachen miteinander.');
 
 define('TEXT_CONTENT_DESCRIPTION','Mit diesem Content Manager haben Sie die M&ouml;glichkeit, jeden beliebige Dateityp einem Artikel hinzuzuf&uuml;gen.<br />Z.B. Artikelbeschreibungen, Handb&uuml;cher, technische Datenbl&auml;tter, H&ouml;rproben, usw...<br />Diese Elemente werden In der Artikel-Detailansicht angezeigt.<br /><br />');
 define('TEXT_CONTENT_MANAGER_CONTENT', 'Content:');
 define('TEXT_CONTENT_MANAGER_DESCRIPTION','Mit diesem Content Manager haben Sie die M&ouml;glichkeit, jeden beliebigen Dateityp einem Content hinzuzuf&uuml;gen.<br />Z.B. PDF f&uuml;r Rechtstexte, usw...<br />Diese Elemente werden in der Contentansicht angezeigt.<br /><br />');
 define('TEXT_EMAIL_CONTENT', 'E-Mail Content:');
 define('TEXT_EMAIL_DESCRIPTION','Mit diesem Content Manager haben Sie die M&ouml;glichkeit, jeden beliebigen Dateityp einer E-Mail als Anhang hinzuzuf&uuml;gen.<br />Z.B. PDF f&uuml;r Rechtstexte, usw...<br /><br />');

 define('TEXT_FILENAME','Benutze Datei:');
 define('TEXT_FILE_DESC','Beschreibung:');
 define('USED_SPACE','Verwendeter Speicherplatz:');
 define('TABLE_HEADING_CONTENT_FILESIZE','Dateigr&ouml;&szlig;e');
 define('TEXT_CONTENT_NOINDEX','noindex (Der Suchroboter soll die Webseite nicht in den Index aufnehmen.)');
 define('TEXT_CONTENT_NOFOLLOW','nofollow (Der Suchroboter darf die Webseite zwar aufnehmen, aber soll den Hyperlinks auf der Seite nicht folgen.)');
 define('TEXT_CONTENT_NOODP','noodp (Die Suchmaschine soll auf der Ergebnisseite nicht die Beschreibungstexte aus DMOZ (ODP) verwenden.)');
 define('TEXT_CONTENT_META_ROBOTS','Meta Robots');
 
 define('TABLE_HEADING_STATUS_ACTIVE', 'Status');
 define('TEXT_STATUS_ACTIVE', 'Status aktiv:'); 	 
 define('TEXT_STATUS_ACTIVE_DESCRIPTION', 'Content aktivieren?');
  
 define('TEXT_CONTENT_DOUBLE_GROUP_INDEX', 'Doppelter Content Gruppen Index! Bitte neu speichern. Das Problem wird damit automatisch behoben!');
 defined('TEXT_CHARACTERS') OR define('TEXT_CHARACTERS','Zeichen');
 define('TEXT_KEEP_FILENAME', 'Dateiname beibehalten:');
?>