<?php
isset($layout) ? "" : $layout = "list";
isset($selected_category_id) ? "" : $selected_category_id = "all";
isset($selected_rating) ? "" : $selected_rating = "all";
isset($selected_price) ? "" : $selected_price = "all";
$number_of_visible_categories = 10;

?>

<section id="hero_in" class="ebooks">
    <div class="banner-img" style="background: url(<?php echo base_url('uploads/system/ebook_page_banner.png'); ?>) center center no-repeat;"></div>
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp"><span></span>
                <?php echo site_phrase('ebooks'); ?>/
                <?php
                if ($selected_category_id == "all") {
                    echo site_phrase('all_category');
                } else {
                    $category_details = $this->ebook_model->get_category_details_by_id($selected_category_id)->row_array();
                    if(isset($category_details['title'])){
                        echo $category_details['title'];
                    }
                }
                ?>
            </h1>
        </div>
    </div>
</section>
<!--/hero_in-->

<section class="container margin_60_35">
    <div class="container">
        <div class="row">
            <aside class="col-lg-3 filter-area">
                <div class="card border-0 radius-10">
                    <div id="collapseFilter" class="collapse show" aria-labelledby="headingOne"
                        data-parent="#accordion">
                        <div class="card-body p-0">
                            <div class="filter_type px-4 pt-4">
                                <h5 class="fw-700 mb-4"><?php echo site_phrase('categories'); ?></h5>
                                <ul>
                                    <li class="">
                                        <div class="text-15px fw-700 d-flex">
                                            <input type="radio" id="category_all" name="sub_category"
                                                class="categories custom-radio" value="all" onclick="filter(this)"
                                                <?php if ($selected_category_id == 'all') echo 'checked'; ?>>
                                            <label for="category_all"><?php echo site_phrase('all_categories'); ?></label>
                                            <div class="ms-auto">
                                                (<?php echo $total_active_ebooks; ?>)
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                    $counter = 1;
                                    $total_number_of_categories = $this->db->get('ebook_category')->num_rows();
                                    $categories = $this->ebook_model->get_categories()->result_array();
                
                                    foreach ($categories as $category) : ?>
                                    <li class="mt-3">
                                        <div
                                            class="text-15px fw-700 d-flex <?php if ($counter > $number_of_visible_categories) : ?> hidden-categories hidden <?php endif; ?>">
                                            <input type="radio" id="category-<?php echo $category['category_id']; ?>"
                                                name="sub_category" class="categories custom-radio"
                                                value="<?php echo $category['slug']; ?>" onclick="filter(this)"
                                                <?php if ($selected_category_id == $category['category_id']) echo 'checked'; ?>>
                                            <label
                                                for="category-<?php echo $category['category_id']; ?>"><?php echo $category['title']; ?></label>
                                            <div class="ms-auto">
                                                (<?php echo $this->ebook_model->get_active_addon_by_category_id($category['category_id'], 'category_id')->num_rows(); ?>)
                                            </div>
                                        </div>
                                    </li>

                                    <?php endforeach; ?>
                                </ul>
                                <a href="javascript:;" class="text-13px fw-500" id="city-toggle-btn"
                                    onclick="showToggle(this, 'hidden-categories')"><?php echo $total_number_of_categories > $number_of_visible_categories ? site_phrase('show_more') : ""; ?></a>
                            </div>
                            <hr>
                            <div class="filter_type px-4">
                                <div class="form-group">
                                    <h5 class="fw-700 mb-3"><?php echo site_phrase('price'); ?></h5>
                                    <ul>
                                        <li>
                                            <div class="">
                                                <input type="radio" id="price_all" name="price"
                                                    class="prices custom-radio" value="all" onclick="filter(this)"
                                                    <?php if ($selected_price == 'all') echo 'checked'; ?>>
                                                <label for="price_all"><?php echo site_phrase('all'); ?></label>
                                            </div>
                                            <div class="">
                                                <input type="radio" id="price_free" name="price"
                                                    class="prices custom-radio" value="free" onclick="filter(this)"
                                                    <?php if ($selected_price == 'free') echo 'checked'; ?>>
                                                <label for="price_free"><?php echo site_phrase('free'); ?></label>
                                            </div>
                                            <div class="">
                                                <input type="radio" id="price_paid" name="price"
                                                    class="prices custom-radio" value="paid" onclick="filter(this)"
                                                    <?php if ($selected_price == 'paid') echo 'checked'; ?>>
                                                <label for="price_paid"><?php echo site_phrase('paid'); ?></label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <hr>
                            <div class="filter_type px-4">
                                <h5 class="fw-700 mb-3"><?php echo site_phrase('ratings'); ?></h5>
                                <ul>
                                    <li>
                                        <div class="">
                                            <input type="radio" id="all_rating" name="rating"
                                                class="ratings custom-radio" value="<?php echo 'all'; ?>"
                                                onclick="filter(this)"
                                                <?php if ($selected_rating == "all") echo 'checked'; ?>>
                                            <label for="all_rating"><?php echo site_phrase('all'); ?></label>
                                        </div>
                                    </li>
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <li>
                                        <div class="">
                                            <input type="radio" id="rating_<?php echo $i; ?>" name="rating"
                                                class="ratings custom-radio" value="<?php echo $i; ?>"
                                                onclick="filter(this)"
                                                <?php if ($selected_rating == $i) echo 'checked'; ?>>
                                            <label for="rating_<?php echo $i; ?>">
                                                <?php for ($j = 1; $j <= $i; $j++) : ?>
                                                <i class="fas fa-star" style="color: #f4c150;"></i>
                                                <?php endfor; ?>
                                                <?php for ($j = $i; $j < 5; $j++) : ?>
                                                <i class="far fa-star" style="color: #dedfe0;"></i>
                                                <?php endfor; ?>
                                            </label>
                                        </div>
                                    </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <div class="col-lg-9">
                <div class="row category-filter-box bg-white mb-4 py-2 mx-0">
                    <div class="col-md-6 d-grid align-items-center">
                        <strong class="text-12px fw-700 text-muted"><?php echo site_phrase('showing').' '.count($ebooks).' '.site_phrase('of').' '.$total_result.' '.site_phrase('results'); ?></strong>
                    </div>
                    <div class="col-md-6 text-end">
                        <form action="<?php echo site_url('ebook') ?>" method='get'>
                            <div class="input-group common-search-box">
                                <input type="text" class="form-control py-2" placeholder="<?php echo site_phrase('search'); ?>">
                                <dib class="input-group-button">
                                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                                </dib>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="category-course-list">
                    <div class="row">
                        <?php foreach ($ebooks as $ebook) :
                            $instructor_details = $this->user_model->get_all_user($ebook['user_id'])->row_array(); ?>
                            <div class="col-md-6 col-xl-4">
                                <div class="card ebook-card pt-4 px-4 margin-right">
                                    <img src="<?php echo $this->ebook_model->get_ebook_thumbnail_url($ebook['ebook_id']); ?>"
                                        class="card-img-top position-relative image" alt="ebook image" height="auto">
                                    <div class="middle">
                                        <?php if($ebook['is_free'] == 1): ?>
                                            <p class="buy-button"><?php echo site_phrase('free'); ?></p>
                                        <?php else: ?>
                                            <div class="w-100 fw-700 text-center">
                                                <?php if($ebook['discount_flag']): ?>
                                                        <del class="text-muted text-25px"><?php echo currency($ebook['price']); ?></del>
                                                        <span class="text-35px"><?php echo currency($ebook['discounted_price']); ?></span>
                                                <?php else: ?>
                                                        <span class="text-35px"><?php echo currency($ebook['price']); ?></span>
                                                <?php endif; ?>
                                            </div>
                                             <?php if($this->db->get_where('ebook_payment', array('user_id' => $this->session->userdata('user_id'), 'ebook_id' => $ebook['ebook_id']))->num_rows() > 0): ?>
                                                <a href="<?php echo base_url('home/my_ebooks') ?>" class="buy-button"
                                                type="button"
                                                id="course_<?php echo $ebook['ebook_id']; ?>"><?php echo site_phrase('already_purchased'); ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo base_url('ebook/buy/'.$ebook['ebook_id']) ?>" class="buy-button"
                                                type="button"
                                                id="course_<?php echo $ebook['ebook_id']; ?>"><?php echo site_phrase('buy_now'); ?></a>
                                            <?php endif; ?>
                                        <?php endif ?>
                                    </div>
                                    <div class="card-body text-center">
                                        <div>
                                            <h5><?php echo $ebook['title'] ?></h3>
                                            <p>
                                                <i>by</i>
                                                <?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="view-details">
                                        <a href="<?php echo site_url('ebook/ebook_details/'.rawurlencode(slugify($ebook['title'])).'/'.$ebook['ebook_id']) ?>"
                                            class="d-block text-white"><?php echo site_phrase('view_details'); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php echo $this->pagination->create_links(); ?>
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
                    .text-35px{
                        font-size: 35px;
                    }
                    .text-25px{
                        font-size: 25px;
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
                </style>
                <?php if (count($ebooks) == 0) : ?>
                    <?php echo site_phrase('no_result_found'); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
function get_url() {
    var urlPrefix = '<?php echo site_url('ebook?'); ?>'
    var urlSuffix = "";
    var slectedCategory = "";
    var selectedPrice = "";
    var selectedRating = "";
    var search_text = "";

    // Get selected category
    $('.categories:checked').each(function() {
        slectedCategory = $(this).attr('value');
    });

    // Get selected price
    $('.prices:checked').each(function() {
        selectedPrice = $(this).attr('value');
    });



    searchText = $('.search').val();



    // Get selected rating
    $('.ratings:checked').each(function() {
        selectedRating = $(this).attr('value');
    });



    if (searchText != null) {
        urlSuffix = "category=" + slectedCategory + "&&price=" + selectedPrice + "&&rating=" + selectedRating +
            "&&search=" + searchText;

    } else {
        urlSuffix = "category=" + slectedCategory + "&&price=" + selectedPrice + "&&rating=" + selectedRating;

    }
    var url = urlPrefix + urlSuffix;
    return url;
}

function filter() {
    var url = get_url();
    window.location.replace(url);
    //console.log(url);
}

function toggleLayout(layout) {
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url('home/set_layout_to_session'); ?>',
        data: {
            layout: layout
        },
        success: function(response) {
            location.reload();
        }
    });
}

function showToggle(elem, selector) {
    $('.' + selector).slideToggle(20);
    if ($(elem).text() === "<?php echo site_phrase('show_more'); ?>") {
        $(elem).text('<?php echo site_phrase('show_less'); ?>');
    } else {
        $(elem).text('<?php echo site_phrase('show_more'); ?>');
    }
}

$('.course-compare').click(function(e) {
    e.preventDefault()
    var redirect_to = $(this).attr('redirect_to');
    window.location.replace(redirect_to);
});
</script>