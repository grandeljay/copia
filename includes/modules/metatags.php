<?php
/* -----------------------------------------------------------------------------------------
   $Id: metatags.php 10337 2016-10-25 08:10:34Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
    (c) 2003 nextcommerce (metatags.php, v1.7 2003/08/14); www.nextcommerce.org
    (c) 2006 xt:Commerce (metatags.php, v.1140 2005/08/10); www.xt-commerce.de

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------
   Modified by Gunnar Tillmann (August 2006)
   http://www.gunnart.de
   ---------------------------------------------------------------------------------------
    AUTOMATISCHE METATAGS MULTILANGUAGE f�r xt:Commerce 3.04
   ---------------------------------------------------------------------------------------
      Version 0.96n / 13. Dezember 2010 / DokuMan / modified eCommerce Shopsoftware

    -  Unterst�tzung f�r Pagination
   ---------------------------------------------------------------------------------------
      Version 0.96m / 26. August 2010 / DokuMan / modified eCommerce Shopsoftware

    -  Unterst�tzung f�r "canonical"-Tag
   ---------------------------------------------------------------------------------------
      Version 0.96 / 21. Juni 2009

    -  Umwandlung von Umlauten in Keywords statt in ae und oe JETZT in &auml; &ouml;
    -  "Bindestrich-W�rter" (z.B. T-Shirt oder DVD-Player) werden in den Keywords nicht
       mehr getrennt
    -  Metatags auch f�r ContentManager-Seiten (Achtung! Dazu Erweiterung erforderlich!)
    -  Im ContentManager k�nnen auch automatische Metatags aus eingebundenen HTML- oder
       Text-Dateien erzeugt werden
    -  Standard-Meta-Angaben durch Content-Metas auch mehrsprachig m�glich. Dazu eine
       Seite namens "STANDARD_META" anlegen
    -  Bei automatisch erzeugen Keywords oder Descriptions werden W�rter nach Zeilen-
       umbr�chen nicht mehr "zusammengezogen"
    -  Eigene (mehrsprachige) Metas f�r die Shop-Startseite m�glich - Dazu werden die
       Metas aus der "index"-Seite im ContentManager geholt
    -  Seiten-Nummer im Title bei Artikel-Listen (also Kategorien, Sonderangebote etc.)
    -  Eigener Title bei Suchergebnissen (Mit Seiten-Nummer, Suchbegriff, ggf. Hersteller
       und Kategorienname)
    -  Bei allen Seiten, die nicht "Kategorie", "Startseite", "Content", "Produkt" o.�.
       sind, wird der Title aus den Eintr�gen im $breadcrumb-Objekt zusammengesetzt
    -  BugFix: BreadCrumb wird nicht mehr verk�rzt
   ---------------------------------------------------------------------------------------
    Inspired by "Dynamic Meta" - Ein WordPress-PlugIn von Michael Schwarz
    http://www.php-vision.de/plugins-scripte/dynamicmeta-wpplugin.php
   ---------------------------------------------------------------------------------------*/


// ---------------------------------------------------------------------------------------
//  Konfiguration ...
// ---------------------------------------------------------------------------------------

  $metaStopWords   =  META_STOP_WORDS;
  $metaGoWords     =  META_GO_WORDS;
  $metaMinLength   =  META_MIN_KEYWORD_LENGTH; // Mindestl�nge eines Keywords
  $metaMaxLength   =  META_MAX_KEYWORD_LENGTH; // Maximall�nge eines Keywords
  $metaMaxKeywords =  META_KEYWORDS_NUMBER;    // Maximall Anzahl der Keywords
  $metaDesLength   =  META_DESCRIPTION_LENGTH; // maximale L�nge der "description" (in Buchstaben)
// ---------------------------------------------------------------------------------------
  $addPagination        =   true;   // Seiten-Nummern anzeigen, ja/nein?
// ---------------------------------------------------------------------------------------
  $addCatShopTitle      =   ((META_CAT_SHOP_TITLE == 'true') ? true : false);   // Shop-Titel bei Kategorien anh�ngen, ja/nein?
  $addProdShopTitle     =   ((META_PROD_SHOP_TITLE == 'true') ? true : false);   // Shop-Titel bei Produkten anh�ngen, ja/nein?
  $addContentShopTitle  =   ((META_CONTENT_SHOP_TITLE == 'true') ? true : false);   // Shop-Titel bei Contentseiten anh�ngen, ja/nein?
  $addSpecialsShopTitle =   ((META_SPECIALS_SHOP_TITLE == 'true') ? true : false);   // Shop-Titel bei Angeboten anh�ngen, ja/nein?
  $addNewsShopTitle     =   ((META_NEWS_SHOP_TITLE == 'true') ? true : false);   // Shop-Titel bei Neuen Artikeln anh�ngen, ja/nein?
  $addSearchShopTitle   =   ((META_SEARCH_SHOP_TITLE == 'true') ? true : false);   // Shop-Titel bei Suchergebnissen anh�ngen, ja/nein?
  $addOthersShopTitle   =   ((META_OTHER_SHOP_TITLE == 'true') ? true : false);   // Shop-Titel bei sonstigen Seiten anh�ngen, ja/nein?
// ---------------------------------------------------------------------------------------
  $noIndexUnimportant   =   true;  // "unwichtige" Seiten mit noindex versehen
// ---------------------------------------------------------------------------------------
//  Diese Seiten sind "wichtig"! (ist nur relevant, wenn $noIndexUnimportand == true)
// ---------------------------------------------------------------------------------------
  $pagesToShow = array(
    FILENAME_DEFAULT,
    FILENAME_PRODUCT_INFO,
    FILENAME_CONTENT,
   // FILENAME_ADVANCED_SEARCH_RESULT,  // don't index search result
    FILENAME_SPECIALS,
    FILENAME_PRODUCTS_NEW
  );

// ---------------------------------------------------------------------------------------
//  Ende Konfiguration
// ---------------------------------------------------------------------------------------


//   Ab hier lieber nix mehr machen!

// ---------------------------------------------------------------------------------------
//  Title f�r "sonstige" Seiten
// ---------------------------------------------------------------------------------------
  //$breadcrumbTitle =   array_pop($breadcrumb->_trail);
  $breadcrumbTitle =   end($breadcrumb->_trail); // <-- BugFix
  $breadcrumbTitle =   $breadcrumbTitle['title'];
// ---------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------
//  noindex, nofollow bei "unwichtigen" Seiten
// ---------------------------------------------------------------------------------------
  $meta_robots = META_ROBOTS;
  if ($noIndexUnimportant && !in_array(basename($PHP_SELF),$pagesToShow)) {
    $meta_robots = 'noindex, nofollow, noodp';
  }
// ---------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------
//  MultiLanguage-Metas
// ---------------------------------------------------------------------------------------

  // Wenn wir auf der Startseite sind, Metas aus der index-Seite holen
  if (basename($PHP_SELF)==FILENAME_DEFAULT &&
    empty($_GET['cat']) &&
    empty($_GET['cPath']) &&
    empty($_GET['manufacturers_id'])
  ) {
    $ml_meta_where = "content_group = 5";

  // ... ansonsten Metas aus STANDARD_META holen
  } else {
    $ml_meta_where = "content_title = 'STANDARD_META'";
  }

  // Dadadadatenbank
  $ml_meta_query = xtDBquery("SELECT content_meta_title,
                                     content_meta_description,
                                     content_meta_keywords
                                FROM ".TABLE_CONTENT_MANAGER."
                               WHERE ".$ml_meta_where."
                                 AND languages_id = '".(int)$_SESSION['languages_id']."'");
  $ml_meta = xtc_db_fetch_array($ml_meta_query,true);

// ---------------------------------------------------------------------------------------
//  Mehrsprachige Standard-Metas definieren. Wenn leer, werden die �blichen genommen
// ---------------------------------------------------------------------------------------
  define('ML_META_KEYWORDS',($ml_meta['content_meta_keywords'])?$ml_meta['content_meta_keywords']:META_KEYWORDS);
  define('ML_META_DESCRIPTION',($ml_meta['content_meta_description'])?$ml_meta['content_meta_description']:META_DESCRIPTION);
  define('ML_TITLE',($ml_meta['content_meta_title'])?$ml_meta['content_meta_title']:TITLE);
// ---------------------------------------------------------------------------------------
  $metaGoWords = getGoWords(); // <-- nur noch einmal ausf�hren
// ---------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------
//   Seitennummerierung im Title (Kategorien, Sonderangebote, Neue Artikel etc. ) / Cannonical Tag Page Parameter
// ---------------------------------------------------------------------------------------
  $Page = $page_param = '';
  if (isset($_GET['page']) && $_GET['page'] < 0) $_GET['page'] = 1;
  if (isset($_GET['page']) && $_GET['page'] > 1 && $addPagination) {
    // PREVNEXT_TITLE_PAGE_NO ist "Seite %d" aus der deutschen bzw. "page %d" aus der englischen Sprachdatei ...
    $Page = trim(str_replace('%d','',PREVNEXT_TITLE_PAGE_NO)).' '.(int)$_GET['page'];
    //Cannonical Tag Page Parameter
    $page_param = '&page='. (int)$_GET['page'];
  }
// ---------------------------------------------------------------------------------------

  $set_hreflang = true;
  

// ---------------------------------------------------------------------------------------
//  Aufr�umen: Umlaute und Sonderzeichen wandeln.
// ---------------------------------------------------------------------------------------
  function metaNoEntities($Text){ 
    return decode_htmlentities($Text);  
  }  
// ---------------------------------------------------------------------------------------
//  Array basteln: Text aufbereiten -> Array erzeugen -> Array unique ...
// ---------------------------------------------------------------------------------------
  function prepareWordArray($Text) {
    //$Text = str_replace(array('&nbsp;','\t','\r','\n','\b'),' ',strip_tags($Text));
    $Text = str_replace(array('&nbsp;','\t','\r','\n','\b'),' ',preg_replace("/<[^>]*>/",' ',$Text)); // <-- Besser bei Zeilenumbr�chen
    $Text = encode_htmlentities(metaNoEntities($Text), ENT_QUOTES, $_SESSION['language_charset']);    
    $Text = preg_replace("/\s\-|\-\s/",' ',$Text); // <-- Gegen Trenn- und Gedankenstriche
    //$Text = preg_replace("/(&[^aoucizens][^;]*;)/",' ',$Text);
    $Text = strtolower($Text);
    $Text = preg_replace("/[^0-9a-z|\-|&|;]/",' ',$Text); // <-- Bindestriche drin lassen
    $Text = str_replace('& ', '&', $Text);    
    $Text = trim(preg_replace("/\s\s+/",' ',$Text));
    
    return $Text;
  }
  function makeWordArray($Text) {
    $Text = func_get_args();
    $Words = array();
    foreach($Text as $Word) {
      if ((!empty($Word))&&(is_string($Word))) {
        $Words = array_merge($Words,explode(' ',$Word));
      }
    }
    return array_unique($Words);
  }
  function WordArray($Text) {
    return makeWordArray(prepareWordArray($Text));
  }
// ---------------------------------------------------------------------------------------
//  KeyWords aufr�umen:
//   Stop- und KeyWords-Liste in Array umwandeln, StopWords l�schen,
//  GoWords- und L�ngen-Filter anwenden
// ---------------------------------------------------------------------------------------
  function cleanKeyWords($KeyWords) {
    global $metaStopWords;
    $KeyWords   =   WordArray($KeyWords);
    $StopWords   =  WordArray($metaStopWords);
    $KeyWords   =   array_diff($KeyWords,$StopWords);
    $KeyWords   =   array_filter($KeyWords,"filterKeyWordArray");
    return $KeyWords;
  }
// ---------------------------------------------------------------------------------------
//  GoWords- und L�ngen-Filter:
//  Alles, was zu kurz ist, fliegt raus, sofern nicht in der GoWords-Liste
// ---------------------------------------------------------------------------------------
  function filterKeyWordArray($KeyWord) {
    global $metaMinLength, $metaMaxLength, $metaGoWords;
    $GoWords = WordArray($metaGoWords);
    if (!in_array($KeyWord,$GoWords)) {
      //$Length = strlen($KeyWord);
      $Length = strlen(preg_replace("/(&[^;]*;)/",'#',$KeyWord)); // <-- Mindest-L�nge auch bei Umlauten ber�cksichtigen
      if ($Length < $metaMinLength) { // Mindest-L�nge
        return false;
      } elseif ($Length > $metaMaxLength) { // Maximal-L�nge
        return false;
      }
    }
    return true;
  }
// ---------------------------------------------------------------------------------------
//  GoWords: Werden grunds�tzlich nicht gefiltert
//  Sofern angelegt, werden (zus�tzlich zu den Einstellungen oben) die "normalen"
//  Meta-Angaben genommen (gefixed anno Danno-Wanno)
// ---------------------------------------------------------------------------------------
  function getGoWords(){
    global $metaGoWords, $categories_meta, $product;
    //$GoWords = $metaGoWords.' '.META_KEYWORDS;
    $GoWords = $metaGoWords.' '.ML_META_KEYWORDS.' '.ML_TITLE; // <-- MultiLanguage
    $GoWords .= ' '.$categories_meta['categories_meta_keywords'];
    if (isset($product->data['products_meta_keywords'])) $GoWords .= ' '.$product->data['products_meta_keywords'];
    return $GoWords;
  }
// ---------------------------------------------------------------------------------------
//  Aufr�umen: Leerzeichen und HTML-Code raus, k�rzen, Umlaute und Sonderzeichen wandeln
// ---------------------------------------------------------------------------------------
  function metaClean($Text,$Length=false,$Abk=' ...') {
    //$Text = strip_tags($Text);
    $Text = preg_replace("/<[^>]*>/",' ',$Text); // <-- Besser bei Zeilenumbr�chen
    $Text = metaNoEntities($Text);
    $Text = str_replace(array('&nbsp;','\t','\r','\n','\b'),' ',$Text);
    $Text = trim(preg_replace("/\s\s+/",' ',$Text));
    if ($Length > 0) {
      if (strlen($Text) > $Length) {
        $Length -= strlen($Abk);
        $Text = preg_replace('/\s+?(\S+)?$/','',substr($Text,0,$Length+1));
        $Text = substr($Text,0,$Length).$Abk;
      }
    }
    $Text = encode_htmlspecialchars($Text, ENT_QUOTES, $_SESSION['language_charset']);
    return str_replace('&amp;','&',$Text); 
  }
// ---------------------------------------------------------------------------------------
//  metaTitle und metaKeyWords, R�ckgabe bzw. Formatierung
// ---------------------------------------------------------------------------------------
  function metaTitle($Title=array()) {
    $Title = func_get_args();
    $Title = array_filter($Title,"metaClean");
    return implode(' - ',$Title);
  }
// ---------------------------------------------------------------------------------------
  function metaKeyWords($Text) {
   //BOC - web28 - 2011-03-14 - add metaMaxKeywords
    global $metaMaxKeywords;
    $KeyWords = cleanKeyWords($Text);
    if (count($KeyWords)  > $metaMaxKeywords) {
      $KeyWords = array_slice($KeyWords, 0 ,$metaMaxKeywords);
    }
    //EOC - web28 - 2011-03-14 - add metaMaxKeywords
    return implode(', ',$KeyWords);
  }
// ---------------------------------------------------------------------------------------

// Start Switch
switch(basename($PHP_SELF)) {

// ---------------------------------------------------------------------------------------
//  Daten holen: Produktdetails
// ---------------------------------------------------------------------------------------
  case FILENAME_PRODUCT_INFO :

    if ($product->isProduct() === true) {
      // KeyWords ...
      if (!empty($product->data['products_meta_keywords'])) {
        $meta_keyw = $product->data['products_meta_keywords'];
      } else {
        $meta_keyw = metaKeyWords($product->data['products_name'].' '.$product->data['products_description']);
      }

      // Description ...
      if (!empty($product->data['products_meta_description'])) {
        $meta_descr = $product->data['products_meta_description'];
        $metaDesLength = false;
      } else {
        $meta_descr = $product->data['products_name'].': '.$product->data['products_description'];
      }

      // Title ...
      if (!empty($product->data['products_meta_title'])) {
        $meta_title = $product->data['products_meta_title'].(($addProdShopTitle)?' - '.ML_TITLE:'');
      } else {
        $meta_title = metaTitle($product->data['products_name'],isset($product->data['manufacturers_name'])?$product->data['manufacturers_name']:'',$Page,($addProdShopTitle)?ML_TITLE:'');
      }

      //-- Canonical-URL
      //-- http://www.linkvendor.com/blog/der-canonical-tag-%E2%80%93-was-kann-man-damit-machen.html
      $canonical_flag = true;
      $canonical_url = xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$product->data['products_id'], 'NONSSL', false);
      $canonical_flag = false;
      //Wenn Produkt URL nicht Canonical URL dann auf noindex setzen und keine hreflang setzen
      $product_link = str_replace(array(HTTP_SERVER,HTTPS_SERVER), '', preg_replace("/([^\?]*)(\?.*)/", "$1", $canonical_url));
      $current_link = preg_replace("/([^\?]*)(\?.*)/", "$1", $_SERVER['REQUEST_URI']);
      if ($product_link != $current_link) {
        $set_hreflang = false;
        //$meta_robots = 'noindex'; // Nicht notwendig, da Google sonst den canonical gar nicht mitbekommt
      }
    }
    break;
// ---------------------------------------------------------------------------------------
//  Daten holen: Kategorie
// ---------------------------------------------------------------------------------------
  case FILENAME_DEFAULT :

    $startpage = true;
    // Sind wir in einer Kategorie?
    if (!empty($current_category_id)) {
      $categories_meta_query = xtDBquery("SELECT categories_meta_keywords,
                                                 categories_meta_description,
                                                 categories_meta_title,
                                                 categories_name,
                                                 categories_description
                                            FROM ".TABLE_CATEGORIES_DESCRIPTION."
                                           WHERE categories_id='".(int)$current_category_id."'
                                             AND language_id='".(int)$_SESSION['languages_id']."'");
      $categories_meta = xtc_db_fetch_array($categories_meta_query, true);
      $startpage = false;
    }

    $manu_id = $manu_name = false;

    // Nachsehen, ob ein Hersteller gew�hlt ist
    if (!empty($_GET['manufacturers_id'])) {
      $manu_id = (int)$_GET['manufacturers_id'];
      $startpage = false;
    }
    if (!empty($_GET['filter_id']) && $manu_id === false) {
      $manu_id = (int)$_GET['filter_id'];
      $startpage = false;
    }

    // ggf. Herstellernamen herausfinden ...
    if ($manu_id !== false) {
      $manu_name_query = xtDBquery("SELECT m.manufacturers_name,
                                           mi.manufacturers_meta_keywords,
                                           mi.manufacturers_meta_description,
                                           mi.manufacturers_meta_title
                                      FROM ".TABLE_MANUFACTURERS." m 
                                      JOIN ".TABLE_MANUFACTURERS_INFO." mi 
                                           ON m.manufacturers_id=mi.manufacturers_id
                                              AND mi.languages_id = '".(int)$_SESSION['languages_id']."'
                                     WHERE m.manufacturers_id = '".(int)$manu_id."'");
      $manu_name = xtc_db_fetch_array($manu_name_query, true);
  
      if (empty($current_category_id)) {      
        $categories_meta['categories_meta_title'] = ((!empty($manu_name['manufacturers_meta_title'])) ? $manu_name['manufacturers_meta_title'] : $manu_name['manufacturers_name']);
        $categories_meta['categories_meta_keywords'] = ((!empty($manu_name['manufacturers_meta_keywords'])) ? $manu_name['manufacturers_meta_keywords'] : $manu_name['manufacturers_name']);
        ((!empty($manu_name['manufacturers_meta_description'])) ? $categories_meta['categories_meta_description'] = $manu_name['manufacturers_meta_description'] : false);

        $metaGoWords .= ','.$manu_name['manufacturers_name']; // <-- zu GoWords hinzuf�gen
        $manu_name = '';
      } else {
        $manu_name = $manu_name['manufacturers_name'];
        $metaGoWords .= ','.$manu_name; // <-- zu GoWords hinzuf�gen
      }
    }

    // KeyWords ...
    if (!empty($categories_meta['categories_meta_keywords'])) {
      $meta_keyw = $categories_meta['categories_meta_keywords']; // <-- 1:1 �bernehmen!
    } else{
      $meta_keyw = metaKeyWords($categories_meta['categories_name'].' '.$manu_name.' '.$categories_meta['categories_description']);
    }

    // Description ...
    if (!empty($categories_meta['categories_meta_description'])) {
      // ggf. Herstellername hinzuf�gen
      $meta_descr = $categories_meta['categories_meta_description'].(($manu_name)?' - '.$manu_name:'');
      $metaDesLength = false;
    } elseif ($categories_meta) {
      // ggf. Herstellername und Kategorientext hinzuf�gen
      $meta_descr = $categories_meta['categories_name'].(($manu_name)?' - '.$manu_name:'').(($categories_meta['categories_description'])?' - '.$categories_meta['categories_description']:'');
    }

    // Title ...
    if (!empty($categories_meta['categories_meta_title'])) {
      // Meta-Titel, ggf. Herstellername, ggf. Seiten-Nummer, ggf. Shop-Titel
      $meta_title = $categories_meta['categories_meta_title'].(($manu_name)?' - '.$manu_name:'').(($Page)?' - '.$Page:'').(($addCatShopTitle)?' - '.ML_TITLE:'');
    } else{
      $meta_title = metaTitle($categories_meta['categories_name'],$manu_name,$Page,($addCatShopTitle)?ML_TITLE:'');
    }

    //-- Canonical-URL
    //-- http://www.linkvendor.com/blog/der-canonical-tag-%E2%80%93-was-kann-man-damit-machen.html
    if (xtc_not_null($cPath)) {
      $canonical_url = xtc_href_link(FILENAME_DEFAULT, 'cPath='.$cPath,'NONSSL',false);
    } elseif (xtc_not_null($manu_id)) {
      $canonical_url = xtc_href_link(FILENAME_DEFAULT, 'manufacturers_id='.(int)$manu_id,'NONSSL',false);
    } elseif ($startpage) {
      $canonical_url = xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL',false);
    }
    break;
// ---------------------------------------------------------------------------------------
//  Daten holen: Inhalts-Seite (ContentManager)
// ---------------------------------------------------------------------------------------
  case FILENAME_CONTENT :

    $contents_meta_query = xtDBquery("SELECT content_meta_title,
                                             content_meta_description,
                                             content_meta_keywords,
                                             content_meta_robots,
                                             content_title,
                                             content_heading,
                                             content_text,
                                             content_file
                                        FROM ".TABLE_CONTENT_MANAGER."
                                       WHERE content_group = '".(int)$_GET['coID']."'
                                         AND languages_id = '".(int)$_SESSION['languages_id']."'");

    if (xtc_db_num_rows($contents_meta_query, true) > 0) {
      $contents_meta = xtc_db_fetch_array($contents_meta_query,true);

      // NEU! Eingebundene Dateien auslesen
      if ($contents_meta['content_file']) {
        // Nur Text- oder HTML-Dateien!
        if (preg_match("/\.(txt|htm|html)$/i", $contents_meta['content_file'])) {
          $contents_meta['content_text'] .= ' '.implode(' ', @file(DIR_FS_CATALOG.'media/content/'.$contents_meta['content_file']));
        }
      }
      
      // meta robots
      if ($contents_meta['content_meta_robots']!='') {
        $meta_robots = $contents_meta['content_meta_robots'];
      }
      
      // KeyWords ...
      if (!empty($contents_meta['content_meta_keywords'])) {
        $meta_keyw = $contents_meta['content_meta_keywords'];
      } else {
        $meta_keyw = metaKeyWords($contents_meta['content_title'].' '.$contents_meta['content_heading'].' '.$contents_meta['content_text']);
      }

      // Title ...
      if (!empty($contents_meta['content_meta_title'])) {
        $meta_title = $contents_meta['content_meta_title'].(($addContentShopTitle)?' - '.ML_TITLE:'');
      } else {
        $meta_title = metaTitle($contents_meta['content_title'],$contents_meta['content_heading'],($addContentShopTitle)?ML_TITLE:'');
      }

      // Description ...
      if (!empty($contents_meta['content_meta_description'])) {
        $meta_descr = $contents_meta['content_meta_description'];
        $metaDesLength = false;
      } else {
        $meta_descr = ($contents_meta['content_heading'])?$contents_meta['content_heading'].': ':'';
        $meta_descr .= $contents_meta['content_text'];
      }
    }

    //-- Canonical-URL
    //-- http://www.linkvendor.com/blog/der-canonical-tag-%E2%80%93-was-kann-man-damit-machen.html
    if (isset($_GET['coID'])){
      $canonical_url = xtc_href_link(FILENAME_CONTENT, 'coID='.(int)$_GET['coID'],'NONSSL',false);
    }
    break;
// ---------------------------------------------------------------------------------------
//  Title f�r Suchergebnisse - Mit Suchbegriff, Kategorien-Namen, Seiten-Nummer etc.
// ---------------------------------------------------------------------------------------
  case FILENAME_ADVANCED_SEARCH_RESULT :

    // ggf. Herstellernamen herausfinden ...
    if (!empty($_GET['manufacturers_id'])) {
      $manu_name_query = xtDBquery("SELECT manufacturers_name
                                      FROM ".TABLE_MANUFACTURERS."
                                     WHERE manufacturers_id = '".(int)$_GET['manufacturers_id']."'
      ");
      $manu_name = xtc_db_fetch_array($manu_name_query,true);
      is_array($manu_name) ? $manu_name = implode('',$manu_name) :  $manu_name = '';
      $metaGoWords .= ','.$manu_name; // <-- zu GoWords hinzuf�gen
    }
    // ggf. Kategorien-Namen herausfinden ...
    if (!empty($_GET['categories_id'])) {
      $cat_name_query = xtDBquery("SELECT categories_name
                                     FROM ".TABLE_CATEGORIES_DESCRIPTION."
                                    WHERE categories_id='".(int)$_GET['categories_id']."'
                                      AND language_id='".(int)$_SESSION['languages_id']."'");
      $cat_name = xtc_db_fetch_array($cat_name_query,true);
      is_array($cat_name) ? $cat_name = implode('',$cat_name) :  $cat_name = '';
    }

    $meta_title = metaTitle($breadcrumbTitle,
                            $Page,
                            (isset($cat_name) ? $cat_name : ''),
                            (isset($manu_name) ? $manu_name :  ''),
                            ($addSearchShopTitle) ? ML_TITLE : ''
                            );
    break;
// ---------------------------------------------------------------------------------------
//  Title f�r Angebote
// ---------------------------------------------------------------------------------------
  case FILENAME_SPECIALS :

    $meta_title = metaTitle($breadcrumbTitle,$Page,($addSpecialsShopTitle)?ML_TITLE:'');
    $canonical_url = xtc_href_link(FILENAME_SPECIALS,'','NONSSL',false);
    break;
// ---------------------------------------------------------------------------------------
//  Title f�r Neue Artikel
// ---------------------------------------------------------------------------------------
  case FILENAME_PRODUCTS_NEW :

    $meta_title = metaTitle($breadcrumbTitle,$Page,($addNewsShopTitle)?ML_TITLE:'');
    $canonical_url = xtc_href_link(FILENAME_PRODUCTS_NEW,'','NONSSL',false);
    break;
// ---------------------------------------------------------------------------------------
//  Title f�r sonstige Seiten
// ---------------------------------------------------------------------------------------
  default:

    $meta_title = metaTitle($breadcrumbTitle,$Page,($addOthersShopTitle)?ML_TITLE:''); //DokuMan - 2010-12-13 - added meta pagination
    break;
// ---------------------------------------------------------------------------------------

}
// Ende Switch

// ---------------------------------------------------------------------------------------
//  ... und wenn nix drin, dann Standard-Werte nehmen
// ---------------------------------------------------------------------------------------
  // KeyWords ...
  if (empty($meta_keyw)) {
    $meta_keyw    = ML_META_KEYWORDS;
  }
  // Description ...
  if (empty($meta_descr)) {
    $meta_descr   = ML_META_DESCRIPTION;
    $metaDesLength = false;
  }
  // Title ...
  if (empty($meta_title)) {
    $meta_title   = ML_TITLE;
  }
// ---------------------------------------------------------------------------------------

if (TEMPLATE_HTML_ENGINE == 'xhtml') {
  echo '<meta http-equiv="Content-Type" content="text/html; charset='.$_SESSION['language_charset'].'" />'."\n";
  echo '<meta http-equiv="Content-Style-Type" content="text/css" />'."\n";
  echo '<meta http-equiv="cache-control" content="no-cache" />'."\n";
} else {
  echo '<meta charset="'.$_SESSION['language_charset'].'" />'."\n";
}
if (TEMPLATE_RESPONSIVE == 'true') {
  echo '<meta name="viewport" content="width=device-width, user-scalable=yes" />'."\n";
}
/******** SHOPGATE **********/
if (isset($shopgateJsHeader)) {
  echo $shopgateJsHeader;
}
/******** SHOPGATE **********/ 
if (metaClean($meta_title) != '') {
  echo '<title>'. metaClean($meta_title) .'</title>'."\n";
}
if ($_SESSION['language_code'] != '' && TEMPLATE_HTML_ENGINE == 'xhtml') {
  echo '<meta http-equiv="content-language" content="'. $_SESSION['language_code'] .'" />'."\n";
}
if (metaClean($meta_keyw) != '') {
  echo '<meta name="keywords" content="'. metaClean($meta_keyw) .'" />'."\n";
}
if (metaClean($meta_descr,$metaDesLength) != '') {
  echo '<meta name="description" content="'. metaClean($meta_descr,$metaDesLength) .'" />'."\n";
}
if ($_SESSION['language_code'] != '' && TEMPLATE_HTML_ENGINE == 'xhtml') {
  echo '<meta name="language" content="'. $_SESSION['language_code'] .'" />'."\n";
}
if ($meta_robots != '') {
  echo '<meta name="robots" content="'. $meta_robots .'" />'."\n";
}
if (metaClean(META_AUTHOR) != '') {
  echo '<meta name="author" content="'.metaClean(META_AUTHOR) .'" />'."\n";
}
if (metaClean(META_PUBLISHER) != '' && TEMPLATE_HTML_ENGINE == 'xhtml') {
  echo '<meta name="publisher" content="'. metaClean(META_PUBLISHER) .'" />'."\n";
}
if (metaClean(META_COMPANY) != '' && TEMPLATE_HTML_ENGINE == 'xhtml') {
  echo '<meta name="company" content="'. metaClean(META_COMPANY) .'" />'."\n";
}
if (metaClean(META_TOPIC) != '' && TEMPLATE_HTML_ENGINE == 'xhtml') {
  echo '<meta name="page-topic" content="'. metaClean(META_TOPIC) .'" />'."\n";
}
if (META_REPLY_TO != 'xx@xx.com' && TEMPLATE_HTML_ENGINE == 'xhtml') {
  echo '<meta name="reply-to" content="'. META_REPLY_TO .'" />'."\n";
}
if (META_REVISIT_AFTER != '0') {
  echo '<meta name="revisit-after" content="'. META_REVISIT_AFTER .' days" />'."\n";
}
if (META_GOOGLE_VERIFICATION_KEY != '') {
  echo '<meta name="google-site-verification" content="'. META_GOOGLE_VERIFICATION_KEY .'" />'."\n";
}
if (META_BING_VERIFICATION_KEY != '') {
  echo '<meta name="msvalidate.01" content="'. META_BING_VERIFICATION_KEY .'" />'."\n";
}

if (strpos($meta_robots,'noindex') !== false) {
  $set_hreflang = false;
  if (isset($canonical_url)) {
    unset($canonical_url);
  }
} else {
  $meta_url = parse_url($_SERVER['REQUEST_URI']);
  parse_str($meta_url['query'], $meta_params_array);
  if (count($meta_params_array) && !isset($meta_params_array['language']) && (!isset($_GET['page']) || $_GET['page'] > 1)) {
    $set_hreflang = false;
  }
}
$meta_alternate = array();
if (!isset($lng) || (isset($lng) && !is_object($lng))) {
  require_once(DIR_WS_CLASSES . 'language.php');
  $lng = new language;
}
if (SEARCH_ENGINE_FRIENDLY_URLS == 'true' && $set_hreflang && count($lng->catalog_languages) > 1 && (!isset($_GET['page']) || $_GET['page'] == 1)) {
  $canonical_flag = true;
  $x_default_flag = true;
  $x_default_lng = 'en'; //DEFAULT_LANGUAGE
  $x_default_link = xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array('page', 'language', 'currency')).'language='.$x_default_lng, 'NONSSL', false);
  if ($x_default_link != '#') {
    $meta_alternate['x-default'] = '<link rel="alternate" href="'.$x_default_link.'" hreflang="x-default" />';
  } else {
    $x_default_flag = false;
  }
  reset($lng->catalog_languages);
  while (list($key, $value) = each($lng->catalog_languages)) {
    $alternate_link = xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array('page', 'language', 'currency')).'language='.$key, 'NONSSL', false);
    if ($alternate_link != '#') {
      if ($x_default_flag === false) {
        $meta_alternate['x-default'] = '<link rel="alternate" href="'.$alternate_link.'" hreflang="x-default" />';
        $x_default_flag = true;
      } else {
        $meta_alternate[$value['code']] = '<link rel="alternate" href="'. $alternate_link .'" hreflang="'.$value['code'].'" />';
      }
    }
  }
  $canonical_flag = false;  
}
if (count($meta_alternate) > 2) {
  echo implode("\n",$meta_alternate)."\n";
} elseif (isset($canonical_url)) {
  echo '<link rel="canonical" href="'.$canonical_url.'" />'."\n";
}
if ($addPagination) {
  $number_of_pages = 0;
  $split_obj = array('listing_split', 'specials_split', 'products_new_split');
  foreach ($split_obj as $object) {
    if (isset(${$object}) && is_object(${$object})) {
      $number_of_pages = ${$object}->number_of_pages;
      break;
    }
  }
  if ($number_of_pages > 1) {
    $page = ((isset($_GET['page']) && $_GET['page'] > 0) ? (int)$_GET['page'] : 1);
    if ($page > 1 && $number_of_pages >= $page) {
      echo '<link rel="prev" href="'.xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array('page', 'language', 'currency')).(($page > 2) ? 'page='.($page - 1) : ''), 'NONSSL', false).'" />'."\n";
    }
    if ($page >= 1 && $number_of_pages > 1 && $number_of_pages > $page) {
      echo '<link rel="next" href="'.xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array('page', 'language', 'currency')).'page='.($page + 1), 'NONSSL', false).'" />'."\n";
    }
  }
}
?>