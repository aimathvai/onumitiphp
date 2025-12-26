<style>
  .purchase-history-course-img img{
    width: 60px;
    height: 60px;
    border-radius: 100%;
    float: left;
  }
  .purchase-history-list-header{
    padding-top: 15px;
    padding-bottom: 15px;
  }
  .purchase-history-items{
    padding-bottom: 15px;
    border-bottom: 1px solid #efefef;
  }
  .ofline-payment-pending{
    color: #ffc107;
  }
  .purchase-history-course-title{
    line-height: 50px;
    margin-left: 10px;
  }
</style>
<?php
$this->db->where('user_id', $this->session->userdata('user_id'));
$purchase_history = $this->db->get('payment',$per_page, $this->uri->segment(3));
$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
$purchase_history_banner = $banners['purchase_history_banner'];
?>
<section id="hero_in" class="general">
  <div class="banner-img" style="background: url(<?php echo base_url($purchase_history_banner); ?>) center center no-repeat;"></div>
  <div class="wrapper">
    <div class="container">
      <h1 class="fadeInUp"><span></span><?php echo site_phrase('purchase_history'); ?></h1>
    </div>
  </div>
</section>

<div class="bg_color_1">
  <div class="container margin_60_35">
    <div class="row">
      <div class="col-lg-12">
        <div class="box_cart">
          <table class="table table-striped cart-list">
            <thead>
              <tr>
                <th>
                  <?php echo site_phrase('course'); ?>
                </th>
                <th>
                  <?php echo site_phrase('amount_paid'); ?>
                </th>
                <th>
                  <?php echo site_phrase('purchase_date'); ?>
                </th>
                <th>
                  <?php echo site_phrase('actions'); ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php if ($purchase_history->num_rows() > 0):
                foreach($purchase_history->result_array() as $each_purchase):
                  $course_details = $this->crud_model->get_course_by_id($each_purchase['course_id'])->row_array();?>
                  <tr>
                    <td>
                      <div class="thumb_cart">
                        <img src="<?php echo $this->crud_model->get_course_thumbnail_url($each_purchase['course_id']);?>" alt="Image">
                      </div>
                      <span class="item_cart">
                        <a href="<?php echo site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']); ?>" style="color: unset;"> <?php echo ellipsis($course_details['title']); ?> </a>
                      </span>
                    </td>
                    <td>
                      <strong><?php echo currency($each_purchase['amount']); ?></strong>
                    </td>
                    <td>
                      <strong><?php echo date('D, d-M-Y', $each_purchase['date_added']); ?></strong>
                    </td>
                    <td class="options" style="width:5%; text-align:center;">
                      <a href="<?php echo site_url('home/invoice/'.$each_purchase['id']); ?>" class="btn_1 rounded" target="_blank"><i class="icon-print-1"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
          <!-- /cart-options -->
        </div>
      </div>
      <!-- /col -->
    </div>
    <!-- /row -->
  </div>
  <!-- /container -->
</div>
<!-- /bg_color_1 -->
<?php
  if(addon_status('offline_payment') == 1):
    include APPPATH.'/views/frontend/default/pending_purchase_course_history.php';
  endif;
?>
<div class="row justify-content-center">
  <nav aria-label="...">
    <?php
    echo $this->pagination->create_links();
    ?>
  </nav>
</div>
