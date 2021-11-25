<?php
  /* --------------------------------------------------------------
   $Id: backup_db.php 13059 2020-12-12 08:00:14Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2011 (c) by  web28 - www.rpa-com.de

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Datenbank Backup Manager');

define('TEXT_INFO_DO_BACKUP', 'Die Datenbank wird gesichert!');
define('TEXT_INFO_DO_BACKUP_OK', 'Die Datenbank wurde erfolgreich gesichert!');
define('TEXT_INFO_DO_GZIP', 'Die Backupdatei wird gepackt!');
define('TEXT_INFO_WAIT', 'Bitte warten!');

define('TEXT_INFO_DO_RESTORE', 'Die Datenbank wird wiederhergestellt!');
define('TEXT_INFO_DO_RESTORE_OK', 'Die Datenbank wurde erfolgreich wiederhergestellt!');
define('TEXT_INFO_DO_GUNZIP', 'Die Backupdatei wird entpackt!');

define('ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST', 'Fehler: das Verzeichnis f&uuml;r die Sicherung existiert nicht. Bitte beheben Sie den Fehler in Ihrer configure.php.');
define('ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE', 'Fehler: In das Verzeichnis f&uuml;r die Sicherung kann nicht geschrieben werden.');
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE', 'Fehler: Der Download Link ist nicht akzeptabel.');
define('ERROR_DECOMPRESSOR_NOT_AVAILABLE', 'Fehler: Kein geeigneter Entpacker verf&uuml;gbar.');
define('ERROR_UNKNOWN_FILE_TYPE', 'Fehler: Unbekannter Dateityp.');
define('ERROR_RESTORE_FAILES', 'Fehler: Wiederherstellung gescheitert.');
define('ERROR_DATABASE_SAVED', 'Fehler: Die Datenbank konnte nicht gesichert werden.');
define('ERROR_TEXT_PATH', 'Fehler: Der Pfad zu mysqldump wurde nicht gefunden oder angegeben!');

define('SUCCESS_LAST_RESTORE_CLEARED', 'Erfolgreich: Das letzte Wiederherstellungsdatum wurde gel&ouml;scht.');
define('SUCCESS_DATABASE_SAVED', 'Erfolgreich: Die Datenbank wurde gesichert.');
define('SUCCESS_DATABASE_RESTORED', 'Erfolgreich: Die Datenbank wurde wiederhergestellt.');
define('SUCCESS_BACKUP_DELETED', 'Erfolgreich: Die Sicherung wurde entfernt.');

define('TEXT_BACKUP_UNCOMPRESSED', 'Die Backupdatei wurde entpackt: ');

define('TEXT_SIMULATION', '<br>(Simulation mit log-Datei)');

?>