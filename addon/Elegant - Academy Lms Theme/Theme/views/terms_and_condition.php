<?php
$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
$terms_and_conditions_banner = $banners['terms_and_conditions_banner'];
?>
<section id="hero_in" class="general">
	<div class="banner-img" style="background: url(<?php echo base_url($terms_and_conditions_banner); ?>) center center no-repeat;"></div>
	<div class="wrapper">
		<div class="container">
			<h1 class="fadeInUp"><span></span><?php echo site_phrase('terms_and_condition'); ?></h1>
		</div>
	</div>
</section>
<!--/hero_in-->

<div class="container margin_120_95">
	<?php echo get_frontend_settings('terms_and_condition'); ?>
</div>
