<?php
$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
$about_us_banner = $banners['about_us_banner'];
?>
<section id="hero_in" class="general">
	<div class="banner-img" style="background: url(<?php echo base_url($about_us_banner); ?>) center center no-repeat;"></div>
	<div class="wrapper">
		<div class="container">
			<h1 class="fadeInUp"><span></span><?php echo site_phrase('about').' '.get_settings('system_name'); ?></h1>
		</div>
	</div>
</section>
<!--/hero_in-->
<div class="container margin_120_95">
	<?php echo get_frontend_settings('about_us'); ?>
</div>
