<?php
	$latest_courses = $this->crud_model->get_latest_10_course();
	$limit = 4;
 ?>
<section class="slider">
	<div id="slider" class="flexslider">
		<ul class="slides">
			<?php foreach ($latest_courses as $key => $latest_course): ?>
				<?php if ($limit > $key): ?>
					<li>
						<img src="<?php echo $this->crud_model->get_course_thumbnail_url($latest_course['id'], 'course_slider_banner'); ?>" alt="">
						<div class="meta">
							<h3><?php echo $latest_course['title']; ?></h3>
							<div class="info">
								<p><strong><?php echo $this->crud_model->get_lessons('course', $latest_course['id'])->num_rows(); ?></strong> <?php echo site_phrase('lessons'); ?></p>
							</div>
							<a href="<?php echo site_url('home/course/'.slugify($latest_course['title']).'/'.$latest_course['id']); ?>" class="btn_1"><?php echo site_phrase('view_course'); ?></a>
						</div>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<div id="icon_drag_mobile"></div>
	</div>
	<div id="carousel_slider_wp" class="pt-2">
		<div id="carousel_slider" class="flexslider">
			<ul class="slides">
				<?php foreach ($latest_courses as $key => $latest_course): ?>
					<?php if ($limit > $key): ?>
						<li>
							<img src="<?php echo $this->crud_model->get_course_thumbnail_url($latest_course['id'], 'course_slider_thumbnail'); ?>" alt="">
							<div class="caption">
								<h3><?php echo ellipsis($latest_course['title']); ?>
									<span>
										<?php
			              $sub_category_details = $this->crud_model->get_category_details_by_id($latest_course['sub_category_id'])->row_array();
			              echo $sub_category_details['name'];
			              ?>
									</span>
								</h3>
								<?php if ($latest_course['is_free_course'] == 1): ?>
		              <small><?php echo site_phrase('free'); ?></small>
		            <?php else: ?>
		              <?php if ($latest_course['discount_flag'] == 1): ?>
		                <small><?php echo currency($latest_course['discounted_price']); ?><em><?php echo currency($latest_course['price']); ?></em></small>
		              <?php else: ?>
		                <small><?php echo currency($latest_course['price']); ?></small>
		              <?php endif; ?>
		            <?php endif; ?>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
