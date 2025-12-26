<?php if(get_frontend_settings('recaptcha_status')): ?>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<?php
$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
$login_banner = $banners['login_banner'];
?>
<aside>
  <figure>
    <a href="<?php echo site_url('home'); ?>"><img src="<?php echo base_url().'uploads/system/'.get_frontend_settings('light_logo'); ?>" height="42" data-retina="true" alt=""></a>
  </figure>
  <form action="<?php echo site_url('login/validate_login/user'); ?>" method="post" class="mb-4">
    <div class="form-group">
      <span class="input">
        <input class="input_field" type="email" autocomplete="off" name="email" required>
        <label class="input_label">
          <span class="input__label-content"><?php echo site_phrase('your_email'); ?></span>
        </label>
      </span>

      <span class="input">
        <input class="input_field" type="password" autocomplete="new-password" name="password" required>
        <label class="input_label">
          <span class="input__label-content"><?php echo site_phrase('your_password'); ?></span>
        </label>
      </span>
      <small><a href="<?php echo site_url('home/forgot_password'); ?>"><?php echo site_phrase('forgot_password'); ?>?</a></small>
    </div>

    <?php if(get_frontend_settings('recaptcha_status')): ?>
      <div class="form-group">
        <span class="input">
          <div class="g-recaptcha" data-sitekey="<?php echo get_frontend_settings('recaptcha_sitekey'); ?>"></div>
        </span>
      </div>
    <?php endif; ?>
    
    <button type="submit" class="btn_1 rounded full-width"><?php echo site_phrase('login'); ?></button>
    
  </form>

  <?php include 'facebook_login.php'; ?>

  <div class="text-center add_top_10 mt-3"><?php echo site_phrase('new_to').' <strong>'.get_settings('system_name').'</strong>'; ?>? <strong><a href="<?php echo site_url('sign_up'); ?>"><?php echo site_phrase('sign_up'); ?>!</a></strong></div>
    <div class="text-center add_top_10"> <strong><a href="<?php echo site_url('home'); ?>"><?php echo site_phrase('back_to_home'); ?></a></strong> </div>
  <div class="copy">© <?php echo get_settings('system_name'); ?></div>
</aside>

<style media="screen">
#login_bg {
  background: url(<?php echo base_url($login_banner); ?>) center center no-repeat fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  min-height: 100vh;
  width: 100%;
}
</style>
