
<?php
$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
$login_banner = $banners['login_banner'];
?>
<aside>
  <figure>
    <a href="<?php echo site_url('home'); ?>"><img src="<?php echo base_url().'uploads/system/'.get_frontend_settings('light_logo'); ?>" height="42" data-retina="true" alt=""></a>
  </figure>
  <form action="<?php echo site_url('login/change_password/'.$verification_code); ?>" method="post" class="mb-4">
    <div class="form-group">
      <span class="input">
        <input class="input_field" type="password" autocomplete="off" name="new_password" required>
        <label class="input_label">
          <span class="input__label-content"><?php echo site_phrase('new_password'); ?></span>
        </label>
      </span>

      <span class="input">
        <input class="input_field" type="password" autocomplete="new-password" name="confirm_password" required>
        <label class="input_label">
          <span class="input__label-content"><?php echo site_phrase('confirm_password'); ?></span>
        </label>
      </span>
    </div>
    
    <button type="submit" class="btn_1 rounded full-width"><?php echo site_phrase('change_password'); ?></button>
    
  </form>


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
