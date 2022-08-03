/* Afrikaans initialisation for the jQuery UI date picker plugin. */
/* Written by Renier Pretorius. */
jQuery(function($){
	$.datepicker.regional['af'] = {
		closeText: 'Selekteer',
		prevText: 'Vorige',
		nextText: 'Volgende',
		currentText: 'Vandag',
		monthNames: ['Januarie','Februarie','Maart','April','Mei','Junie',
		'Julie','Augustus','September','Oktober','November','Desember'],
		monthNamesShort: ['Jan', 'Feb', 'Mrt', 'Apr', 'Mei', 'Jun',
		'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'],
		dayNames: ['Sondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrydag', 'Saterdag'],
		dayNamesShort: ['Son', 'Maa', 'Din', 'Woe', 'Don', 'Vry', 'Sat'],
		dayNamesMin: ['So','Ma','Di','Wo','Do','Vr','Sa'],
		weekHeader: 'Wk',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['af']);
});
?/* Arabic Translation for jQuery UI date picker plugin. */
/* Khaled Al Horani -- koko.dw@gmail.com */
/* ???? ???????? -- koko.dw@gmail.com */
/* NOTE: monthNames are the original months names and they are the Arabic names, not the new months name ?????? - ????? and there isn't any Arabic roots for these months */
jQuery(function($){
	$.datepicker.regional['ar'] = {
		closeText: '?????',
		prevText: '&#x3c;??????',
		nextText: '??????&#x3e;',
		currentText: '?????',
		monthNames: ['????? ??????', '????', '????', '?????', '????', '??????',
		'????', '??', '?????',	'????? ?????', '????? ??????', '????? ?????'],
		monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
		dayNames: ['?????', '?????', '???????', '????????', '????????', '??????', '??????'],
		dayNamesShort: ['???', '???', '?????', '??????', '??????', '????', '????'],
		dayNamesMin: ['???', '???', '?????', '??????', '??????', '????', '????'],
		weekHeader: '?????',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
  		isRTL: true,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ar']);
});?/* Azerbaijani (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Jamil Najafov (necefov33@gmail.com). */
jQuery(function($) {
	$.datepicker.regional['az'] = {
		closeText: 'Ba?la',
		prevText: '&#x3c;Geri',
		nextText: '?r?li&#x3e;',
		currentText: 'BugÅn',
		monthNames: ['Yanvar','Fevral','Mart','Aprel','May','?yun',
		'?yul','Avqust','Sentyabr','Oktyabr','Noyabr','Dekabr'],
		monthNamesShort: ['Yan','Fev','Mar','Apr','May','?yun',
		'?yul','Avq','Sen','Okt','Noy','Dek'],
		dayNames: ['Bazar','Bazar ert?si','Ä?r??nb? ax?am’','Ä?r??nb?','CÅm? ax?am’','CÅm?','??nb?'],
		dayNamesShort: ['B','Be','Äa','Ä','Ca','C','?'],
		dayNamesMin: ['B','B','Ä','?','Ä','C','?'],
		weekHeader: 'Hf',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['az']);
});?/* Bulgarian initialisation for the jQuery UI date picker plugin. */
/* Written by Stoyan Kyosev (http://svest.org). */
jQuery(function($){
    $.datepicker.regional['bg'] = {
        closeText: '???????',
        prevText: '&#x3c;?????',
        nextText: '??????&#x3e;',
		nextBigText: '&#x3e;&#x3e;',
        currentText: '????',
        monthNames: ['??????','????????','????','?????','???','???',
        '???','??????','?????????','????????','???????','????????'],
        monthNamesShort: ['???','???','???','???','???','???',
        '???','???','???','???','???','???'],
        dayNames: ['??????','??????????','???????','?????','?????????','?????','??????'],
        dayNamesShort: ['???','???','???','???','???','???','???'],
        dayNamesMin: ['??','??','??','??','??','??','??'],
		weekHeader: 'Wk',
        dateFormat: 'dd.mm.yy',
		firstDay: 1,
        isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['bg']);
});
?/* Bosnian i18n for the jQuery UI date picker plugin. */
/* Written by Kenan Konjo. */
jQuery(function($){
	$.datepicker.regional['bs'] = {
		closeText: 'Zatvori',
		prevText: '&#x3c;',
		nextText: '&#x3e;',
		currentText: 'Danas',
		monthNames: ['Januar','Februar','Mart','April','Maj','Juni',
		'Juli','August','Septembar','Oktobar','Novembar','Decembar'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
		'Jul','Aug','Sep','Okt','Nov','Dec'],
		dayNames: ['Nedelja','Ponedeljak','Utorak','Srijeda','?etvrtak','Petak','Subota'],
		dayNamesShort: ['Ned','Pon','Uto','Sri','?et','Pet','Sub'],
		dayNamesMin: ['Ne','Po','Ut','Sr','?e','Pe','Su'],
		weekHeader: 'Wk',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['bs']);
});/* Inicialitzaci¢ en catalÖ per a l'extenci¢ 'calendar' per jQuery. */
/* Writers: (joan.leon@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ca'] = {
		closeText: 'Tancar',
		prevText: '&#x3c;Ant',
		nextText: 'Seg&#x3e;',
		currentText: 'Avui',
		monthNames: ['Gener','Febrer','Mar&ccedil;','Abril','Maig','Juny',
		'Juliol','Agost','Setembre','Octubre','Novembre','Desembre'],
		monthNamesShort: ['Gen','Feb','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Oct','Nov','Des'],
		dayNames: ['Diumenge','Dilluns','Dimarts','Dimecres','Dijous','Divendres','Dissabte'],
		dayNamesShort: ['Dug','Dln','Dmt','Dmc','Djs','Dvn','Dsb'],
		dayNamesMin: ['Dg','Dl','Dt','Dc','Dj','Dv','Ds'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ca']);
});?/* Czech initialisation for the jQuery UI date picker plugin. */
/* Written by Tomas Muller (tomas@tomas-muller.net). */
jQuery(function($){
	$.datepicker.regional['cs'] = {
		closeText: 'Zav?°t',
		prevText: '&#x3c;D?°ve',
		nextText: 'Pozd?ji&#x3e;',
		currentText: 'Nyn°',
		monthNames: ['leden','£nor','b?ezen','duben','kv?ten','?erven',
        '?ervenec','srpen','z†?°','?°jen','listopad','prosinec'],
		monthNamesShort: ['led','£no','b?e','dub','kv?','?er',
		'?vc','srp','z†?','?°j','lis','pro'],
		dayNames: ['ned?le', 'pond?l°', '£terÏ', 'st?eda', '?tvrtek', 'p†tek', 'sobota'],
		dayNamesShort: ['ne', 'po', '£t', 'st', '?t', 'p†', 'so'],
		dayNamesMin: ['ne','po','£t','st','?t','p†','so'],
		weekHeader: 'TÏd',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['cs']);
});
?/* Danish initialisation for the jQuery UI date picker plugin. */
/* Written by Jan Christensen ( deletestuff@gmail.com). */
jQuery(function($){
    $.datepicker.regional['da'] = {
		closeText: 'Luk',
        prevText: '&#x3c;Forrige',
		nextText: 'Nëste&#x3e;',
		currentText: 'Idag',
        monthNames: ['Januar','Februar','Marts','April','Maj','Juni',
        'Juli','August','September','Oktober','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dec'],
		dayNames: ['Sõndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lõrdag'],
		dayNamesShort: ['Sõn','Man','Tir','Ons','Tor','Fre','Lõr'],
		dayNamesMin: ['Sõ','Ma','Ti','On','To','Fr','Lõ'],
		weekHeader: 'Uge',
        dateFormat: 'dd-mm-yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['da']);
});
?/* German initialisation for the jQuery UI date picker plugin. */
/* Written by Milian Wolff (mail@milianw.de). */
jQuery(function($){
	$.datepicker.regional['de'] = {
		closeText: 'schlie·en',
		prevText: '&#x3c;zurÅck',
		nextText: 'Vor&#x3e;',
		currentText: 'heute',
		monthNames: ['Januar','Februar','MÑrz','April','Mai','Juni',
		'Juli','August','September','Oktober','November','Dezember'],
		monthNamesShort: ['Jan','Feb','MÑr','Apr','Mai','Jun',
		'Jul','Aug','Sep','Okt','Nov','Dez'],
		dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
		dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
		dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
		weekHeader: 'Wo',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['de']);
});
?/* Greek (el) initialisation for the jQuery UI date picker plugin. */
/* Written by Alex Cicovic (http://www.alexcicovic.com) */
jQuery(function($){
	$.datepicker.regional['el'] = {
		closeText: '????????',
		prevText: '????????????',
		nextText: '????????',
		currentText: '?????? ?????',
		monthNames: ['??????????','???????????','???????','????????','?????','???????',
		'???????','?????????','???????????','?????????','?????????','??????????'],
		monthNamesShort: ['???','???','???','???','???','????',
		'????','???','???','???','???','???'],
		dayNames: ['???????','???????','?????','???????','??????','?????????','???????'],
		dayNamesShort: ['???','???','???','???','???','???','???'],
		dayNamesMin: ['??','??','??','??','??','??','??'],
		weekHeader: '???',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['el']);
});?/* English/UK initialisation for the jQuery UI date picker plugin. */
/* Written by Stuart. */
jQuery(function($){
	$.datepicker.regional['en-GB'] = {
		closeText: 'Done',
		prevText: 'Prev',
		nextText: 'Next',
		currentText: 'Today',
		monthNames: ['January','February','March','April','May','June',
		'July','August','September','October','November','December'],
		monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
		'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
		dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		dayNamesMin: ['Su','Mo','Tu','We','Th','Fr','Sa'],
		weekHeader: 'Wk',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['en-GB']);
});
?/* Esperanto initialisation for the jQuery UI date picker plugin. */
/* Written by Olivier M. (olivierweb@ifrance.com). */
jQuery(function($){
	$.datepicker.regional['eo'] = {
		closeText: 'Fermi',
		prevText: '&lt;Anta',
		nextText: 'Sekv&gt;',
		currentText: 'Nuna',
		monthNames: ['Januaro','Februaro','Marto','Aprilo','Majo','Junio',
		'Julio','A?gusto','Septembro','Oktobro','Novembro','Decembro'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
		'Jul','A?g','Sep','Okt','Nov','Dec'],
		dayNames: ['Diman?o','Lundo','Mardo','Merkredo','?a?do','Vendredo','Sabato'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','?a?','Ven','Sab'],
		dayNamesMin: ['Di','Lu','Ma','Me','?a','Ve','Sa'],
		weekHeader: 'Sb',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['eo']);
});
/* Inicializaci¢n en espa§ol para la extensi¢n 'UI date picker' para jQuery. */
/* Traducido por Vester (xvester@gmail.com). */
jQuery(function($){
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
		'Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['es']);
});?/* Estonian initialisation for the jQuery UI date picker plugin. */
/* Written by Mart S‰mermaa (mrts.pydev at gmail com). */
jQuery(function($){
	$.datepicker.regional['et'] = {
		closeText: 'Sulge',
		prevText: 'Eelnev',
		nextText: 'JÑrgnev',
		currentText: 'TÑna',
		monthNames: ['Jaanuar','Veebruar','MÑrts','Aprill','Mai','Juuni',
		'Juuli','August','September','Oktoober','November','Detsember'],
		monthNamesShort: ['Jaan', 'Veebr', 'MÑrts', 'Apr', 'Mai', 'Juuni',
		'Juuli', 'Aug', 'Sept', 'Okt', 'Nov', 'Dets'],
		dayNames: ['PÅhapÑev', 'EsmaspÑev', 'TeisipÑev', 'KolmapÑev', 'NeljapÑev', 'Reede', 'LaupÑev'],
		dayNamesShort: ['PÅhap', 'Esmasp', 'Teisip', 'Kolmap', 'Neljap', 'Reede', 'Laup'],
		dayNamesMin: ['P','E','T','K','N','R','L'],
		weekHeader: 'Sm',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['et']);
}); ?/* Euskarako oinarria 'UI date picker' jquery-ko extentsioarentzat */
/* Karrikas-ek itzulia (karrikas@karrikas.com) */
jQuery(function($){
	$.datepicker.regional['eu'] = {
		closeText: 'Egina',
		prevText: '&#x3c;Aur',
		nextText: 'Hur&#x3e;',
		currentText: 'Gaur',
		monthNames: ['Urtarrila','Otsaila','Martxoa','Apirila','Maiatza','Ekaina',
		'Uztaila','Abuztua','Iraila','Urria','Azaroa','Abendua'],
		monthNamesShort: ['Urt','Ots','Mar','Api','Mai','Eka',
		'Uzt','Abu','Ira','Urr','Aza','Abe'],
		dayNames: ['Igandea','Astelehena','Asteartea','Asteazkena','Osteguna','Ostirala','Larunbata'],
		dayNamesShort: ['Iga','Ast','Ast','Ast','Ost','Ost','Lar'],
		dayNamesMin: ['Ig','As','As','As','Os','Os','La'],
		weekHeader: 'Wk',
		dateFormat: 'yy/mm/dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['eu']);
});?/* Persian (Farsi) Translation for the jQuery UI date picker plugin. */
/* Javad Mowlanezhad -- jmowla@gmail.com */
/* Jalali calendar should supported soon! (Its implemented but I have to test it) */
jQuery(function($) {
	$.datepicker.regional['fa'] = {
		closeText: '????',
		prevText: '&#x3c;????',
		nextText: '????&#x3e;',
		currentText: '?????',
		monthNames: ['???????','????????','?????','???','?????','??????',
		'???','????','???','??','????','?????'],
		monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
		dayNames: ['??????','??????','???????','????????','???????','????','????'],
		dayNamesShort: ['?','?','?','?','?','?', '?'],
		dayNamesMin: ['?','?','?','?','?','?', '?'],
		weekHeader: '??',
		dateFormat: 'yy/mm/dd',
		firstDay: 6,
		isRTL: true,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['fa']);
});/* Finnish initialisation for the jQuery UI date picker plugin. */
/* Written by Harri Kilpi? (harrikilpio@gmail.com). */
jQuery(function($){
    $.datepicker.regional['fi'] = {
		closeText: 'Sulje',
		prevText: '&laquo;Edellinen',
		nextText: 'Seuraava&raquo;',
		currentText: 'T&auml;n&auml;&auml;n',
        monthNames: ['Tammikuu','Helmikuu','Maaliskuu','Huhtikuu','Toukokuu','Kes&auml;kuu',
        'Hein&auml;kuu','Elokuu','Syyskuu','Lokakuu','Marraskuu','Joulukuu'],
        monthNamesShort: ['Tammi','Helmi','Maalis','Huhti','Touko','Kes&auml;',
        'Hein&auml;','Elo','Syys','Loka','Marras','Joulu'],
		dayNamesShort: ['Su','Ma','Ti','Ke','To','Pe','Su'],
		dayNames: ['Sunnuntai','Maanantai','Tiistai','Keskiviikko','Torstai','Perjantai','Lauantai'],
		dayNamesMin: ['Su','Ma','Ti','Ke','To','Pe','La'],
		weekHeader: 'Vk',
        dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['fi']);
});
?/* Faroese initialisation for the jQuery UI date picker plugin */
/* Written by Sverri Mohr Olsen, sverrimo@gmail.com */
jQuery(function($){
	$.datepicker.regional['fo'] = {
		closeText: 'Lat aftur',
		prevText: '&#x3c;Fyrra',
		nextText: 'Nësta&#x3e;',
		currentText: '÷ dag',
		monthNames: ['Januar','Februar','Mars','Apr°l','Mei','Juni',
		'Juli','August','September','Oktober','November','Desember'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Mei','Jun',
		'Jul','Aug','Sep','Okt','Nov','Des'],
		dayNames: ['Sunnudagur','M†nadagur','TÏsdagur','Mikudagur','H¢sdagur','Fr°ggjadagur','Leyardagur'],
		dayNamesShort: ['Sun','M†n','TÏs','Mik','H¢s','Fr°','Ley'],
		dayNamesMin: ['Su','M†','TÏ','Mi','H¢','Fr','Le'],
		weekHeader: 'Vk',
		dateFormat: 'dd-mm-yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['fo']);
});
?/* Swiss-French initialisation for the jQuery UI date picker plugin. */
/* Written Martin Voelkle (martin.voelkle@e-tc.ch). */
jQuery(function($){
	$.datepicker.regional['fr-CH'] = {
		closeText: 'Fermer',
		prevText: '&#x3c;PrÇc',
		nextText: 'Suiv&#x3e;',
		currentText: 'Courant',
		monthNames: ['Janvier','FÇvrier','Mars','Avril','Mai','Juin',
		'Juillet','Aoñt','Septembre','Octobre','Novembre','DÇcembre'],
		monthNamesShort: ['Jan','FÇv','Mar','Avr','Mai','Jun',
		'Jul','Aoñ','Sep','Oct','Nov','DÇc'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		weekHeader: 'Sm',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['fr-CH']);
});?/* French initialisation for the jQuery UI date picker plugin. */
/* Written by Keith Wood (kbwood{at}iinet.com.au) and StÇphane Nahmani (sholby@sholby.net). */
jQuery(function($){
	$.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: '&#x3c;PrÇc',
		nextText: 'Suiv&#x3e;',
		currentText: 'Courant',
		monthNames: ['Janvier','FÇvrier','Mars','Avril','Mai','Juin',
		'Juillet','Aoñt','Septembre','Octobre','Novembre','DÇcembre'],
		monthNamesShort: ['Jan','FÇv','Mar','Avr','Mai','Jun',
		'Jul','Aoñ','Sep','Oct','Nov','DÇc'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
});?/* Hebrew initialisation for the UI Datepicker extension. */
/* Written by Amir Hardon (ahardon at gmail dot com). */
jQuery(function($){
	$.datepicker.regional['he'] = {
		closeText: '????',
		prevText: '&#x3c;?????',
		nextText: '???&#x3e;',
		currentText: '????',
		monthNames: ['?????','??????','???','?????','???','????',
		'????','??????','??????','???????','??????','?????'],
		monthNamesShort: ['1','2','3','4','5','6',
		'7','8','9','10','11','12'],
		dayNames: ['?????','???','?????','?????','?????','????','???'],
		dayNamesShort: ['?\'','?\'','?\'','?\'','?\'','?\'','???'],
		dayNamesMin: ['?\'','?\'','?\'','?\'','?\'','?\'','???'],
		weekHeader: 'Wk',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: true,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['he']);
});
?/* Croatian i18n for the jQuery UI date picker plugin. */
/* Written by Vjekoslav Nesek. */
jQuery(function($){
	$.datepicker.regional['hr'] = {
		closeText: 'Zatvori',
		prevText: '&#x3c;',
		nextText: '&#x3e;',
		currentText: 'Danas',
		monthNames: ['Sije?anj','Velja?a','O?ujak','Travanj','Svibanj','Lipanj',
		'Srpanj','Kolovoz','Rujan','Listopad','Studeni','Prosinac'],
		monthNamesShort: ['Sij','Velj','O?u','Tra','Svi','Lip',
		'Srp','Kol','Ruj','Lis','Stu','Pro'],
		dayNames: ['Nedjelja','Ponedjeljak','Utorak','Srijeda','?etvrtak','Petak','Subota'],
		dayNamesShort: ['Ned','Pon','Uto','Sri','?et','Pet','Sub'],
		dayNamesMin: ['Ne','Po','Ut','Sr','?e','Pe','Su'],
		weekHeader: 'Tje',
		dateFormat: 'dd.mm.yy.',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['hr']);
});/* Hungarian initialisation for the jQuery UI date picker plugin. */
/* Written by Istvan Karaszi (jquery@spam.raszi.hu). */
jQuery(function($){
	$.datepicker.regional['hu'] = {
		closeText: 'bez†r†s',
		prevText: '&laquo;&nbsp;vissza',
		nextText: 'el?re&nbsp;&raquo;',
		currentText: 'ma',
		monthNames: ['Janu†r', 'Febru†r', 'M†rcius', 'µprilis', 'M†jus', 'J£nius',
		'J£lius', 'Augusztus', 'Szeptember', 'Okt¢ber', 'November', 'December'],
		monthNamesShort: ['Jan', 'Feb', 'M†r', 'µpr', 'M†j', 'J£n',
		'J£l', 'Aug', 'Szep', 'Okt', 'Nov', 'Dec'],
		dayNames: ['Vas†rnap', 'HÇtfî', 'Kedd', 'Szerda', 'CsÅtîrtîk', 'PÇntek', 'Szombat'],
		dayNamesShort: ['Vas', 'HÇt', 'Ked', 'Sze', 'CsÅ', 'PÇn', 'Szo'],
		dayNamesMin: ['V', 'H', 'K', 'Sze', 'Cs', 'P', 'Szo'],
		weekHeader: 'HÇ',
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['hu']);
});
/* Armenian(UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Levon Zakaryan (levon.zakaryan@gmail.com)*/
jQuery(function($){
	$.datepicker.regional['hy'] = {
		closeText: '?????',
		prevText: '&#x3c;???.',
		nextText: '???.&#x3e;',
		currentText: '?????',
		monthNames: ['???????','???????','????','?????','?????','??????',
		'??????','???????','?????????','?????????','????????','?????????'],
		monthNamesShort: ['?????','????','????','???','?????','??????',
		'????','???','???','???','???','???'],
		dayNames: ['??????','?????????','?????????','??????????','?????????','??????','?????'],
		dayNamesShort: ['???','???','???','???','???','????','???'],
		dayNamesMin: ['???','???','???','???','???','????','???'],
		weekHeader: '???',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['hy']);
});/* Indonesian initialisation for the jQuery UI date picker plugin. */
/* Written by Deden Fathurahman (dedenf@gmail.com). */
jQuery(function($){
	$.datepicker.regional['id'] = {
		closeText: 'Tutup',
		prevText: '&#x3c;mundur',
		nextText: 'maju&#x3e;',
		currentText: 'hari ini',
		monthNames: ['Januari','Februari','Maret','April','Mei','Juni',
		'Juli','Agustus','September','Oktober','Nopember','Desember'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Mei','Jun',
		'Jul','Agus','Sep','Okt','Nop','Des'],
		dayNames: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
		dayNamesShort: ['Min','Sen','Sel','Rab','kam','Jum','Sab'],
		dayNamesMin: ['Mg','Sn','Sl','Rb','Km','jm','Sb'],
		weekHeader: 'Mg',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['id']);
});/* Icelandic initialisation for the jQuery UI date picker plugin. */
/* Written by Haukur H. Thorsson (haukur@eskill.is). */
jQuery(function($){
	$.datepicker.regional['is'] = {
		closeText: 'Loka',
		prevText: '&#x3c; Fyrri',
		nextText: 'N&aelig;sti &#x3e;',
		currentText: '&Iacute; dag',
		monthNames: ['Jan&uacute;ar','Febr&uacute;ar','Mars','Apr&iacute;l','Ma&iacute','J&uacute;n&iacute;',
		'J&uacute;l&iacute;','&Aacute;g&uacute;st','September','Okt&oacute;ber','N&oacute;vember','Desember'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Ma&iacute;','J&uacute;n',
		'J&uacute;l','&Aacute;g&uacute;','Sep','Okt','N&oacute;v','Des'],
		dayNames: ['Sunnudagur','M&aacute;nudagur','&THORN;ri&eth;judagur','Mi&eth;vikudagur','Fimmtudagur','F&ouml;studagur','Laugardagur'],
		dayNamesShort: ['Sun','M&aacute;n','&THORN;ri','Mi&eth;','Fim','F&ouml;s','Lau'],
		dayNamesMin: ['Su','M&aacute;','&THORN;r','Mi','Fi','F&ouml;','La'],
		weekHeader: 'Vika',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['is']);
});/* Italian initialisation for the jQuery UI date picker plugin. */
/* Written by Antonello Pasella (antonello.pasella@gmail.com). */
jQuery(function($){
	$.datepicker.regional['it'] = {
		closeText: 'Chiudi',
		prevText: '&#x3c;Prec',
		nextText: 'Succ&#x3e;',
		currentText: 'Oggi',
		monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',
			'Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
		monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu',
			'Lug','Ago','Set','Ott','Nov','Dic'],
		dayNames: ['Domenica','Luned&#236','Marted&#236','Mercoled&#236','Gioved&#236','Venerd&#236','Sabato'],
		dayNamesShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
		dayNamesMin: ['Do','Lu','Ma','Me','Gi','Ve','Sa'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['it']);
});
?/* Japanese initialisation for the jQuery UI date picker plugin. */
/* Written by Kentaro SATO (kentaro@ranvis.com). */
jQuery(function($){
	$.datepicker.regional['ja'] = {
		closeText: '???',
		prevText: '&#x3c;?',
		nextText: '?&#x3e;',
		currentText: '??',
		monthNames: ['1?','2?','3?','4?','5?','6?',
		'7?','8?','9?','10?','11?','12?'],
		monthNamesShort: ['1?','2?','3?','4?','5?','6?',
		'7?','8?','9?','10?','11?','12?'],
		dayNames: ['???','???','???','???','???','???','???'],
		dayNamesShort: ['?','?','?','?','?','?','?'],
		dayNamesMin: ['?','?','?','?','?','?','?'],
		weekHeader: '?',
		dateFormat: 'yy/mm/dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '?'};
	$.datepicker.setDefaults($.datepicker.regional['ja']);
});/* Korean initialisation for the jQuery calendar extension. */
/* Written by DaeKwon Kang (ncrash.dk@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ko'] = {
		closeText: '??',
		prevText: '???',
		nextText: '???',
		currentText: '??',
		monthNames: ['1?(JAN)','2?(FEB)','3?(MAR)','4?(APR)','5?(MAY)','6?(JUN)',
		'7?(JUL)','8?(AUG)','9?(SEP)','10?(OCT)','11?(NOV)','12?(DEC)'],
		monthNamesShort: ['1?(JAN)','2?(FEB)','3?(MAR)','4?(APR)','5?(MAY)','6?(JUN)',
		'7?(JUL)','8?(AUG)','9?(SEP)','10?(OCT)','11?(NOV)','12?(DEC)'],
		dayNames: ['?','?','?','?','?','?','?'],
		dayNamesShort: ['?','?','?','?','?','?','?'],
		dayNamesMin: ['?','?','?','?','?','?','?'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: '?'};
	$.datepicker.setDefaults($.datepicker.regional['ko']);
});/* Lithuanian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* @author Arturas Paleicikas <arturas@avalon.lt> */
jQuery(function($){
	$.datepicker.regional['lt'] = {
		closeText: 'U?daryti',
		prevText: '&#x3c;Atgal',
		nextText: 'Pirmyn&#x3e;',
		currentText: '?iandien',
		monthNames: ['Sausis','Vasaris','Kovas','Balandis','Gegu??','Bir?elis',
		'Liepa','Rugpj?tis','Rugs?jis','Spalis','Lapkritis','Gruodis'],
		monthNamesShort: ['Sau','Vas','Kov','Bal','Geg','Bir',
		'Lie','Rugp','Rugs','Spa','Lap','Gru'],
		dayNames: ['sekmadienis','pirmadienis','antradienis','tre?iadienis','ketvirtadienis','penktadienis','?e?tadienis'],
		dayNamesShort: ['sek','pir','ant','tre','ket','pen','?e?'],
		dayNamesMin: ['Se','Pr','An','Tr','Ke','Pe','?e'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['lt']);
});/* Latvian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* @author Arturas Paleicikas <arturas.paleicikas@metasite.net> */
jQuery(function($){
	$.datepicker.regional['lv'] = {
		closeText: 'Aizv?rt',
		prevText: 'Iepr',
		nextText: 'N?ka',
		currentText: '?odien',
		monthNames: ['Janv?ris','Febru?ris','Marts','Apr?lis','Maijs','J?nijs',
		'J?lijs','Augusts','Septembris','Oktobris','Novembris','Decembris'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Mai','J?n',
		'J?l','Aug','Sep','Okt','Nov','Dec'],
		dayNames: ['sv?tdiena','pirmdiena','otrdiena','tre?diena','ceturtdiena','piektdiena','sestdiena'],
		dayNamesShort: ['svt','prm','otr','tre','ctr','pkt','sst'],
		dayNamesMin: ['Sv','Pr','Ot','Tr','Ct','Pk','Ss'],
		weekHeader: 'Nav',
		dateFormat: 'dd-mm-yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['lv']);
});/* Malaysian initialisation for the jQuery UI date picker plugin. */
/* Written by Mohd Nawawi Mohamad Jamili (nawawi@ronggeng.net). */
jQuery(function($){
	$.datepicker.regional['ms'] = {
		closeText: 'Tutup',
		prevText: '&#x3c;Sebelum',
		nextText: 'Selepas&#x3e;',
		currentText: 'hari ini',
		monthNames: ['Januari','Februari','Mac','April','Mei','Jun',
		'Julai','Ogos','September','Oktober','November','Disember'],
		monthNamesShort: ['Jan','Feb','Mac','Apr','Mei','Jun',
		'Jul','Ogo','Sep','Okt','Nov','Dis'],
		dayNames: ['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'],
		dayNamesShort: ['Aha','Isn','Sel','Rab','kha','Jum','Sab'],
		dayNamesMin: ['Ah','Is','Se','Ra','Kh','Ju','Sa'],
		weekHeader: 'Mg',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ms']);
});?/* Dutch (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Mathias Bynens <http://mathiasbynens.be/> */
jQuery(function($){
	$.datepicker.regional.nl = {
		closeText: 'Sluiten',
		prevText: '?',
		nextText: '?',
		currentText: 'Vandaag',
		monthNames: ['januari', 'februari', 'maart', 'april', 'mei', 'juni',
		'juli', 'augustus', 'september', 'oktober', 'november', 'december'],
		monthNamesShort: ['jan', 'feb', 'maa', 'apr', 'mei', 'jun',
		'jul', 'aug', 'sep', 'okt', 'nov', 'dec'],
		dayNames: ['zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag'],
		dayNamesShort: ['zon', 'maa', 'din', 'woe', 'don', 'vri', 'zat'],
		dayNamesMin: ['zo', 'ma', 'di', 'wo', 'do', 'vr', 'za'],
		weekHeader: 'Wk',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional.nl);
});/* Norwegian initialisation for the jQuery UI date picker plugin. */
/* Written by Naimdjon Takhirov (naimdjon@gmail.com). */
jQuery(function($){
    $.datepicker.regional['no'] = {
		closeText: 'Lukk',
        prevText: '&laquo;Forrige',
		nextText: 'Neste&raquo;',
		currentText: 'I dag',
        monthNames: ['Januar','Februar','Mars','April','Mai','Juni',
        'Juli','August','September','Oktober','November','Desember'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Mai','Jun',
        'Jul','Aug','Sep','Okt','Nov','Des'],
		dayNamesShort: ['Sõn','Man','Tir','Ons','Tor','Fre','Lõr'],
		dayNames: ['Sõndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lõrdag'],
		dayNamesMin: ['Sõ','Ma','Ti','On','To','Fr','Lõ'],
		weekHeader: 'Uke',
        dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['no']);
});
/* Polish initialisation for the jQuery UI date picker plugin. */
/* Written by Jacek Wysocki (jacek.wysocki@gmail.com). */
jQuery(function($){
	$.datepicker.regional['pl'] = {
		closeText: 'Zamknij',
		prevText: '&#x3c;Poprzedni',
		nextText: 'Nast?pny&#x3e;',
		currentText: 'Dzi?',
		monthNames: ['Stycze?','Luty','Marzec','Kwiecie?','Maj','Czerwiec',
		'Lipiec','Sierpie?','Wrzesie?','Pa?dziernik','Listopad','Grudzie?'],
		monthNamesShort: ['Sty','Lu','Mar','Kw','Maj','Cze',
		'Lip','Sie','Wrz','Pa','Lis','Gru'],
		dayNames: ['Niedziela','Poniedzia?ek','Wtorek','?roda','Czwartek','Pi?tek','Sobota'],
		dayNamesShort: ['Nie','Pn','Wt','?r','Czw','Pt','So'],
		dayNamesMin: ['N','Pn','Wt','?r','Cz','Pt','So'],
		weekHeader: 'Tydz',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['pl']);
});
/* Brazilian initialisation for the jQuery UI date picker plugin. */
/* Written by Leonildo Costa Silva (leocsilva@gmail.com). */
jQuery(function($){
	$.datepicker.regional['pt-BR'] = {
		closeText: 'Fechar',
		prevText: '&#x3c;Anterior',
		nextText: 'Pr&oacute;ximo&#x3e;',
		currentText: 'Hoje',
		monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
		'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});?/* Romanian initialisation for the jQuery UI date picker plugin.
 *
 * Written by Edmond L. (ll_edmond@walla.com)
 * and Ionut G. Stan (ionut.g.stan@gmail.com)
 */
jQuery(function($){
	$.datepicker.regional['ro'] = {
		closeText: '◊nchide',
		prevText: '&laquo; Luna precedent?',
		nextText: 'Luna urm?toare &raquo;',
		currentText: 'Azi',
		monthNames: ['Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie',
		'Iulie','August','Septembrie','Octombrie','Noiembrie','Decembrie'],
		monthNamesShort: ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun',
		'Iul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		dayNames: ['Duminic?', 'Luni', 'Mar?i', 'Miercuri', 'Joi', 'Vineri', 'SÉmb?t?'],
		dayNamesShort: ['Dum', 'Lun', 'Mar', 'Mie', 'Joi', 'Vin', 'SÉm'],
		dayNamesMin: ['Du','Lu','Ma','Mi','Jo','Vi','SÉ'],
		weekHeader: 'S?pt',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ro']);
});
/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ru'] = {
		closeText: '???????',
		prevText: '&#x3c;????',
		nextText: '????&#x3e;',
		currentText: '???????',
		monthNames: ['??????','???????','????','??????','???','????',
		'????','??????','????????','???????','??????','???????'],
		monthNamesShort: ['???','???','???','???','???','???',
		'???','???','???','???','???','???'],
		dayNames: ['???????????','???????????','???????','?????','???????','???????','???????'],
		dayNamesShort: ['???','???','???','???','???','???','???'],
		dayNamesMin: ['??','??','??','??','??','??','??'],
		weekHeader: '??',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});/* Slovak initialisation for the jQuery UI date picker plugin. */
/* Written by Vojtech Rinik (vojto@hmm.sk). */
jQuery(function($){
	$.datepicker.regional['sk'] = {
		closeText: 'Zavrie?',
		prevText: '&#x3c;Predch†dzaj£ci',
		nextText: 'Nasleduj£ci&#x3e;',
		currentText: 'Dnes',
		monthNames: ['Janu†r','Febru†r','Marec','Apr°l','M†j','J£n',
		'J£l','August','September','Okt¢ber','November','December'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','M†j','J£n',
		'J£l','Aug','Sep','Okt','Nov','Dec'],
		dayNames: ['Nedel\'a','Pondelok','Utorok','Streda','?tvrtok','Piatok','Sobota'],
		dayNamesShort: ['Ned','Pon','Uto','Str','?tv','Pia','Sob'],
		dayNamesMin: ['Ne','Po','Ut','St','?t','Pia','So'],
		weekHeader: 'Ty',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['sk']);
});
/* Slovenian initialisation for the jQuery UI date picker plugin. */
/* Written by Jaka Jancar (jaka@kubje.org). */
/* c = &#x10D;, s = &#x161; z = &#x17E; C = &#x10C; S = &#x160; Z = &#x17D; */
jQuery(function($){
	$.datepicker.regional['sl'] = {
		closeText: 'Zapri',
		prevText: '&lt;Prej&#x161;nji',
		nextText: 'Naslednji&gt;',
		currentText: 'Trenutni',
		monthNames: ['Januar','Februar','Marec','April','Maj','Junij',
		'Julij','Avgust','September','Oktober','November','December'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
		'Jul','Avg','Sep','Okt','Nov','Dec'],
		dayNames: ['Nedelja','Ponedeljek','Torek','Sreda','&#x10C;etrtek','Petek','Sobota'],
		dayNamesShort: ['Ned','Pon','Tor','Sre','&#x10C;et','Pet','Sob'],
		dayNamesMin: ['Ne','Po','To','Sr','&#x10C;e','Pe','So'],
		weekHeader: 'Teden',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['sl']);
});
?/* Albanian initialisation for the jQuery UI date picker plugin. */
/* Written by Flakron Bytyqi (flakron@gmail.com). */
jQuery(function($){
	$.datepicker.regional['sq'] = {
		closeText: 'mbylle',
		prevText: '&#x3c;mbrapa',
		nextText: 'Pârpara&#x3e;',
		currentText: 'sot',
		monthNames: ['Janar','Shkurt','Mars','Prill','Maj','Qershor',
		'Korrik','Gusht','Shtator','Tetor','Nântor','Dhjetor'],
		monthNamesShort: ['Jan','Shk','Mar','Pri','Maj','Qer',
		'Kor','Gus','Sht','Tet','Nân','Dhj'],
		dayNames: ['E Diel','E Hânâ','E Martâ','E Mârkurâ','E Enjte','E Premte','E Shtune'],
		dayNamesShort: ['Di','Hâ','Ma','Mâ','En','Pr','Sh'],
		dayNamesMin: ['Di','Hâ','Ma','Mâ','En','Pr','Sh'],
		weekHeader: 'Ja',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['sq']);
});
?/* Serbian i18n for the jQuery UI date picker plugin. */
/* Written by Dejan Dimi?. */
jQuery(function($){
	$.datepicker.regional['sr-SR'] = {
		closeText: 'Zatvori',
		prevText: '&#x3c;',
		nextText: '&#x3e;',
		currentText: 'Danas',
		monthNames: ['Januar','Februar','Mart','April','Maj','Jun',
		'Jul','Avgust','Septembar','Oktobar','Novembar','Decembar'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
		'Jul','Avg','Sep','Okt','Nov','Dec'],
		dayNames: ['Nedelja','Ponedeljak','Utorak','Sreda','?etvrtak','Petak','Subota'],
		dayNamesShort: ['Ned','Pon','Uto','Sre','?et','Pet','Sub'],
		dayNamesMin: ['Ne','Po','Ut','Sr','?e','Pe','Su'],
		weekHeader: 'Sed',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['sr-SR']);
});
?/* Serbian i18n for the jQuery UI date picker plugin. */
/* Written by Dejan Dimi?. */
jQuery(function($){
	$.datepicker.regional['sr'] = {
		closeText: '???????',
		prevText: '&#x3c;',
		nextText: '&#x3e;',
		currentText: '?????',
		monthNames: ['??????','???????','????','?????','???','???',
		'???','??????','?????????','???????','????????','????????'],
		monthNamesShort: ['???','???','???','???','???','???',
		'???','???','???','???','???','???'],
		dayNames: ['??????','?????????','??????','?????','????????','?????','??????'],
		dayNamesShort: ['???','???','???','???','???','???','???'],
		dayNamesMin: ['??','??','??','??','??','??','??'],
		weekHeader: '???',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['sr']);
});
?/* Swedish initialisation for the jQuery UI date picker plugin. */
/* Written by Anders Ekdahl ( anders@nomadiz.se). */
jQuery(function($){
    $.datepicker.regional['sv'] = {
		closeText: 'StÑng',
        prevText: '&laquo;Fîrra',
		nextText: 'NÑsta&raquo;',
		currentText: 'Idag',
        monthNames: ['Januari','Februari','Mars','April','Maj','Juni',
        'Juli','Augusti','September','Oktober','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dec'],
		dayNamesShort: ['Sîn','MÜn','Tis','Ons','Tor','Fre','Lîr'],
		dayNames: ['Sîndag','MÜndag','Tisdag','Onsdag','Torsdag','Fredag','Lîrdag'],
		dayNamesMin: ['Sî','MÜ','Ti','On','To','Fr','Lî'],
		weekHeader: 'Ve',
        dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['sv']);
});
?/* Tamil (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by S A Sureshkumar (saskumar@live.com). */
jQuery(function($){
	$.datepicker.regional['ta'] = {
		closeText: '????',
		prevText: '?????????',
		nextText: '????????',
		currentText: '?????',
		monthNames: ['??','????','???????','????????','??????','???',
		'???','????','?????????','??????','??????????','???????'],
		monthNamesShort: ['??','????','???','????','????','???',
		'???','??','???','???','????','????'],
		dayNames: ['???????????????','????????????','???????????????','??????????','????????????','?????????????','??????????'],
		dayNamesShort: ['??????','???????','????????','?????','???????','??????','???'],
		dayNamesMin: ['??','??','??','??','??','??','?'],
		weekHeader: '??',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ta']);
});
?/* Thai initialisation for the jQuery UI date picker plugin. */
/* Written by pipo (pipo@sixhead.com). */
jQuery(function($){
	$.datepicker.regional['th'] = {
		closeText: '???',
		prevText: '&laquo;&nbsp;????',
		nextText: '?????&nbsp;&raquo;',
		currentText: '??????',
		monthNames: ['??????','??????????','??????','??????','???????','????????',
		'???????','???????','???????','??????','?????????','???????'],
		monthNamesShort: ['?.?.','?.?.','??.?.','??.?.','?.?.','??.?.',
		'?.?.','?.?.','?.?.','?.?.','?.?.','?.?.'],
		dayNames: ['???????','??????','??????','???','????????','?????','?????'],
		dayNamesShort: ['??.','?.','?.','?.','??.','?.','?.'],
		dayNamesMin: ['??.','?.','?.','?.','??.','?.','?.'],
		weekHeader: 'Wk',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['th']);
});/* Turkish initialisation for the jQuery UI date picker plugin. */
/* Written by Izzet Emre Erkan (kara@karalamalar.net). */
jQuery(function($){
	$.datepicker.regional['tr'] = {
		closeText: 'kapat',
		prevText: '&#x3c;geri',
		nextText: 'ileri&#x3e',
		currentText: 'bugÅn',
		monthNames: ['Ocak','?ubat','Mart','Nisan','May’s','Haziran',
		'Temmuz','A?ustos','EylÅl','Ekim','Kas’m','Aral’k'],
		monthNamesShort: ['Oca','?ub','Mar','Nis','May','Haz',
		'Tem','A?u','Eyl','Eki','Kas','Ara'],
		dayNames: ['Pazar','Pazartesi','Sal’','Äar?amba','Per?embe','Cuma','Cumartesi'],
		dayNamesShort: ['Pz','Pt','Sa','Äa','Pe','Cu','Ct'],
		dayNamesMin: ['Pz','Pt','Sa','Äa','Pe','Cu','Ct'],
		weekHeader: 'Hf',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['tr']);
});/* Ukrainian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Maxim Drogobitskiy (maxdao@gmail.com). */
jQuery(function($){
	$.datepicker.regional['uk'] = {
		closeText: '???????',
		prevText: '&#x3c;',
		nextText: '&#x3e;',
		currentText: '????????',
		monthNames: ['??????','?????','????????','???????','???????','???????',
		'??????','???????','????????','???????','????????','???????'],
		monthNamesShort: ['???','???','???','???','???','???',
		'???','???','???','???','???','???'],
		dayNames: ['??????','?????????','????????','??????','??????','????????','??????'],
		dayNamesShort: ['???','???','???','???','???','???','???'],
		dayNamesMin: ['??','??','??','??','??','??','??'],
		weekHeader: '??',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['uk']);
});?/* Vietnamese initialisation for the jQuery UI date picker plugin. */
/* Translated by Le Thanh Huy (lthanhhuy@cit.ctu.edu.vn). */
jQuery(function($){
	$.datepicker.regional['vi'] = {
		closeText: '?¢ng',
		prevText: '&#x3c;Tr??c',
		nextText: 'Ti?p&#x3e;',
		currentText: 'Hìm nay',
		monthNames: ['Th†ng M?t', 'Th†ng Hai', 'Th†ng Ba', 'Th†ng T?', 'Th†ng N?m', 'Th†ng S†u',
		'Th†ng B?y', 'Th†ng T†m', 'Th†ng Ch°n', 'Th†ng M??i', 'Th†ng M??i M?t', 'Th†ng M??i Hai'],
		monthNamesShort: ['Th†ng 1', 'Th†ng 2', 'Th†ng 3', 'Th†ng 4', 'Th†ng 5', 'Th†ng 6',
		'Th†ng 7', 'Th†ng 8', 'Th†ng 9', 'Th†ng 10', 'Th†ng 11', 'Th†ng 12'],
		dayNames: ['Ch? Nh?t', 'Th? Hai', 'Th? Ba', 'Th? T?', 'Th? N?m', 'Th? S†u', 'Th? B?y'],
		dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
		dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
		weekHeader: 'Tu',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['vi']);
});
/* Chinese initialisation for the jQuery UI date picker plugin. */
/* Written by Cloudream (cloudream@gmail.com). */
jQuery(function($){
	$.datepicker.regional['zh-CN'] = {
		closeText: '??',
		prevText: '&#x3c;??',
		nextText: '??&#x3e;',
		currentText: '??',
		monthNames: ['??','??','??','??','??','??',
		'??','??','??','??','???','???'],
		monthNamesShort: ['?','?','?','?','?','?',
		'?','?','?','?','??','??'],
		dayNames: ['???','???','???','???','???','???','???'],
		dayNamesShort: ['??','??','??','??','??','??','??'],
		dayNamesMin: ['?','?','?','?','?','?','?'],
		weekHeader: '?',
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '?'};
	$.datepicker.setDefaults($.datepicker.regional['zh-CN']);
});
/* Chinese initialisation for the jQuery UI date picker plugin. */
/* Written by SCCY (samuelcychan@gmail.com). */
jQuery(function($){
	$.datepicker.regional['zh-HK'] = {
		closeText: '??',
		prevText: '&#x3c;??',
		nextText: '??&#x3e;',
		currentText: '??',
		monthNames: ['??','??','??','??','??','??',
		'??','??','??','??','???','???'],
		monthNamesShort: ['?','?','?','?','?','?',
		'?','?','?','?','??','??'],
		dayNames: ['???','???','???','???','???','???','???'],
		dayNamesShort: ['??','??','??','??','??','??','??'],
		dayNamesMin: ['?','?','?','?','?','?','?'],
		weekHeader: '?',
		dateFormat: 'dd-mm-yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '?'};
	$.datepicker.setDefaults($.datepicker.regional['zh-HK']);
});
?/* Chinese initialisation for the jQuery UI date picker plugin. */
/* Written by Ressol (ressol@gmail.com). */
jQuery(function($){
	$.datepicker.regional['zh-TW'] = {
		closeText: '??',
		prevText: '&#x3c;??',
		nextText: '??&#x3e;',
		currentText: '??',
		monthNames: ['??','??','??','??','??','??',
		'??','??','??','??','???','???'],
		monthNamesShort: ['?','?','?','?','?','?',
		'?','?','?','?','??','??'],
		dayNames: ['???','???','???','???','???','???','???'],
		dayNamesShort: ['??','??','??','??','??','??','??'],
		dayNamesMin: ['?','?','?','?','?','?','?'],
		weekHeader: '?',
		dateFormat: 'yy/mm/dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '?'};
	$.datepicker.setDefaults($.datepicker.regional['zh-TW']);
});
