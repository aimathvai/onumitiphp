<?php
  $banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
  $shopping_cart_banner = $banners['shopping_cart_banner'];
  $actual_price = 0;
  $total_price  = 0;
?>
<section id="hero_in" class="general">
  <div class="banner-img" style="background: url(<?php echo base_url($shopping_cart_banner); ?>) center center no-repeat;"></div>
  <div class="wrapper">
    <div class="container">
      <h1 class="fadeInUp"><span></span><?php echo site_phrase('shopping_cart'); ?></h1>
    </div>
  </div>
</section>

<div class="bg_color_1">
  <div class="container margin_60_35">
    <div class="row">
      <div class="col-lg-8">
        <div class="box_cart">
          <table class="table table-striped cart-list">
            <thead>
              <tr>
                <th>
                  <?php echo site_phrase('item'); ?>
                </th>
                <th>
                  <?php echo site_phrase('discount'); ?>
                </th>
                <th>
                  <?php echo site_phrase('price'); ?>
                </th>
                <th>
                  <?php echo site_phrase('actions'); ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $amount_to_pay = 0;
              foreach ($this->session->userdata('cart_items') as $cart_item):
                $course_details = $this->crud_model->get_course_by_id($cart_item)->row_array();
                if($course_details['discount_flag'] == 1):
                  $total_price += $course_details['discounted_price'];
                  $actual_price += $course_details['price'];
                else:
                  $actual_price += $course_details['price'];
                  $total_price  += $course_details['price'];
                endif;
                ?>
                <tr>
                  <td>
                    <div class="thumb_cart">
                      <img src="<?php echo $this->crud_model->get_course_thumbnail_url($course_details['id']); ?>" alt="Image">
                    </div>
                    <span class="item_cart"><a href="<?php echo site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']); ?>"><?php echo ellipsis($course_details['title'], 30); ?></a></span>
                  </td>
                  <?php if ($course_details['is_free_course'] == 1): ?>
                    <td>
                      100%
                    </td>
                    <td>
                      <strong><?php echo site_phrase('free'); ?></strong>
                    </td>
                  <?php else: ?>
                    <?php if ($course_details['discount_flag'] == 1): ?>
                      <td>
                        <?php echo number_format((float)((($course_details['price'] - $course_details['discounted_price']) * 100))/$course_details['price'], 2, '.', '').' %'; ?>
                      </td>
                      <td>
                        <strong>
                          <?php
                            $amount_to_pay = $amount_to_pay + $course_details['discounted_price'];
                            echo currency($course_details['discounted_price']);
                          ?>
                        </strong>
                      </td>
                    <?php else: ?>
                      <td>
                        0%
                      </td>
                      <td>
                        <strong>
                          <?php
                            $amount_to_pay = $amount_to_pay + $course_details['price'];
                            echo currency($course_details['price']);
                          ?>
                        </strong>
                      </td>
                    <?php endif; ?>
                  <?php endif; ?>
                  <td class="options" style="width:5%; text-align:center;">
                    <a href="javascript::" id = "<?php echo $course_details['id']; ?>" onclick="removeFromCartList(this)"><i class="icon-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <!-- /cart-options -->
        </div>
      </div>
      <!-- /col -->

      <aside class="col-lg-4" id="sidebar">
        
        <div class="box_detail">
          <div id="total_cart">
            <?php echo site_phrase('total'); ?>
            <?php 
              if(get_settings('course_selling_tax') > 0):
                $total_tax = round(($amount_to_pay/100) * get_settings('course_selling_tax'), 2);
                $amount_to_pay = round($amount_to_pay + ($amount_to_pay/100) * get_settings('course_selling_tax'), 2);
              else:
                $amount_to_pay = round($amount_to_pay, 2);
              endif;
            ?>
            <?php if (isset($coupon_code) && !empty($coupon_code) && $this->crud_model->check_coupon_validity($coupon_code)) :

                $coupon_details = $this->crud_model->get_coupon_details_by_code($coupon_code)->row_array();

                //including Tax or vat
                if(get_settings('course_selling_tax') > 0):
                    $amount_to_pay = $this->crud_model->get_discounted_price_after_applying_coupon($coupon_code);

                    $total_tax = round(($amount_to_pay/100) * get_settings('course_selling_tax'), 2);
                    $amount_to_pay = round($amount_to_pay + ($amount_to_pay/100) * get_settings('course_selling_tax'), 2);
                else:
                    $amount_to_pay = round($this->crud_model->get_discounted_price_after_applying_coupon($coupon_code), 2);
                endif;
                
                $this->session->set_userdata('total_price_of_checking_out', $amount_to_pay);
                $this->session->set_userdata('applied_coupon', $coupon_code); ?>

                <span class="float-right text-muted"><del><?php echo currency($actual_price); ?><del></span>
                <span class="float-right"><?php echo currency($amount_to_pay); ?></span>
                <span id = "total_price_of_checking_out" hidden><?php echo $amount_to_pay; $this->session->set_userdata('total_price_of_checking_out', $amount_to_pay);?></span>

                <div class="media align-items-center mt-4">
                  <div class="media-body text-center">
                    <span class="text-warning" style="font-size: 16px;">
                      <?php echo $coupon_details['discount_percentage']; ?>% <?php echo site_phrase('coupon_code_applied'); ?> !
                    </span>
                  </div>
                </div>
            <?php else: ?>

                <span class="float-right"><?php echo currency($amount_to_pay); ?></span>
                <span id = "total_price_of_checking_out" hidden><?php echo $amount_to_pay; $this->session->set_userdata('total_price_of_checking_out', $amount_to_pay);?></span>
            <?php endif; ?>

              </div>

              <!-- including Tax or vat -->
              <div class="input-group">
              <?php if(get_settings('course_selling_tax') > 0): ?>
                  <small class="d-block mb-3 w-100 text-12px text-uppercase"><b><?php echo currency($total_tax).'</b> ('.get_settings('course_selling_tax').'%) '.get_phrase('TAX_INCLUDED'); ?></small>
              <?php endif; ?>
              </div>

              <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="<?php echo site_phrase('apply_coupon_code'); ?>" id="coupon-code" value="<?php if(isset($coupon_code))echo html_escape($coupon_code); ?>">
                  <div class="input-group-append">
                      <button class="btn btn-warning" type="button" onclick="applyCoupon()"><?php echo site_phrase('apply'); ?></button>
                  </div>
              </div>
              <div class="add_bottom_30"></div>
              <?php if ($amount_to_pay > 0): ?>
                <a href="javascript::" onclick="handleCheckOut()" class="btn_1 full-width"><?php echo site_phrase('checkout'); ?></a>
                <a href="<?php echo site_url('home/courses'); ?>" class="btn_1 full-width outline"><i class="icon-right"></i> <?php echo site_phrase('continue_shopping'); ?></a>
            <?php endif; ?>
        </div>
      </aside>
    </div>
    <!-- /row -->
  </div>
  <!-- /container -->
</div>
<!-- /bg_color_1 -->
