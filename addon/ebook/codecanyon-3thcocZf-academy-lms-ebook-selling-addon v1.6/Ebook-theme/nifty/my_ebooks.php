<?php include "profile_menus.php"; ?>

<section class="my-courses-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h5 class="mb-3"><?= site_phrase('total').' '.count($my_ebooks->result_array()).' '.site_phrase('ebooks_purchased'); ?></h5>
            </div>
        </div>
        <div class="category-course-list">
            <div class="row">
                <?php foreach ($my_ebooks->result_array() as $key => $ebook) :
                    $ebook_payment_history = $this->db->get_where('ebook_payment', array('user_id' => $this->session->userdata('user_id'), 'ebook_id' => $ebook['ebook_id']))->row_array();
                    $instructor_details = $this->user_model->get_all_user($ebook['user_id'])->row_array(); ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="card ebook-card pt-4 px-5 margin-right">
                            <img src="<?php echo $this->ebook_model->get_ebook_thumbnail_url($ebook['ebook_id']); ?>"
                                class="card-img-top position-relative image" alt="ebook image" height="auto">
                            <div class="card-body text-center mb-2">
                                <div>
                                    <h5><a href="<?php echo site_url('ebook/ebook_details/'.rawurlencode(slugify($ebook['title'])).'/'.$ebook['ebook_id']) ?>"><?php echo $ebook['title'] ?></a></h3>
                                    <p>
                                        <i>by</i>
                                        <?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex mb-3 justify-content-evenly">
                                <a class="btn btn-success btn-sm" href="<?php echo site_url('addons/ebook/download_ebook_file/'.$ebook['ebook_id']) ?>"><i class="fas fa-download"></i> <?= site_phrase('download'); ?></a>&nbsp;
                                <a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('addons/ebook/ebook_rating/'.$ebook['ebook_id']); ?>', '<?php echo site_phrase('ebook_review'); ?>');" class="btn btn-warning btn-sm"><i class="fas fa-star"></i> <?php echo site_phrase('rating'); ?></a>&nbsp;
                                <a href="<?php echo site_url('addons/ebook/ebook_invoice/'.$ebook_payment_history['payment_id']); ?>" class="btn btn-info btn-sm"><i class="fas fa-print"></i> <?php echo site_phrase('invoice'); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- practice -->
        </div>
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
            .download-button {
                display: block;
                width: 100%;
                text-align: center;
                background-color: #48df99;
                padding: 10px;
                color: #fff;
            }
            .download-button:hover {
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
            .view-details {
                transition: .5s ease;
                background: #ffc84bed;
                text-align: center;
                margin-bottom:30px;
            }

            .text {
                background-color: #04AA6D;
                color: white;
                font-size: 16px;
                padding: 16px 32px;
            }
        </style>
    </div>
</section>