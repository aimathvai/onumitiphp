<main>
	<div id="error_page" style="background: #392779 url(<?php echo base_url('assets/frontend/elegant/images/pattern.svg'); ?>) fixed">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-xl-7 col-lg-9">
					<h2>404 <i class="icon_error-triangle_alt"></i></h2>
					<p><?php echo site_phrase('oh_snap'); ?>! <?php echo site_phrase('this_is_not_the_web_page_you_are_looking_for'); ?>.</p>
					<form action="<?php echo site_url('home/search'); ?>" method="get">
						<div class="search_bar_error">
							<input type="text" name="query" class="form-control" placeholder="<?php echo site_phrase('which_course_are_you_looking_for'); ?>?">
							<input type="submit" value="<?php echo site_phrase('search'); ?>">
						</div>
					</form>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /error_page -->
</main>
