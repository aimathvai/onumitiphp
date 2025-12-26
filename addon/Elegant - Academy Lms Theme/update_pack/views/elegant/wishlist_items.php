<?php
$user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
$cart_items = $this->session->userdata('cart_items');
$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
$my_wishlist_banner = $banners['my_wishlist_banner'];
?>
<section id="hero_in" class="courses">
	<div class="banner-img" style="background: url(<?php echo base_url($my_wishlist_banner); ?>) center center no-repeat;"></div>
	<div class="wrapper">
		<div class="container">
			<h1 class="fadeInUp"><span></span><?php echo site_phrase('my_wishlist'); ?></h1>
		</div>
	</div>
</section>

<div class="container margin_60_35">
	<div class="row justify-content-md-center">
		<?php foreach (json_decode($user_details['wishlist']) as $wishlist):
					$course_details = $this->crud_model->get_course_by_id($wishlist)->row_array();
					$instructor_details = $this->user_model->get_all_user($course_details['user_id'])->row_array(); ?>
					<div class="col-xl-4 col-lg-6 col-md-6">
						<div class="box_grid wow">
							<figure class="block-reveal">
								<div class="block-horizzontal"></div>
								<a href="javascript::" class="wishlist-btn wishlist-btn-<?php echo $course_details['id']; ?> <?php if($this->crud_model->is_added_to_wishlist($course_details['id'])):?> active <?php endif; ?> tooltip" onclick="handleWishList(this)" id = "<?php echo $course_details['id']; ?>">
			            <i class="fas fa-heart"></i>
									<?php if($this->crud_model->is_added_to_wishlist($course_details['id'])):?>
		                <span class="tooltiptext" id = "tooltiptext-<?php echo $course_details['id']; ?>"><?php echo site_phrase('remove_from_wishlist'); ?></span>
		              <?php else: ?>
		                <span class="tooltiptext" id = "tooltiptext-<?php echo $course_details['id']; ?>"><?php echo site_phrase('add_to_wishlist'); ?></span>
		              <?php endif; ?>
			          </a>
								<a href="<?php echo site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']); ?>"><img src="<?php echo $this->crud_model->get_course_thumbnail_url($course_details['id']); ?>" class="img-fluid" alt=""></a>
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
									<?php
		              $sub_category_details = $this->crud_model->get_category_details_by_id($course_details['sub_category_id'])->row_array();
		              echo $sub_category_details['name'];
		              ?>
								</small>
								<h3><?php echo ellipsis($course_details['title'], 100); ?></h3>
								<p><?php echo ellipsis($course_details['short_description'], 100); ?>.</p>
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
							<ul>
								<li>
			            <i class="icon-play-circled2"></i><?php echo $this->crud_model->get_lessons('course', $course_details['id'])->num_rows().' '.site_phrase('lessons'); ?>
			          </li>
			          <li>

			          </li>
			          <li>
									<?php if (is_purchased($course_details['id'])): ?>
		                <a href="<?php echo site_url('home/my_courses'); ?>"><i class="icon-check-1"></i> <?php echo site_phrase('purchased'); ?></a>
		              <?php else: ?>
		                <?php if ($course_details['is_free_course'] == 1):
		                  if($this->session->userdata('user_login') != 1) {
		                    $url = "javascript::";
		                  }else {
		                    $url = site_url('home/get_enrolled_to_free_course/'.$course_details['id']);
		                  }?>
		                  <a href="<?php echo $url; ?>" class="" onclick="handleEnrolledButton()"><?php echo site_phrase('enrol'); ?></a>
		                <?php else: ?>
		                  <a href="javascript::" class="big-cart-button-<?php echo $course_details['id'];?> <?php if(in_array($course_details['id'], $cart_items)) echo 'addedToCart'; ?>" id = "<?php echo $course_details['id']; ?>" onclick="handleCartItems(this)">
		                    <?php
		                    if(in_array($course_details['id'], $cart_items))
		                    echo site_phrase('added_to_cart');
		                    else
		                    echo site_phrase('add_to_cart');
		                    ?>
		                  </a>
		                <?php endif; ?>
		              <?php endif; ?>
			          </li>
							</ul>
						</div>
					</div>
		<?php endforeach; ?>
	</div>
	<!-- /row -->
</div>
<!-- /container -->
<!-- /bg_color_1 -->
