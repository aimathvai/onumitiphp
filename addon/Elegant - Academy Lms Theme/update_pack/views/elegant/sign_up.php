<?php if(get_frontend_settings('recaptcha_status')): ?>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<?php
  $banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
  $signup_banner = $banners['sign_up_banner'];
 ?>
<aside>
	<figure>
		<a href="<?php echo site_url('home'); ?>"><img src="<?php echo base_url().'uploads/system/'.get_frontend_settings('light_logo'); ?>" height="42" data-retina="true" alt=""></a>
	</figure>
	<form action="<?php echo site_url('login/register'); ?>" method="post" autocomplete="off" class="mb-4">
		<div class="form-group">

			<span class="input">
				<input class="input_field" type="text" name="first_name" required>
				<label class="input_label">
					<span class="input__label-content"><?php echo site_phrase('first_name'); ?></span>
				</label>
			</span>

			<span class="input">
				<input class="input_field" type="text" name="last_name" required>
				<label class="input_label">
					<span class="input__label-content"><?php echo site_phrase('last_name'); ?></span>
				</label>
			</span>

			<span class="input">
				<input class="input_field" type="email" name="email" required>
				<label class="input_label">
					<span class="input__label-content"><?php echo site_phrase('email'); ?></span>
				</label>
			</span>

			<span class="input">
				<input class="input_field" type="password" id="password1" name="password" required>
				<label class="input_label">
					<span class="input__label-content"><?php echo site_phrase('password'); ?></span>
				</label>
			</span>

			<div id="pass-info" class="clearfix"></div>
		</div>

		<?php if(get_frontend_settings('recaptcha_status')): ?>
	      <div class="form-group">
	        <span class="input">
	          <div class="g-recaptcha" data-sitekey="<?php echo get_frontend_settings('recaptcha_sitekey'); ?>"></div>
	        </span>
	      </div>
	    <?php endif; ?>

    
		<button type="submit" class="btn_1 rounded full-width"><?php echo site_phrase('register'); ?></button>
		
	</form>

	<?php include 'facebook_login.php'; ?>

	<div class="text-center add_top_10"><?php echo site_phrase('already_have_an_account'); ?>? <strong><a href="<?php echo site_url('home/login'); ?>"><?php echo site_phrase('sign_in'); ?></a></strong></div>
	<div class="text-center add_top_10"> <strong><a href="<?php echo site_url('home'); ?>"><?php echo site_phrase('back_to_home'); ?></a></strong> </div>

	<div class="copy">© <?php echo get_settings('system_name'); ?></div>
</aside>

<style media="screen">
#login_bg {
  background: url(<?php echo base_url($signup_banner); ?>) center center no-repeat fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  min-height: 100vh;
  width: 100%;
}
</style>
