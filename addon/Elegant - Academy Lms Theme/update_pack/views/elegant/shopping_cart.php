<div id="cart_items">
  <?php include 'cart_items.php'; ?>
</div>

<script type="text/javascript">
	function applyCoupon() {
        var couponCode = $("#coupon-code").val();
        url3 = '<?php echo site_url('home/refreshShoppingCartItem'); ?>';
        $.ajax({
            url: url3,
            type: 'POST',
            data: {
                couponCode: couponCode
            },
            success: function(response) {
                $('#cart_items').html(response);
            }
        });
    }
</script>
