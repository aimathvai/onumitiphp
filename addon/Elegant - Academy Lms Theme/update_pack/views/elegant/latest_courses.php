<div class="container-fluid margin_120_0">
  <div class="main_title_2">
    <span><em></em></span>
    <h2><?php echo site_phrase('latest_courses'); ?></h2>
    <p><?php echo site_phrase('get_latest_10_course'); ?>.</p>
  </div>
  <div class="owl-carousel-div owl-carousel owl-theme">
    <?php $latest_courses = $this->crud_model->get_latest_10_course();
    foreach ($latest_courses as $latest_course):?>
    <!-- Each Top Course Starts -->
    <div class="item">
      <div class="box_grid">
        <figure>
          <a href="javascript::" class="wishlist-btn wishlist-btn-<?php echo $latest_course['id']; ?> <?php if($this->crud_model->is_added_to_wishlist($latest_course['id'])):?> active <?php endif; ?>" onclick="handleWishList(this)" id = "<?php echo $latest_course['id']; ?>">
            <i class="fas fa-heart"></i>
          </a>
          <a href="<?php echo site_url('home/course/'.slugify($latest_course['title']).'/'.$latest_course['id']); ?>">
            <div class="preview"><span><?php echo site_phrase('preview_course'); ?></span></div><img src="<?php echo $this->crud_model->get_course_thumbnail_url($latest_course['id']); ?>" class="img-fluid" alt=""></a>
            <?php if ($latest_course['is_free_course'] == 1): ?>
              <div class="price"><?php echo site_phrase('free'); ?></div>
            <?php else: ?>
              <?php if ($latest_course['discount_flag'] == 1): ?>
                <div class="price"><?php echo currency($latest_course['discounted_price']); ?></div>
              <?php else: ?>
                <div class="price"><?php echo currency($latest_course['price']); ?></div>
              <?php endif; ?>
            <?php endif; ?>
          </figure>
          <div class="wrapper">
            <small>
              <?php
              $sub_category_details = $this->crud_model->get_category_details_by_id($latest_course['sub_category_id'])->row_array();
              echo $sub_category_details['name'];
              ?>
            </small>
            <h3><?php echo $latest_course['title'] ?></h3>
            <p><?php echo $latest_course['short_description']; ?></p>
            <div class="rating">
              <?php
              $total_rating =  $this->crud_model->get_ratings('course', $latest_course['id'], true)->row()->rating;
              $number_of_ratings = $this->crud_model->get_ratings('course', $latest_course['id'])->num_rows();
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
            <i class="icon-play-circled2"></i><?php echo $this->crud_model->get_lessons('course', $latest_course['id'])->num_rows().' '.site_phrase('lessons'); ?>
          </li>
          <li>
            <i class="icon_clock_alt"></i>
            <?php
            $total_duration = 0;
            $lessons = $this->crud_model->get_lessons('course', $latest_course['id'])->result_array();
            foreach ($lessons as $lesson) {
              if ($lesson['lesson_type'] != "other") {
                $time_array = explode(':', $lesson['duration']);
                $hour_to_seconds = $time_array[0] * 60 * 60;
                $minute_to_seconds = $time_array[1] * 60;
                $seconds = $time_array[2];
                $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
              }
            }
            echo gmdate("H:i:s", $total_duration);
            ?>
          </li>
          <li>
            <?php if (is_purchased($latest_course['id'])): ?>
              <a href="<?php echo site_url('home/my_courses'); ?>"><i class="icon-check-1"></i> <?php echo site_phrase('purchased'); ?></a>
            <?php else: ?>
              <?php if ($latest_course['is_free_course'] == 1):
                if($this->session->userdata('user_login') != 1) {
                  $url = "javascript::";
                }else {
                  $url = site_url('home/get_enrolled_to_free_course/'.$latest_course['id']);
                }?>
                <a href="<?php echo $url; ?>" class="" onclick="handleEnrolledButton()"><?php echo site_phrase('enrol'); ?></a>
              <?php else: ?>
                <a href="javascript::" class="big-cart-button-<?php echo $latest_course['id'];?> <?php if(in_array($latest_course['id'], $cart_items)) echo 'addedToCart'; ?>" id = "<?php echo $latest_course['id']; ?>" onclick="handleCartItems(this)">
                  <?php
                  if(in_array($latest_course['id'], $cart_items))
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
    <!-- Each Top Course Ends -->
  <?php endforeach; ?>
</div>
<!-- /carousel -->
<div class="container">
  <p class="btn_home_align"><a href="<?php echo site_url('home/courses'); ?>" class="btn_1 rounded"><?php echo site_phrase('view_all_courses'); ?></a></p>
</div>
<!-- /container -->
<hr>
</div>
