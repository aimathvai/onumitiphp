<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

<!-- SHOW TOASTR NOTIFIVATION -->
<?php if ($this->session->flashdata('flash_message') != ""):?>
    <script type="text/javascript">
    toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
</script>
<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""):?>
    <script type="text/javascript">
    toastr.error('<?php echo $this->session->flashdata("error_message");?>');
</script>
<?php endif;?>

<?php if ($this->session->flashdata('info_message') != ""):?>
    <script type="text/javascript">
    toastr.info('<?php echo $this->session->flashdata("info_message");?>');
</script>
<?php endif;?>

<!-- This scrips are being used in multiple views -->
<script type="text/javascript">
// Responsible for handling Wishlist
function handleWishList(elem) {
    handleEnrolledButton();
    $.ajax({
        url: '<?php echo site_url('home/handleWishList');?>',
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }else {
                if ($(elem).hasClass('active')) {
                    $('.wishlist-btn-'+elem.id).removeClass('active');
                    $('#tooltiptext-'+elem.id).text('<?php echo site_phrase("add_to_wishlist"); ?>');
                }else {
                    $('.wishlist-btn-'+elem.id).addClass('active');
                    $('#tooltiptext-'+elem.id).text('<?php echo site_phrase("remove_from_wishlist"); ?>');
                }
                $('#wishlist_items').html(response);
            }
        }
    });
}

// Responsible for handling Cart items
function handleCartItems(elem) {
    url1 = '<?php echo site_url('home/handleCartItems');?>';
    url2 = '<?php echo site_url('home/refreshWishList');?>';
    $.ajax({
        url: url1,
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            $('#cart_items').html(response);
            if ($(elem).hasClass('addedToCart')) {
                $('.big-cart-button-'+elem.id).removeClass('addedToCart')
                $('.big-cart-button-'+elem.id).text("<?php echo site_phrase('add_to_cart'); ?>");
            }else {
                $('.big-cart-button-'+elem.id).addClass('addedToCart')
                $('.big-cart-button-'+elem.id).text("<?php echo site_phrase('added_to_cart'); ?>");
            }
            $.ajax({
                url: url2,
                type : 'POST',
                success: function(response)
                {
                    $('#wishlist_items').html(response);
                }
            });
        }
    });
}

// Responsible for enrolling a student to a free course.

function handleEnrolledButton() {
    
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn?url_history='.base64_encode($actual_link)); ?>',
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }
        }
    });
}

// Responsible for removing items from the cart list
function removeFromCartList(elem) {
    url1 = '<?php echo site_url('home/handleCartItems');?>';
    $.ajax({
        url: url1,
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            $('#cart_items').html(response);
        }
    });
}

function handleBuyNow(course_id) {
    url = '<?php echo site_url('home/handleCartItemForBuyNowButton');?>';

    $.ajax({
        url: url,
        type : 'POST',
        data : {course_id : course_id},
        success: function(response)
        {
            window.location.replace("<?php echo site_url('home/shopping_cart'); ?>");
        }
    });
}

function handleCheckOut() {
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn?url_history='.base64_encode($actual_link)); ?>',
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }else if("<?php echo $this->session->userdata('total_price_of_checking_out'); ?>" > 0){
                window.location.replace("<?php echo site_url('home/payment/'); ?>");
            }else{
                toastr.error('<?php echo site_phrase('there_are_no_courses_on_your_cart');?>');
            }
        }
    });
}

function showNewMessageSection() {
    $('.inner-message-section').hide();
    $('.new-message-section').show();
}
function cancelNewMessage() {
    $('.inner-message-section').show();
    $('.new-message-section').hide();
}

function toggleRatingView(course_id) {
    $('#course_info_view_'+course_id).toggle();
    $('#course_rating_view_'+course_id).toggle();
    $('#edit_rating_btn_'+course_id).toggle();
    $('#cancel_rating_btn_'+course_id).toggle();
}

function publishRating(course_id) {
    var review = $('#review_of_a_course_'+course_id).val();
    var starRating = 0;
    starRating = $('#star_rating_of_course_'+course_id).val();
    if (starRating > 0) {
        $.ajax({
            type : 'POST',
            url  : '<?php echo site_url('home/rate_course'); ?>',
            data : {course_id : course_id, review : review, starRating : starRating},
            success : function(response) {
                location.reload();
            }
        });
    }else{

    }
}
</script>
