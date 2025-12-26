<script src="<?php echo base_url('assets/frontend/elegant/js/jquery-2.2.4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/frontend/elegant/js/common_scripts.js'); ?>"></script>
<script src="<?php echo base_url('assets/frontend/elegant/js/main.js'); ?>"></script>
<!-- MODERNIZR SLIDER -->
<script src="<?php echo base_url('assets/frontend/elegant/js/modernizr_slider.js'); ?>"></script>
<!-- FlexSlider -->
<script defer src="<?php echo base_url('assets/frontend/elegant/js/jquery.flexslider.js'); ?>"></script>
<script>
  $(window).load(function() {
    'use strict';
    $('#carousel_slider').flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      itemWidth: 280,
      itemMargin: 25,
      asNavFor: '#slider'
    });
    $('#carousel_slider ul.slides li').on('mouseover', function() {
      $(this).trigger('click');
    });
    $('#slider').flexslider({
      animation: "fade",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      sync: "#carousel_slider",
      start: function(slider) {
        $('body').removeClass('loading');
      }
    });
  });
</script>

<!-- TOASTR JS -->
<script src="<?php echo base_url().'assets/global/toastr/toastr.min.js'; ?>"></script>
<script src="<?php echo base_url('assets/frontend/elegant/js/validate.js'); ?>"></script>
<script src="<?php echo base_url('assets/frontend/elegant/js/jspdf.debug.js'); ?>"></script>
<script src="<?php echo base_url() . 'assets/frontend/elegant/js/jQuery.tagify.js'; ?>"></script>
<script src="<?php echo base_url('assets/frontend/elegant/js/custom.js'); ?>"></script>

<script type="text/javascript">
    if($('.tagify').height()){
      $('.tagify').tagify();
    }
</script>