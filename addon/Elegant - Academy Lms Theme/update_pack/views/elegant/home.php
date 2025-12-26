<!-- Slider starts -->
<?php include 'slider.php'; ?>
<!-- Slider ends -->

<!-- The black banner content starts -->
<div class="features clearfix">
	<div class="container">
		<ul>
			<li><i class="pe-7s-study"></i>
				<h4>
					<?php
					$status_wise_courses = $this->crud_model->get_status_wise_courses();
					$number_of_courses = $status_wise_courses['active']->num_rows();
					echo $number_of_courses.' '.site_phrase('online_courses'); ?>
				</h4><span><?php echo site_phrase('explore_your_knowledge'); ?></span>
			</li>
			<li><i class="pe-7s-cup"></i>
				<h4><?php echo site_phrase('expert_instruction'); ?></h4>
				<span><?php echo site_phrase('find_the_right_course_for_you'); ?></span>
			</li>
			<li><i class="pe-7s-target"></i>
				<h4><?php echo site_phrase('lifetime_access'); ?></h4>
				<span><?php echo site_phrase('learn_on_your_schedule'); ?></span>
			</li>
		</ul>
	</div>
</div>
<!-- The black banner content ends -->

<!-- Top Course Portion Starts -->
<?php include 'top_courses.php' ?>
<!-- Top Course Portion Ends -->

<!-- Categories start -->
<div class="container margin_30_95">
	<div class="main_title_2">
		<span><em></em></span>
		<h2><?php echo site_phrase('categories'); ?></h2>
		<p><?php echo site_phrase('get_category_wise_different_courses'); ?></p>
	</div>
	<div class="row justify-content-center">
		<?php foreach ($this->crud_model->get_categories()->result_array() as $category):
			if($category['parent'] > 0)
			continue; ?>
			<!-- /grid_item -->
			<div class="col-lg-4 col-md-6 wow" data-wow-offset="150">
				<a href="<?php echo site_url('home/courses?category='.$category['slug']); ?>" class="grid_item">
					<figure class="block-reveal">
						<div class="block-horizzontal"></div>
						<img src="<?php echo base_url('uploads/thumbnails/category_thumbnails/'.$category['thumbnail']); ?>" class="img-fluid" alt="">
						<div class="info">
							<small><i class="ti-layers"></i>
								<?php echo $this->crud_model->get_category_wise_courses($category['id'])->num_rows().' '.site_phrase('courses'); ?>
							</small>
							<h3><?php echo $category['name']; ?></h3>
						</div>
					</figure>
				</a>
			</div>
			<!-- /grid_item -->
		<?php endforeach; ?>
	</div>
</div>
<!-- Categories end -->


<div class="container-fluid mt-5">
	<div class="main_title_2">
		<span><em></em></span>
		<h2><?php echo site_phrase('top_instructors'); ?></h2>
		<p><?php echo site_phrase('top_10_instructors_on').' '.get_settings('system_title'); ?>.</p>
	</div>
	<div class="owl-carousel-instructor owl-carousel owl-theme">
		<?php $top_instructor_ids = $this->crud_model->get_top_instructor(10); ?>
		<?php foreach($top_instructor_ids as $top_instructor_id): ?>
		    <?php $top_instructor = $this->user_model->get_all_user($top_instructor_id['creator'])->row_array(); ?>
		    <div class="box_list">
		        <div class="top-instructor-img">
		            <a href="<?php echo site_url('home/instructor_page/'.$top_instructor['id']); ?>">
		                <img src="<?php echo $this->user_model->get_user_image_url($top_instructor['id']); ?>" width="100px">
		            </a>
		        </div>
		        <div class="top-instructor-details text-center mt-2 p-3">
		            <a class="text-decoration-none text-dark" href="<?php echo site_url('home/instructor_page/'.$top_instructor['id']); ?>">
		                <h4 class="mb-1 fw-700"><?php echo $top_instructor['first_name'].' '.$top_instructor['last_name']; ?></h4>
		                <p class="mb-2"><span class="fw-500 text-muted text-14px"><?php echo ellipsis($top_instructor['title'], 60); ?></span></p>
		                <div class="mb-1"><?php echo get_phrase('experienced_on'); ?> -</div>
		                <?php $skills = explode(',', $top_instructor['skills']); ?>
		                <?php foreach($skills as $skill): ?>
		                  <span class="badge text-12px mb-1" style="padding: 8px 15px !important; background-color: #ffde7a;"><?php echo $skill; ?></span>
		                <?php endforeach; ?>
		            </a>
		        </div>
		    </div>
		<?php endforeach; ?>
	</div>
</div>

<?php if(get_frontend_settings('blog_visibility_on_the_home_page')): ?>
    <div class="container-fluid mt-5 mb-5">
		<div class="main_title_2">
			<span><em></em></span>
			<h2><?php echo site_phrase('latest_blogs'); ?></h2>
			<p><?php echo site_phrase('stay_informed_about_our_mission_start_reading_our_blog_today'); ?>.</p>
		</div>
		<div class="row">
            <?php $latest_blogs = $this->crud_model->get_latest_blogs(4); ?>
            <?php foreach($latest_blogs->result_array() as $latest_blog): ?>
                <?php $user_details = $this->user_model->get_all_user($latest_blog['user_id'])->row_array(); ?>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="box_list card radius-10" style="margin-bottom: 30px;">
                        <?php $blog_thumbnail = 'uploads/blog/thumbnail/'.$latest_blog['thumbnail']; ?>
                        <?php if(file_exists($blog_thumbnail) && is_file($blog_thumbnail)): ?>
                            <img src="<?php echo base_url($blog_thumbnail); ?>" class="card-img-top radius-top-10" alt="<?php echo $latest_blog['title']; ?>">
                        <?php else: ?>
                            <img src="<?php echo base_url('uploads/blog/thumbnail/placeholder.png'); ?>" class="card-img-top radius-top-10" alt="<?php echo $latest_blog['title']; ?>">
                        <?php endif; ?>
                        <div class="card-body pt-4">
                            <p class="card-text">
                                <small class="text-muted"><?php echo site_phrase('created_by'); ?> - <a href="<?php echo site_url('home/instructor_page/'.$latest_blog['user_id']); ?>"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></a></small>
                            </p>
                            <h5 class="card-title"><a href="<?php echo site_url('blog/details/'.slugify($latest_blog['title']).'/'.$latest_blog['blog_id']); ?>"><?php echo $latest_blog['title']; ?></a></h5>
                            <p class="card-text ellipsis-line-3">
                                <?php echo strip_tags(htmlspecialchars_decode($latest_blog['description'])); ?>
                            </p>
                            
                            <a class="fw-600" href="<?php echo site_url('blog/details/'.slugify($latest_blog['title']).'/'.$latest_blog['blog_id']); ?>"><?php echo site_phrase('more_details'); ?></a>
                            
                            <p class="card-text mt-2 mb-0">
                                <small class="text-muted text-12px"><?php echo site_phrase('published'); ?> - <?php echo get_past_time($latest_blog['added_date']); ?></small>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="col-12">
                <a class="float-right btn btn-outline-secondary px-3 mt-1 fw-600" href="<?php echo site_url('blogs'); ?>"><?php echo site_phrase('view_all'); ?></a>
            </div>
        </div>
    </div>
<?php endif; ?>
