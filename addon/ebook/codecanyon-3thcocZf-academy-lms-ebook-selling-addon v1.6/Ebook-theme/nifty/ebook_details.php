<?php
$ebook_details = $this->ebook_model->get_ebook_by_id($ebook_id)->row_array();
$instructor_details = $this->user_model->get_all_user($ebook_details['user_id'])->row_array();
$category_details = $this->ebook_model->get_categories($ebook_details['category_id'])->row_array();
$path = base_url('uploads/ebook/file/ebook_preview/'.$ebook_details['preview']);
$totoalPages = countPages($path);

function countPages($path) {
    $pdftext = file_get_contents($path);
    $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
    return $num;
}
                              
?>

<!-- Hero Section -->
<div class="container space-top-1">
<div class="bg-primary rounded" style="background: url(<?= base_url('assets/frontend/nifty//svg/illustrations/knowledgebase-community-2.svg'); ?>) right bottom no-repeat;">
    <div class="py-4 px-6">
      <h1 class="display-5 text-white"><?php echo site_phrase('ebook_details'); ?></h1>
    </div>
  </div>
</div>
<!-- End Hero Section -->

<section class="ebook-header-area">
    <div class="container">
        <div class="row bg-white mt-4 py-5 ebook-shadow d-flex justify-content-center">
            <div class="col-lg-3 d-grid justify-content-center">
                <div class="border p-4">
                    <img height='300px' width='200px'
                        src="<?php echo $url = $this->ebook_model->get_ebook_thumbnail_url($ebook_details['ebook_id']); ?>">
                </div>
            </div>
            <div class="col-lg-4 text-lg-start ">
                <h4 class="text-sm text-lg-start"><?php echo $ebook_details['title'] ?></h4>
                <p class="m-0"><i><?php echo get_phrase('created_by') ?></i>
                    <a class="text-14px fw-600 text-decoration-none"
                        href="<?php echo site_url('home/instructor_page/' . $ebook_details['user_id']); ?>"><?php echo $instructor_details['first_name'] . ' ' . $instructor_details['last_name']; ?></a>

                </p>
                <p class="m-0"><?php echo get_phrase('publication_name : ') ?>
                    <span><?php echo $ebook_details['publication_name'] ?></span>
                </p>
                <p class="m-0"><?php echo get_phrase('published_date : ') ?><span><?php echo  date('D, d-M-Y', $ebook_details['added_date']); ?></span>
                </p>
                <p class="m-0"><?php echo get_phrase('category_name : ') ?><span><?php echo $category_details['title'] ?></span></p>
                <div class="rating-row">
                    <?php
                        $total_rating =  $this->ebook_model->get_ratings($ebook_details['ebook_id'], true)->row()->rating;
                        $number_of_ratings = $this->ebook_model->get_ratings($ebook_details['ebook_id'])->num_rows();
                        if ($number_of_ratings > 0) {
                        $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                        } else {
                        $average_ceil_rating = 0;
                        }

                    for ($i = 1; $i < 6; $i++) : ?>
                    <?php if ($i <= $average_ceil_rating) : ?>
                    <i class="fas fa-star filled" style="color: #f5c85b;"></i>
                    <?php else : ?>
                    <i class="fas fa-star"></i>
                    <?php endif; ?>
                    <?php endfor; ?>
                    <span
                        class="d-inline-block average-rating"><?php echo $average_ceil_rating; ?></span><span>(<?php echo $number_of_ratings . ' ' . site_phrase('ratings'); ?>)</span>

                </div>
                <div class="d-flex justify-content-center justify-content-md-start align-items-center">
                    <?php if($ebook_details['is_free']): ?>
                        <h3 class="text-center text-lg-start"><?php echo site_phrase('free'); ?></h3>
                    <?php elseif($ebook_details['discount_flag']): ?>
                        <del><?php echo currency($ebook_details['price']); ?></del>
                        <span class="ms-2">
                            <h3 class="text-center text-lg-start"><?php echo currency($ebook_details['discounted_price']); ?></h3>
                        </span>
                    <?php else: ?>
                        <h3 class="text-center text-lg-start"><?php echo currency($ebook_details['price']); ?></h3>
                    <?php endif ?>
                </div>

                <div class="d-flex justify-content-start">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#ebookModal"><?php echo get_phrase('read_preview') ?></button>
                        &nbsp;
                    <?php if($ebook_details['is_free']): ?>
                        <a href="<?php echo base_url('addons/ebook/download_ebook_file/'.$ebook_details['ebook_id']) ?>" class="btn btn-warning" type="button"><?php echo site_phrase('free_download'); ?></a>
                    <?php else: ?>
                        <?php if($this->db->get_where('ebook_payment', array('user_id' => $this->session->userdata('user_id'), 'ebook_id' => $ebook_details['ebook_id']))->num_rows() > 0): ?>
                            <a href="<?php echo base_url('home/my_ebooks') ?>" class="btn btn-warning"
                            type="button"
                            id="course_<?php echo $ebook_details['ebook_id']; ?>"><?php echo site_phrase('already_purchased'); ?></a>
                        <?php else: ?>
                            <a href="<?php echo base_url('ebook/buy/'.$ebook_details['ebook_id']) ?>" class="btn btn-warning"
                            type="button"
                            id="course_<?php echo $ebook_details['ebook_id']; ?>"><?php echo site_phrase('buy_now'); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Modal -->
                    <div class="modal fade mt-5" id="ebookModal" tabindex="-1" aria-labelledby="ebookModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="min-height: 450px;">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                <div class="modal-body justify-content-center">
                                <?php if(!empty($ebook_details['preview'])): ?>
                                <object
                                    data="<?php echo base_url('uploads/ebook/file/ebook_preview/'.$ebook_details['preview'].'#toolbar=0') ?>"
                                    height="100%" width="800px"></object>
                                <?php else: ?>
                                    <div class="w-100 text-center pt-5 mt-5">
                                        <img width="200px" class="" src="<?php echo site_url('assets/global/image/no-preview-available.png'); ?>">
                                    </div>
                                <?php endif ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
<style>
tr,
th,
td {
    padding: 10px 20px;

    border: 1px solid #dddddd;
}

th {
    background-color: #f1f2f4;
}

.h-10 {
    height: 10% !important;
}

.w-10 {
    width: 10% !important;

}

.ebook-modal {
    position: relative;
    flex: 1 1 auto;
    padding: 1rem;
    min-height: 80vh;
}
</style>
<section>
    <div class="container">
        <div class="row bg-white mt-4 py-8 p-4 ebook-shadow d-flex justify-content-start">
            <div class="col-md-12">
                <h4 class="mb-4"><?php echo get_phrase('book_specification_and_summary') ?></h4>
            </div>

            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="summary-tab" data-toggle="tab" data-target="#summary"
                            type="button" role="tab" aria-controls="home"
                            aria-selected="true"><?php echo get_phrase('summary') ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="home-tab" data-toggle="tab" data-target="#home" type="button"
                            role="tab" aria-controls="home"
                            aria-selected="true"><?php echo get_phrase('specification') ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="author-tab" data-toggle="tab" data-target="#author" type="button"
                            role="tab" aria-controls="author"
                            aria-selected="false"><?php echo get_phrase('author') ?></button>
                    </li>

                </ul>
            </div>
            <div class="tab-content mt-4 py-8 p-4" id="myTabContent">
                <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="author-tab">
                    <div>
                        <h5><?php echo $ebook_details['title'] ?></h5>
                        <p><?php echo htmlspecialchars_decode($ebook_details['description']) ?></p>
                    </div>

                </div>

                <div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
                    <table style="width:100%">
                        <tr>
                            <th style="width: 30%">Title</th>

                            <td style="width:70%"><?php echo $ebook_details['title'] ?></td>


                        </tr>
                        <tr>
                            <th>Author</td>
                            <td colspan="2">
                                <?php echo $instructor_details['first_name']." ".$instructor_details['last_name'] ?>
                            </td>

                        </tr>
                        <tr>
                            <th>Publisher</td>
                            <td><?php echo $ebook_details['publication_name'] ?></td>

                        </tr>
                        <tr>
                            <th>Edition</td>
                            <td><?php echo $ebook_details['edition'] ?></td>

                        </tr>
                        <tr>

                            <th>No. of page</td>
                            <td><?php echo $totoalPages ?></td>

                        </tr>
                    </table>
                </div>
                <div class="tab-pane fade" id="author" role="tabpanel" aria-labelledby="author-tab">
                    <div class="d-flex align-items-center">
                        <img class="rounded-circle w-10 h-10"
                            src="<?php echo $this->user_model->get_user_image_url($ebook_details['user_id']) ?>" alt="">
                            &nbsp;&nbsp;
                        <div class="ms-4">
                            <h3><?php echo $instructor_details['first_name']." ".$instructor_details['last_name'] ?>
                            </h3>
                            <p><?php echo $instructor_details['biography'] ?></p>

                        </div>

                    </div>

                </div>
            </div>


        </div>
    </div>
</section>


<div class="container margin_35">
    <div class="row">
        <div class="col-lg-12 order-last order-lg-first radius-10 mt-4 bg-white">



            <div class="row d-flex justify-content-center">
                <div class="col-12 px-4"><h3 class="my-4"><?php echo get_phrase("other_related_ebooks") ?></h3></div>

                <?php
                $this->db->limit(5);
                $other_related_ebooks = $this->ebook_model->get_ebooks($ebook_details['category_id'])->result_array();
                foreach ($other_related_ebooks as $other_related_ebook) : ?>

                <?php if($other_related_ebook['ebook_id'] != $ebook_details['ebook_id'] && $other_related_ebook['is_active']): ?>


                <div class="col-md-6 col-xl-3">


                    <div class="card ebook-card pt-4 px-4 margin-right">



                        <img src="<?php echo $this->ebook_model->get_ebook_thumbnail_url($other_related_ebook['ebook_id']); ?>"
                            class="card-img-top position-relative image" alt="ebook image" height="auto">




                        <div class="middle">


                            <a href="<?php echo base_url('ebook/buy/'.$other_related_ebook['ebook_id']) ?>"
                                class="buy-button"><?php echo get_phrase('buy_now') ?></a>
                        </div>

                        <div class="card-body text-center">

                            <div>
                                <h5><?php echo $other_related_ebook['title'] ?></h3>

                                    <p> <i>by</i>
                                        <?php $instructor_details = $this->user_model->get_all_user($other_related_ebook['user_id'])->row_array(); ?>
                                        <?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?>
                                    </p>

                            </div>

                            <div class="rating-row">
                                <?php
                                                    $total_rating =  $this->ebook_model->get_ratings($other_related_ebook['ebook_id'], true)->row()->rating;
                                                    $number_of_ratings = $this->ebook_model->get_ratings($other_related_ebook['ebook_id'])->num_rows();
                                                    if ($number_of_ratings > 0) {
                                                    $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                                                    } else {
                                                    $average_ceil_rating = 0;
                                                    }

                                                for ($i = 1; $i < 6; $i++) : ?>
                                <?php if ($i <= $average_ceil_rating) : ?>
                                <i class="fas fa-star filled" style="color: #f5c85b;"></i>
                                <?php else : ?>
                                <i class="fas fa-star"></i>
                                <?php endif; ?>
                                <?php endfor; ?>
                                <span
                                    class="d-inline-block average-rating"><?php echo $average_ceil_rating; ?></span><span>(<?php echo $number_of_ratings . ' ' . site_phrase('ratings'); ?>)</span>

                            </div>



                        </div>
                        <div class="view-details">
                            <a href="<?php echo site_url('ebook/ebook_details/'.rawurlencode(slugify($other_related_ebook['title'])).'/'.$other_related_ebook['ebook_id']) ?>"
                                class="d-block text-white">View details</a>
                        </div>

                    </div>


                </div>
                <?php endif ?>
                <?php endforeach; ?>

            </div>


            <div class="row">
                <!-- Author -->
                <div class="col-xl-9 mb-7">
                    <h3 class="mb-4"><?= site_phrase('about_instructor'); ?></h3>
                    <?php $instructor_details = $this->user_model->get_all_user($ebook_details['user_id'])->row_array(); ?>
                    <div class="row">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                          <div class="avatar avatar-xl avatar-circle mb-3">
                            <img class="avatar-img" src="<?php echo $this->user_model->get_user_image_url($instructor_details['id']); ?>" alt="Instructor image">
                          </div>

                          <!-- Icon Block -->
                          <div class="media text-body font-size-1 mb-2">
                            <div class="min-w-3rem text-center mr-2">
                              <i class="fa fa-comments"></i>
                            </div>
                            <div class="media-body">
                              <?php echo $this->ebook_model->get_instructor_wise_ebook_ratings($instructor_details['id'], 'ebook')->num_rows().' '.site_phrase('reviews'); ?>
                            </div>
                          </div>
                          <!-- End Icon Block -->

                          <!-- Icon Block -->
                          <div class="media text-body font-size-1 mb-2">
                            <div class="min-w-3rem text-center mr-2">
                              <i class="fa fa-play"></i>
                            </div>
                            <div class="media-body">
                              <?php echo $this->ebook_model->get_instructor_wise_ebooks($instructor_details['id'])->num_rows().' '.site_phrase('ebooks'); ?>
                            </div>
                          </div>
                          <!-- End Icon Block -->
                        </div>

                        <div class="col-lg-8">
                          <!-- Info -->
                          <div class="mb-2">
                            <h4 class="h5 mb-1">
                              <a class="link-underline" href="<?php echo site_url('home/instructor_page/'.$instructor_details['id']) ?>"><?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?></a>
                            </h4>
                            <span class="d-block font-size-1 font-weight-bold">
                              <?php echo $instructor_details['title']; ?>
                            </span>
                          </div>
                          <?php echo $instructor_details['biography']; ?>
                          <!-- End Info -->
                        </div>
                    </div>
                </div>
                <!-- End Author -->


                <!-- Overall Ratings -->
                <div class="col-xl-8 mb-7">
                  <h3 class="mb-4"><?= site_phrase('student_feedback'); ?></h3>

                  <div class="row align-items-center">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                      <!-- Overall Review Rating -->
                      <div class="card bg-primary text-white text-center py-4 px-3">
                        <?php
                        $total_rating =  $this->ebook_model->get_ratings($ebook_details['ebook_id'], true)->row()->rating;
                        $number_of_ratings = $this->ebook_model->get_ratings($ebook_details['ebook_id'])->num_rows();
                        if ($number_of_ratings > 0) {
                            $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                        } else {
                            $average_ceil_rating = 0;
                        }
                        ?>
                        <span class="display-4"><?= $average_ceil_rating.' '.site_phrase('rating'); ?></span>
                        <ul class="list-inline mb-2">
                          <?php for($i = 1; $i < 6; $i++):?>
                            <?php if ($i <= $average_ceil_rating): ?>
                              <li class="list-inline-item mx-0">
                                <img src="<?= base_url('assets/frontend/nifty/svg/illustrations/star.svg'); ?>" alt="Review rating" width="14">
                              </li>
                            <?php else: ?>
                                <li class="list-inline-item mx-0">
                                  <img src="<?= base_url('assets/frontend/nifty/svg/illustrations/star-muted.svg'); ?>" alt="Review rating" width="14">
                                </li>
                            <?php endif; ?>
                          <?php endfor; ?>
                        </ul>
                        <small><?php echo site_phrase('based_on').' '.$number_of_ratings.' '.site_phrase('reviews'); ?></small>
                      </div>
                      <!-- End Overall Review Rating -->
                    </div>

                    <div class="col-lg-8">
                      <ul class="list-unstyled list-sm-article mb-0">
                        <?php for($i = 5; $i >= 1; $i--): ?>
                          <?php $percentage_of_rating = $this->ebook_model->get_percentage_of_specific_rating($i, 'ebook', $ebook_id); ?>
                          <li>
                            <!-- Review Rating -->
                            <a class="d-flex align-items-center font-size-1" href="javascript:;">
                              <div class="progress w-100">
                                <div class="progress-bar" role="progressbar" style="width: <?= $percentage_of_rating; ?>%;" aria-valuenow="<?= $percentage_of_rating; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div class="d-flex align-items-center min-w-21rem ml-3">
                                <ul class="list-inline mr-1 mb-2">
                                  <?php for($j = 5; $j >= 1; $j--): ?>
                                    <?php if($i >= $j): ?>
                                    <li class="list-inline-item mr-1"><img src="<?= base_url('assets/frontend/nifty/svg/illustrations/star.svg'); ?>" alt="Review rating" width="16"></li>
                                    <?php else: ?>
                                      <li class="list-inline-item mr-1"><img src="<?= base_url('assets/frontend/nifty/svg/illustrations/star-muted.svg'); ?>" alt="Review rating" width="16"></li>
                                    <?php endif; ?>
                                  <?php endfor; ?>
                                </ul>
                                <span><?php echo $percentage_of_rating; ?>%</span>
                              </div>
                            </a>
                            <!-- End Review Rating -->
                          </li>
                        <?php endfor; ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- End Overall Ratings -->

                <div class="col-md-9">
                    <div class="reviews-container px-4">
                        <div class="reviews">
                            <h3><?php echo site_phrase('reviews'); ?></h3>
                        </div>
                        <?php
                        $ratings = $this->ebook_model->get_ratings($ebook_id)->result_array();
                        foreach ($ratings as $rating) : ?>
                            <div class="avatar-group">
                                <figure class="avatar avatar-circle mr-3"><img src="<?php echo $this->user_model->get_user_image_url($rating['user_id']); ?>" class="avatar-img" alt="Image Description">
                                </figure>
                                <div class="rev-content">
                                    <div class="rating">
                                        <?php for($i = 1; $i < 6; $i++):?>
                                            <?php if ($i <= $rating['rating']): ?>
                                                <i class="icon_star voted"></i>
                                            <?php else: ?>
                                                <i class="icon_star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="rev-info">
                                        <?php
                                        $user_details = $this->ebook_model->get_user($rating['user_id'])->row_array();
                                        echo $user_details['first_name'] . ' ' . $user_details['last_name'].' - '.date('D, d-M-Y', $rating['added_date']);
                                        ?>
                                    </div>
                                    <div class="rev-text">
                                        <p>
                                            <?php echo $rating['comment']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
</section>



<style media="screen">
.embed-responsive-16by9::before {
    padding-top: 0px;
}
</style>
<script type="text/javascript">
function handleCartItems(elem) {
    url1 = '<?php echo site_url('home/handleCartItems'); ?>';
    url2 = '<?php echo site_url('home/refreshWishList'); ?>';
    $.ajax({
        url: url1,
        type: 'POST',
        data: {
            course_id: elem.id
        },
        success: function(response) {
            $('#cart_items').html(response);
            if ($(elem).hasClass('active')) {
                $(elem).removeClass('active')
                $(elem).text("<?php echo site_phrase('add_to_cart'); ?>");
            } else {
                $(elem).addClass('active');
                $(elem).addClass('active');
                $(elem).text("<?php echo site_phrase('added_to_cart'); ?>");
            }
            $.ajax({
                url: url2,
                type: 'POST',
                success: function(response) {
                    $('#wishlist_items').html(response);
                }
            });
        }
    });
}

function handleBuyNow(elem) {

    url1 = '<?php echo site_url('home/handleCartItemForBuyNowButton'); ?>';
    url2 = '<?php echo site_url('home/refreshWishList'); ?>';
    urlToRedirect = '<?php echo site_url('home/shopping_cart'); ?>';
    var explodedArray = elem.id.split("_");
    var course_id = explodedArray[1];

    $.ajax({
        url: url1,
        type: 'POST',
        data: {
            course_id: course_id
        },
        success: function(response) {
            $('#cart_items').html(response);
            $.ajax({
                url: url2,
                type: 'POST',
                success: function(response) {
                    $('#wishlist_items').html(response);
                    toastr.success('<?php echo site_phrase('please_wait') . '....'; ?>');
                    setTimeout(
                        function() {
                            window.location.replace(urlToRedirect);
                        }, 1000);
                }
            });
        }
    });
}

function handleEnrolledButton() {
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn?url_history='.base64_encode(current_url())); ?>',
        success: function(response) {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }
        }
    });
}

function handleAddToWishlist(elem) {
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn?url_history='.base64_encode(current_url())); ?>',
        success: function(response) {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            } else {
                $.ajax({
                    url: '<?php echo site_url('home/handleWishList'); ?>',
                    type: 'POST',
                    data: {
                        course_id: elem.id
                    },
                    success: function(response) {
                        if ($(elem).hasClass('active')) {
                            $(elem).removeClass('active');
                            $(elem).text("<?php echo site_phrase('add_to_wishlist'); ?>");
                        } else {
                            $(elem).addClass('active');
                            $(elem).text("<?php echo site_phrase('added_to_wishlist'); ?>");
                        }
                        $('#wishlist_items').html(response);
                    }
                });
            }
        }
    });
}

function pausePreview() {
    player.pause();
}

$('.course-compare').click(function(e) {
    e.preventDefault()
    var redirect_to = $(this).attr('redirect_to');
    window.location.replace(redirect_to);
});

function go_course_playing_page(course_id, lesson_id) {
    var course_playing_url = "<?php echo site_url('home/lesson/'.slugify($ebook_details['title'])); ?>/" + course_id +
        '/' + lesson_id;

    $.ajax({
        url: '<?php echo site_url('home/go_course_playing_page/'); ?>' + course_id,
        type: 'POST',
        success: function(response) {
            if (response == 1) {
                window.location.replace(course_playing_url);
            }
        }
    });
}
</script>

<style>
.ebook-card {
    position: relative;
    width: 100%;
    min-height: 460px;
    margin-bottom: 20px;
}

.image {
    opacity: 1;
    display: block;
    width: 100%;
    height: auto;
    transition: .5s ease;
    backface-visibility: hidden;

}


.margin-right {
    margin-right: 10px;
}

.buy-button {
    display: block;
    width: 100%;
    text-align: center;
    background-color: #999933;
    padding: 10px;
    color: #fff;
}

.buy-button:hover {
    color: #fff;
}

.middle {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    /* display: block; */
    top: 32%;
    width: inherit;
    right: 0;
    /* margin-left: 30px; */
    padding: 24px;
}

.low {
    transition: .5s ease;
    opacity: -1;
    position: relative;
    bottom: -20px;
}




.ebook-card:hover .image {
    opacity: 0.3;
}

.ebook-card:hover .middle {
    /* opacity: 0.3; */
    opacity: 1;
}

.view-details {
    transition: .5s ease;
    display: none;
    background: #ffc84bed;
    width: -webkit-fill-available;

    padding: 12px;
    position: absolute;
    text-align: center;

    bottom: 0;
    right: 0;
}

.ebook-card:hover .view-details {


    display: block;
}

.text {
    background-color: #04AA6D;
    color: white;
    font-size: 16px;
    padding: 16px 32px;
}

.more-by-instructor-box {
    background-color: #f9f9f9;
    border: 1px solid #dedfe0;
    margin-bottom: 50px;
    padding: 10px 8px;
}

.more-by-instructor-box .more-by-instructor-title {
    font-size: 22px;
    font-weight: 600;
    margin: 0 0 10px 7px;
}
.about-instructor-box .about-instructor-title {
    display: block;
    font-size: 22px;
    font-weight: 600;
    margin: 0 0 20px;
}

.about-instructor-box .about-instructor-image img {
    width: 96px;
    height: 96px;
    border-radius: 50%;
}

.about-instructor-box .about-instructor-image ul {
    padding: 0;
    margin: 0;
    list-style: none;
    margin-top: 15px;
}

.about-instructor-box .about-instructor-image ul b {
    font-weight: 600;
}

.about-instructor-box .about-instructor-image ul i {
    width: 26px;
    font-size: 13px;
}

.about-instructor-box .about-instructor-image ul li {
    margin-bottom: 5px;
}

.about-instructor-details {
    max-height: 380px;
}

.about-instructor-box {
    margin-bottom: 40px;
}

.about-instructor-details .instructor-name {
    font-size: 18px;
    font-weight: 600;
    line-height: 1.33;
    margin-bottom: 10px;
}

.about-instructor-details .instructor-title {
    font-size: 16px;
    font-weight: 600;
    line-height: 1.33;
    margin-bottom: 10px;
}

.student-feedback-box .student-feedback-title {
    font-size: 22px;
    font-weight: 600;
    margin: 0 0 15px;
}

.student-feedback-box .average-rating {
    border: 1px solid #dedfe0;
    padding: 5px;
    height: 165px;
    width: 170px;
    line-height: 30px;
    text-align: center;
    border-radius: 10px;
}

.student-feedback-box .average-rating .num {
    font-size: 72px;
    font-weight: 500;
    line-height: 1;
    margin-bottom: 10px;
}

.student-feedback-box .average-rating .rating i {
    font-size: 20px;
    color: #f4c150;
    margin-bottom: 5px;
}

.student-feedback-box .individual-rating ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.student-feedback-box .individual-rating ul li {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    margin-bottom: 10px;
}
.student-feedback-box .individual-rating ul li .progress{
    width: 100%;
    height: 10px;
    border-radius: 5px;
    background-color: #eceb98;
}
.student-feedback-box .individual-rating ul li .progress-bar{
    border-radius: 5px;
    background-color: #ec5252;
    font-size: 11px;
}
.student-feedback-box .individual-rating .rating i {
    font-size: 14px;
    color: #dedfe0;
}

.student-feedback-box .individual-rating .rating i.filled {
    color: #f4c150;
}

.student-feedback-box .individual-rating li > div:not(.progress) {
    padding-left: 15px;
    min-width: 120px !important;
}

.student-feedback-box .individual-rating li > div:not(.progress) span:not(.rating) {
    text-align: center;
    padding-left: 10px;
    color: #007791;
}
.student-feedback-box .reviews .reviews-title {
    font-size: 18px;
    font-weight: 600;
    padding: 0 0 20px;
}

.student-feedback-box .reviews ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.student-feedback-box .reviews .reviewer-details img {
    height: 50px;
    width: 50px;
    border-radius: 10px;
}
.student-feedback-box .reviews .reviewer-details .review-time .time {
    color: #686f7a;
}

.student-feedback-box .reviews ul li {
    padding: 30px 0;
    border-top: 1px solid #dedfe0;
}

.student-feedback-box .reviews ul li:last-child {
    border-bottom: 1px solid #dedfe0;
}

.student-feedback-box .reviews .review-details .rating i {
    color: #dedfe0;
    margin-bottom: 15px;
}

.student-feedback-box .reviews .review-details .rating i.filled {
    color: #f4c150;
}

.student-feedback-box .reviews .review-details .review-text {
    color: #505763;
    margin-bottom: 10px;
    font-size: 16px;
}

.student-feedback-box .reviews {
    margin-top: 30px;
}
.reviews .more-reviews-btn {
    text-align: center;
}

.reviews .more-reviews-btn button {
    border-radius: 2px;
    border: 2px solid #007791;
    color: #007791;
    background: #fff;
    padding: 11px 12px;
    font-size: 15px;
    font-weight: 600;
}

.reviews .more-reviews-btn button:hover,
.reviews .more-reviews-btn button:focus {
    background-color: #e6f2f5;
}

.margin_35 {
    padding-bottom: 35px;
}

</style>