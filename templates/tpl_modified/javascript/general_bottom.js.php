<?php
/*-----------------------------------------------------------
   $Id: general_bottom.js.php 10309 2016-10-04 10:42:01Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
  -----------------------------------------------------------
   based on: (c) 2003 - 2006 XT-Commerce (general.js.php)
  -----------------------------------------------------------
   Released under the GNU General Public License
   -----------------------------------------------------------
*/
// this javascriptfile get includes at the BOTTOM of every template page in shop
// you can add your template specific js scripts here
$script_array = array(
  DIR_TMPL_JS.'jquery.colorbox.min.js',
  DIR_TMPL_JS.'jquery.unveil.min.js',
  DIR_TMPL_JS.'jquery.bxslider.min.js',
  DIR_TMPL_JS.'jquery.easyTabs.min.js',
  DIR_TMPL_JS.'jquery.alerts.min.js',
);
$script_min = DIR_TMPL_JS.'tpl_plugins.min.js';
  
if (COMPRESS_JAVASCRIPT == 'true') {
  require_once(DIR_FS_BOXES_INC.'combine_files.inc.php');
  $script_array = combine_files($script_array,$script_min,false);
}

foreach ($script_array as $script) {
  echo '<script src="'.DIR_WS_BASE.$script.'" type="text/javascript"></script>'.PHP_EOL;
}
?>
<?php require DIR_FS_CATALOG . DIR_TMPL_JS . 'get_states.js.php'; ?>
<script type="text/javascript">
  $(window).on('load',function() {
    $(".unveil").show();
    $(".unveil").unveil(200);
  });
  $(document).ready(function(){
    $(".cbimages").colorbox({rel:'cbimages', scalePhotos:true, maxWidth: "90%", maxHeight: "90%", fixed: true});
    $(".iframe").colorbox({iframe:true, width:"780", height:"560", maxWidth: "90%", maxHeight: "90%", fixed: true});
    $("#print_order_layer").on('submit', function(event) {
      $.colorbox({iframe:true, width:"780", height:"560", maxWidth: "90%", maxHeight: "90%", href:$(this).attr("action") + $(this).serialize()});
      return false;
    });
    $('.bxcarousel_bestseller').bxSlider({
      minSlides: 6,
      maxSlides: 8,
      pager: ($(this).children('li').length > 1), //FIX for only one entry
      slideWidth: 109,
      slideMargin: 18
    });
    $('.bxcarousel_slider').bxSlider({
      adaptiveHeight: false,
      mode: 'fade',
      auto: true,
      speed: 2000,
      pause: 6000
    });
    $(document).bind('cbox_complete', function(){
      if($('#cboxTitle').height() > 20){
        $("#cboxTitle").hide();
        $("<div>"+$("#cboxTitle").html()+"</div>").css({color: $("#cboxTitle").css('color')}).insertAfter("#cboxPhoto");
        //$.fn.colorbox.resize(); // Tomcraft - 2016-06-05 - Fix Colorbox resizing
      }
    });
    <?php if (SEARCH_AC_STATUS == 'true') { ?>
    var option = $('#suggestions');
    $(document).click(function(e){
      var target = $(e.target);
      if(!(target.is(option) || option.find(target).length)){
        ac_closing();
      }
    });
    <?php } ?>
  });
</script>
<script type="text/javascript">
  <?php if (SEARCH_AC_STATUS == 'true') { ?>
  var ac_pageSize = 8;
  var ac_page = 1;
  var ac_result = 0;
  var ac_show_page = '<?php echo AC_SHOW_PAGE; ?>';
  var ac_show_page_of = '<?php echo AC_SHOW_PAGE_OF; ?>';
  
  function ac_showPage(ac_page) {
    ac_result = Math.ceil($("#autocomplete_main").children().length/ac_pageSize);
    $('.autocomplete_content').hide();   
    $('.autocomplete_content').each(function(n) {    
      if (n >= (ac_pageSize * (ac_page - 1)) && n < (ac_pageSize * ac_page)) {
        $(this).show();
      }
    });
    $('#autocomplete_next').css('visibility', 'hidden');
    $('#autocomplete_prev').css('visibility', 'hidden');
    if (ac_page > 1) {
      $('#autocomplete_prev').css('visibility', 'visible');
    }
    if (ac_page < ac_result && ac_result > 1) {
      $('#autocomplete_next').css('visibility', 'visible');
    }
    $('#autocomplete_count').html(ac_show_page+ac_page+ac_show_page_of+ac_result);
  }
  function ac_prevPage() {
    if (ac_page == 1) {
      ac_page = ac_result;
    } else {
      ac_page--;
    }
    if (ac_page < 1) {
      ac_page = 1;
    }
    ac_showPage(ac_page);
  }
  function ac_nextPage() {
    if (ac_page == ac_result) {
      ac_page = 1;
    } else {
      ac_page++;
    }
    ac_showPage(ac_page);
  }
	function ac_lookup(inputString) {
		if(inputString.length == 0) {
			$('#suggestions').hide();
		} else {
			$.post("<?php echo xtc_href_link('api/autocomplete/autocomplete.php', '', $request_type); ?>", {queryString: ""+inputString+""}, function(data) {
				if(data.length > 0) {
					$('#suggestions').slideDown();
					$('#autoSuggestionsList').html(data);
					ac_showPage(1);
					$('#autocomplete_prev').click(ac_prevPage);
          $('#autocomplete_next').click(ac_nextPage);
				}
			});
		}
	}
  <?php } ?>
	<?php if (SEARCH_AC_STATUS == 'true' || (!strstr($PHP_SELF, FILENAME_SHOPPING_CART) && !strstr($PHP_SELF, 'checkout'))) { ?>	
	function ac_closing() {
		setTimeout("$('#suggestions').slideUp();", 100);
		ac_page = 1;
	}
  <?php } ?>
  $.alerts.overlayOpacity = .2;
  $.alerts.overlayColor = '#000';
  function alert(message, title) {
    title = title || 'Information';
    jAlert(message, title);
  }
  <?php if (!strstr($PHP_SELF, FILENAME_SHOPPING_CART) && !strstr($PHP_SELF, 'checkout')) { ?>
    $(function() {
      $('#toggle_cart').click(function() {
        $('.toggle_cart').slideToggle('slow');
        $('.toggle_wishlist').slideUp('slow');
        ac_closing();
        return false;
      });
      $("html").not('.toggle_cart').bind('click',function(e) {
        $('.toggle_cart').slideUp('slow');
      });
      <?php if (DISPLAY_CART == 'false' && isset($_SESSION['new_products_id_in_cart'])) {
        unset($_SESSION['new_products_id_in_cart']); ?>
        $('.toggle_cart').slideToggle('slow');
        timer = setTimeout(function(){$('.toggle_cart').slideUp('slow');}, 3000);
        $('.toggle_cart').mouseover(function() {clearTimeout(timer);});
      <?php } ?>
    });     

    $(function() {
      $('#toggle_wishlist').click(function() {
        $('.toggle_wishlist').slideToggle('slow');
        $('.toggle_cart').slideUp('slow');
        ac_closing();
        return false;
      });
      $("html").not('.toggle_wishlist').bind('click',function(e) {
        $('.toggle_wishlist').slideUp('slow');
      });
      <?php if (DISPLAY_CART == 'false' && isset($_SESSION['new_products_id_in_wishlist'])) {
        unset($_SESSION['new_products_id_in_wishlist']); ?>
        $('.toggle_wishlist').slideToggle('slow');
        timer = setTimeout(function(){$('.toggle_wishlist').slideUp('slow');}, 3000);
        $('.toggle_wishlist').mouseover(function() {clearTimeout(timer);});
      <?php } ?>
    });     
  <?php } else {
    unset($_SESSION['new_products_id_in_cart']);
    unset($_SESSION['new_products_id_in_wishlist']);
  } ?>

  jQuery.extend(jQuery.colorbox.settings, {
          current: "<?php echo TEXT_COLORBOX_CURRENT; ?>",
          previous: "<?php echo TEXT_COLORBOX_PREVIOUS; ?>",
          next: "<?php echo TEXT_COLORBOX_NEXT; ?>",
          close: "<?php echo TEXT_COLORBOX_CLOSE; ?>",
          xhrError: "<?php echo TEXT_COLORBOX_XHRERROR; ?>",
          imgError: "<?php echo TEXT_COLORBOX_IMGERROR; ?>",
          slideshowStart: "<?php echo TEXT_COLORBOX_SLIDESHOWSTART; ?>",
          slideshowStop: "<?php echo TEXT_COLORBOX_SLIDESHOWSTOP; ?>"
  });
</script>
<?php if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO )) { ?>
<script type="text/javascript">
    $.get("<?php echo DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE; ?>"+"/css/jquery.easyTabs.css", function(css) {
      $("head").append("<style type='text/css'>"+css+"<\/style>");
    });
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default' //Types: default, vertical, accordion           
        });
        $('#horizontalAccordion').easyResponsiveTabs({
            type: 'accordion' //Types: default, vertical, accordion           
        });
    });
</script>
<?php } ?>
<?php if (strstr($PHP_SELF, 'checkout')) { ?>
<script type="text/javascript">
    $.get("<?php echo DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE; ?>"+"/css/jquery.easyTabs.css", function(css) {
      $("head").append("<style type='text/css'>"+css+"<\/style>");
    });
    $(document).ready(function () {
        $('#horizontalAccordion').easyResponsiveTabs({
            type: 'accordion', //Types: default, vertical, accordion     
            closed: true,     
            activate: function(event) { // Callback function if tab is switched
               $(".resp-tab-active input[type=radio]").prop('checked', true);
            }
        });
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default' //Types: default, vertical, accordion           
        });
    });
</script>
<?php } ?>

<?php if (strstr($PHP_SELF, FILENAME_CONTENT) && $_GET['coID'] == 8) { ?>
  <!--[if lt IE 10]>
  <script src="<?php echo DIR_WS_BASE.DIR_TMPL_JS; ?>jquery.css3-multi-column.js"></script>
  <![endif]-->
<?php } ?>