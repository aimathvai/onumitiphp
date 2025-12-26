<?php
$instructor_details = $this->user_model->get_all_user($instructor_id)->row_array();
$social_links  = json_decode($instructor_details['social_links'], true);
$course_ids = $this->crud_model->get_instructor_wise_courses($instructor_id, 'simple_array');
$courses = $this->crud_model->get_instructor_wise_courses($instructor_id)->result_array();
$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
$instructor_banner = $banners['instructor_banner'];

?>
<section id="hero_in" class="general">
	<div class="banner-img" style="background: url(<?php echo base_url($instructor_banner); ?>) center center no-repeat;"></div>
	<div class="wrapper">
		<div class="container">
			<h1 class="fadeInUp"><span></span><?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?></h1>
			<h5 class="fadeInUp"><?php echo $instructor_details['title']; ?></h5>
		</div>
	</div>
</section>
<!--/hero_in-->
<div class="container margin_60_35">
	<div class="row">
		<aside class="col-lg-3" id="sidebar">
			<div class="profile">
				<figure><img src="<?php echo $this->user_model->get_user_image_url($instructor_details['id']);?>" alt="Teacher" class="rounded-circle instructor-image"></figure>
				<ul class="social_teacher">
					<li><a href="<?php echo $social_links['facebook']; ?>" target="_blank"><i class="icon-facebook"></i></a></li>
					<li><a href="<?php echo $social_links['twitter']; ?>" target="_blank"><i class="icon-twitter"></i></a></li>
					<li><a href="<?php echo $social_links['linkedin']; ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
					<li><a href="mailto:<?php echo $instructor_details['email']; ?>" target="_blank"><i class="icon-email"></i></a></li>
				</ul>
				<ul>
					<li>
						<?php echo site_phrase('name'); ?> <span class="float-right"><?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?></span>
					</li>
					<li>
						<?php echo site_phrase('students'); ?>
						<span class="float-right">
							<?php
							$this->db->select('user_id');
							$this->db->distinct();
							$this->db->where_in('course_id', $course_ids);
							echo $this->db->get('enrol')->num_rows();?>
						</span>
					</li>
					<li>
						<?php echo site_phrase('courses'); ?>
						<span class="float-right"><?php echo sizeof($course_ids); ?></span>
					</li>
					<li>
						<?php echo site_phrase('reviews'); ?>
						<span class="float-right"><?php echo $this->crud_model->get_instructor_wise_course_ratings($instructor_id, 'course')->num_rows(); ?></span>
					</li>
				</ul>
			</div>
		</aside>
		<!--/aside -->

		<div class="col-lg-9">
			<div class="box_teacher">
				<div class="indent_title_in">
					<i class="pe-7s-user"></i>
					<h3><?php echo site_phrase('biography'); ?></h3>
				</div>
				<div class="wrapper_indent">
					<p>
						<?php echo $instructor_details['biography']; ?>
					</p>
					<!-- End row-->
				</div>

				<div class="indent_title_in">
					<i class="fab fa-sellcast"></i>
					<h3><?php echo site_phrase('instructor_skills'); ?></h3>
				</div>
				<div class="wrapper_indent">
					<?php $skills = explode(',', $instructor_details['skills']); ?>
	                <?php foreach($skills as $skill): ?>
	                  <span class="badge text-12px mb-1" style="padding: 8px 15px !important; background-color: #ffde7a;"><?php echo $skill; ?></span>
	                <?php endforeach; ?>
					<!-- End row-->
				</div>
				<!--wrapper_indent -->
				<hr class="styled_2">
				<div class="indent_title_in">
					<i class="pe-7s-display1"></i>
					<h3><?php echo site_phrase('instructor_courses'); ?></h3>
				</div>
				<div class="wrapper_indent">
					<table class="table table-responsive table-striped add_bottom_30 w-100">
						<thead>
							<tr>
								<th><?php echo site_phrase('category'); ?></th>
								<th><?php echo site_phrase('course_name'); ?></th>
								<th width = '120px;'><?php echo site_phrase('rating'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($courses as $key => $course): ?>
								<tr>
									<td>
										<?php
										$sub_category_details = $this->crud_model->get_category_details_by_id($course['sub_category_id'])->row_array();
										echo $sub_category_details['name'];
										?>
									</td>
									<td><a href="<?php echo site_url('home/course/'.slugify($course['title']).'/'.$course['id']); ?>"><?php echo $course['title']; ?></a></td>
									<td class="rating">
										<?php
										$total_rating =  $this->crud_model->get_ratings('course', $course['id'], true)->row()->rating;
										$number_of_ratings = $this->crud_model->get_ratings('course', $course['id'])->num_rows();
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
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<!--wrapper_indent -->
		</div>
	</div>
	<!-- /col -->
</div>
<!-- /row -->
</div>
<!-- /container -->		                