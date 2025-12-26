<?php
$my_courses = $this->user_model->my_courses()->result_array();
$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
$my_courses_banner = $banners['my_courses_banner'];
?>
<section id="hero_in" class="courses">
	<div class="banner-img" style="background: url(<?php echo base_url($my_courses_banner); ?>) center center no-repeat;"></div>
	<div class="wrapper">
		<div class="container">
			<h1 class="fadeInUp"><span></span><?php echo site_phrase('my_courses'); ?></h1>
		</div>
	</div>
</section>
<!--/hero_in-->

<div class="container margin_60_35">
	<div class="row justify-content-center">
		<?php foreach ($my_courses as $key => $my_course):
			$course_details = $this->crud_model->get_course_by_id($my_course['course_id'])->row_array();
			$instructor_details = $this->user_model->get_all_user($course_details['user_id'])->row_array(); ?>
			<!-- Single course starts -->
			<div class="col-xl-4 col-lg-6 col-md-6">
				<div class="box_grid wow">
					<figure class="block-reveal">
						<div class="block-horizzontal"></div>
						<a href="<?php echo site_url('home/lesson/'.slugify($course_details['title']).'/'.$my_course['course_id']); ?>"><img src="<?php echo $this->crud_model->get_course_thumbnail_url($my_course['course_id']); ?>" class="img-fluid" alt=""></a>
						<?php if ($course_details['is_free_course'] == 1): ?>
							<div class="price"><?php echo site_phrase('free'); ?></div>
						<?php else: ?>
							<?php if ($course_details['discount_flag'] == 1): ?>
								<div class="price"><?php echo currency($course_details['discounted_price']); ?></div>
							<?php else: ?>
								<div class="price"><?php echo currency($course_details['price']); ?></div>
							<?php endif; ?>
						<?php endif; ?>
						<div class="preview"><span><?php echo site_phrase('preview_course'); ?></span></div>
					</figure>
					<div class="wrapper">
						<small>
							<div class="" id = "course_info_view_<?php echo $course_details['id']; ?>">
								<?php
								$sub_category_details = $this->crud_model->get_category_details_by_id($course_details['sub_category_id'])->row_array();
								echo $sub_category_details['name'];
								?>
							</small>
							<h3><?php echo ellipsis($course_details['title'], 100); ?></h3>
							<p class="mb-2"><?php echo ellipsis($course_details['short_description'], 100); ?>.</p>
							<div class="progress" style="height: 5px;">
								<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?php echo course_progress($my_course['course_id']); ?>%" aria-valuenow="<?php echo course_progress($my_course['course_id']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<small><?php echo ceil(course_progress($my_course['course_id'])); ?>% <?php echo site_phrase('completed'); ?></small>
						</div>
						<div class="hidden" style="" id = "course_rating_view_<?php echo $course_details['id']; ?>">
							<h3><?php echo ellipsis($course_details['title'], 100); ?></h3>
							<?php
								$user_specific_rating = $this->crud_model->get_user_specific_rating('course', $course_details['id']);
							?>
							<form class="" action="" method="post">
								<div class="form-group select">
									<div class="styled-select">
										<select class="required" name="star_rating" id="star_rating_of_course_<?php echo $course_details['id']; ?>">
											<option value="1" <?php if ($user_specific_rating['rating'] == 1): ?>selected=""<?php endif; ?>>1 <?php echo site_phrase('out_of'); ?> 5</option>
											<option value="2" <?php if ($user_specific_rating['rating'] == 2): ?>selected=""<?php endif; ?>>2 <?php echo site_phrase('out_of'); ?> 5</option>
											<option value="3" <?php if ($user_specific_rating['rating'] == 3): ?>selected=""<?php endif; ?>>3 <?php echo site_phrase('out_of'); ?> 5</option>
											<option value="4" <?php if ($user_specific_rating['rating'] == 4): ?>selected=""<?php endif; ?>>4 <?php echo site_phrase('out_of'); ?> 5</option>
											<option value="5" <?php if ($user_specific_rating['rating'] == 5): ?>selected=""<?php endif; ?>>5 <?php echo site_phrase('out_of'); ?> 5</option>
										</select>
									</div>
								</div>
								<div class="form-group add_top_30">
									<textarea name="review" id ="review_of_a_course_<?php echo $course_details['id']; ?>" class="form-control" style="height:120px;" placeholder="<?php echo site_phrase('write_your_review_here'); ?>"><?php echo $user_specific_rating['review']; ?></textarea>
								</div>
								<button type="button" class="btn_1 btn_small full-width" onclick="publishRating('<?php echo $course_details['id']; ?>')" name="button"><?php echo site_phrase('publish'); ?></button>
							</form>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="rating">
									<?php
									$total_rating =  $this->crud_model->get_ratings('course', $course_details['id'], true)->row()->rating;
									$number_of_ratings = $this->crud_model->get_ratings('course', $course_details['id'])->num_rows();
									if ($number_of_ratings > 0) {
										$average_ceil_rating = ceil($total_rating / $number_of_ratings);
									}else {
										$average_ceil_rating = 0;
									}
									for($i = 1; $i < 6; $i++):?>
									<?php if ($i <= $average_ceil_rating): ?>
										<i class="icon_star voted"></i>
									<?php else: ?>
										<i class="icon_star"></i>
									<?php endif; ?>
								<?php endfor; ?>
								<small>(<?php echo $number_of_ratings; ?>)</small>
							</div>
						</div>
						<div class="col-6 text-right">
							<a href="javascript::" id = "edit_rating_btn_<?php echo $course_details['id']; ?>" onclick="toggleRatingView('<?php echo $course_details['id']; ?>')"><?php echo site_phrase('edit_rating'); ?></a>
							<a href="javascript::" class="hidden" id = "cancel_rating_btn_<?php echo $course_details['id']; ?>" onclick="toggleRatingView('<?php echo $course_details['id']; ?>')"><?php echo site_phrase('cancel_rating'); ?></a>
						</div>
					</div>
				</div>
				<div class="row">
		          <?php include 'live_class_scadule.php'; ?>
		        </div>
		        <div class="row">
		          <?php include 'jitsi_live_class_scadule.php'; ?>
		        </div>
				<ul>
					<li><a href="<?php echo site_url('home/course/'.slugify($course_details['title']).'/'.$my_course['course_id']); ?>"><?php echo site_phrase('course_detail'); ?></a></li>
					<li><a href="<?php echo site_url('home/lesson/'.slugify($course_details['title']).'/'.$my_course['course_id']); ?>"><?php echo site_phrase('start_lesson'); ?></a></li>
				</ul>
			</div>
		</div>
		<!-- Single course ends -->
	<?php endforeach; ?>
</div>
<!-- /row -->
</div>
<!-- /container -->
<!-- /bg_color_1 -->
