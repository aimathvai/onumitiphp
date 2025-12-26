<footer class="d-print-none">
  <div class="container margin_120_95">
    <div class="row">
      <div class="col-lg-5 col-md-12 p-r-5">
        <p><img src="<?php echo base_url().'uploads/system/'.get_frontend_settings('light_logo'); ?>" height="42" data-retina="true" alt=""></p>
        <p><?php echo get_settings('slogan').'<br/>'.get_settings('address'); ?></p>
        <!-- <div class="follow_us">
          <ul>
            <li>Follow us</li>
            <li><a href="#0"><i class="ti-facebook"></i></a></li>
            <li><a href="#0"><i class="ti-twitter-alt"></i></a></li>
            <li><a href="#0"><i class="ti-google"></i></a></li>
            <li><a href="#0"><i class="ti-pinterest"></i></a></li>
            <li><a href="#0"><i class="ti-instagram"></i></a></li>
          </ul>
        </div> -->
      </div>
      <div class="col-lg-3 col-md-6 ml-lg-auto">
        <h5><?php echo site_phrase('useful_links'); ?></h5>
        <ul class="links">
          <li><a href="<?php echo site_url('blog'); ?>"><?php echo site_phrase('blog'); ?></a></li>
          <li><a href="<?php echo site_url('home/courses'); ?>"><?php echo site_phrase('courses'); ?></a></li>
          <li><a href="<?php echo site_url('home/login'); ?>"><?php echo site_phrase('login'); ?></a></li>
          <li><a href="<?php echo site_url('sign_up'); ?>"><?php echo site_phrase('register'); ?></a></li>
          <?php $custom_page_menus = $this->crud_model->get_custom_pages('', 'footer'); ?>
          <?php foreach($custom_page_menus->result_array() as $custom_page_menu): ?>
            <li><a href="<?php echo site_url('page/'.$custom_page_menu['page_url']); ?>"><?php echo $custom_page_menu['button_title']; ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5><?php echo site_phrase('contact_with_us'); ?></h5>
        <ul class="contacts">
          <li><a href="tel://<?php echo get_settings('phone'); ?>"><i class="ti-mobile"></i> <?php echo get_settings('phone'); ?></a></li>
          <li><a href="mailto:<?php echo get_settings('system_email'); ?>"><i class="ti-email"></i> <?php echo get_settings('system_email'); ?></a></li>
        </ul>
        <!-- <div id="newsletter">
          <h6>Newsletter</h6>
          <div id="message-newsletter"></div>
          <form method="post" action="assets/newsletter.php" name="newsletter_form" id="newsletter_form">
            <div class="form-group">
              <input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Your email">
              <input type="submit" value="Submit" id="submit-newsletter">
            </div>
          </form>
        </div> -->
      </div>
    </div>
    <!--/row-->
    <hr>
    <div class="row">
      <div class="col-md-6 mt-2">
        <ul id="additional_links">
          <li><a href="<?php echo site_url('home/terms_and_condition'); ?>"><?php echo site_phrase('terms_&_conditions'); ?></a></li>
          <li><a href="<?php echo site_url('home/privacy_policy'); ?>"><?php echo site_phrase('privacy_policy'); ?></a></li>
          <li><a href="<?php echo site_url('home/refund_policy'); ?>"><?php echo site_phrase('refund_policy'); ?></a></li>
          <li><a href="<?php echo site_url('home/about_us'); ?>"><?php echo site_phrase('about_us'); ?></a></li>
        </ul>
      </div>
      <div class="col-md-3 text-left mt-2">
        <div id="copy text-left">© <a href="<?php echo get_settings('footer_link'); ?>" style="color: unset;"><?php echo get_settings('system_name').' | '.site_phrase('version').' : '.get_settings('version'); ?></a> </div>
      </div>
      <div class="col-md-3 mt-2">
        <select class="language_selector" onchange="switch_language(this.value)">
          <?php
           $languages = $this->crud_model->get_all_languages();
           foreach ($languages as $language): ?>
              <?php if (trim($language) != ""): ?>
                  <option value="<?php echo strtolower($language); ?>" <?php if ($this->session->userdata('language') == $language): ?>selected<?php endif; ?>><?php echo ucwords($language);?></option>
              <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
</footer>

<script type="text/javascript">
    function switch_language(language) {
        $.ajax({
            url: '<?php echo site_url('home/site_language'); ?>',
            type: 'post',
            data: {language : language},
            success: function(response) {
                setTimeout(function(){ location.reload(); }, 500);
            }
        });
    }
</script>