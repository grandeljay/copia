<?php
  /* --------------------------------------------------------------
   $Id: colorbox.js.php 12834 2020-07-25 09:33:54Z Tomcraft $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2019 [www.modified-shop.org]
   --------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------*/
?>
<script>
  $(document).ready(function(){
    $(".cbimages").colorbox({rel:'cbimages', scalePhotos:true, maxWidth: "90%", maxHeight: "90%", fixed: true});
    $(".iframe").colorbox({iframe:true, width:"780", height:"560", maxWidth: "90%", maxHeight: "90%", fixed: true});
    $("#print_order_layer").on('submit', function(event) {
      $.colorbox({iframe:true, width:"780", height:"560", maxWidth: "90%", maxHeight: "90%", href:$(this).attr("action") + '&' + $(this).serialize()});
      return false;
    });
  });

  $(document).bind('cbox_complete', function(){
    if($('#cboxTitle').height() > 20){
      $("#cboxTitle").hide();
      $("<div>"+$("#cboxTitle").html()+"</div>").css({color: $("#cboxTitle").css('color')}).insertAfter("#cboxPhoto");
      //$.fn.colorbox.resize(); // Tomcraft - 2016-06-05 - Fix Colorbox resizing
    }
  });
  
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