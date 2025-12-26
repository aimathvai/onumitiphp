<?php $student_details = $this->user_model->get_all_user($payment['user_id'])->row_array(); ?>
<?php $instructor_details = $this->user_model->get_all_user($ebook['user_id'])->row_array(); ?>

<section id="hero_in" class="ebooks">
    <?php $ebook_banner = 'uploads/system/ebook_page_banner.png'; ?>
    <div class="banner-img" style="background: url(<?php echo base_url($ebook_banner); ?>) center center no-repeat;"></div>
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp"><span></span><?php echo strtoupper(site_phrase('invoice')); ?></h1>
        </div>
    </div>
</section>
<!--/hero_in-->

<section class="purchase-history-list-area">
    <div class="container" id="printableDiv">
        <div class="row print-content">
            <div class="col">
                <div class="ml-auto">
                    <div class="bg-eceff4-p-1-5rem">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <img src="<?php echo base_url('uploads/system/'.get_frontend_settings('dark_logo'));?>" class="d-inline-block" height="40">
                                </td>
                                <td class="text-end text-22 strong"><?php echo strtoupper(site_phrase('invoice')); ?></td>
                            </tr>
                        </table>
                        <table class="w-100">
                            <tr>
                                <td class="strong text-1-2-rem"><?php echo get_settings('system_name'); ?></td>
                                <td class="text-end"></td>
                            </tr>
                            <tr>
                                <td class="gry-color small"><?php echo get_settings('system_email'); ?></td>
                                <td class="text-end"></td>
                            </tr>
                            <tr>
                                <td class="gry-color small"><?php echo get_settings('address'); ?></td>
                                <td class="text-end small"><span class="gry-color small"><?php echo site_phrase('payment_method'); ?>:</span> <span class="strong"><?php echo ucfirst($payment['payment_method']); ?></span></td>
                            </tr>
                            <tr>
                                <td class="gry-color small"><?php echo site_phrase('phone'); ?>: <?php echo get_settings('phone'); ?></td>
                                <td class="text-end small"><span class="gry-color small"><?php echo site_phrase('purchase_date'); ?>:</span> <span class=" strong"><?php echo date('D, d-M-Y', $payment['added_date']); ?></span></td>
                            </tr>
                        </table>

                    </div>

                    <div class="invoice-border"></div>
                    <div class="p-1-5-rem">
                        <table>
                            <tr><td class="strong small gry-color"><?php echo site_phrase('bill_to'); ?>:</td></tr>
                            <tr><td class="strong"><?php echo $student_details['first_name'].' '.$student_details['last_name']; ?></td></tr>
                            <tr><td class="gry-color small"><?php echo site_phrase('email'); ?>: <?php echo $student_details['email']; ?></td></tr>
                        </table>
                    </div>
                    <div>
                        <table class="padding text-left small border-bottom w-100">
                            <thead>
                                <tr class="gry-color bg-eceff4">
                                    <th width="50%"><?php echo site_phrase('ebook'); ?></th>
                                    <th width="15%"><?php echo site_phrase('instructor'); ?></th>
                                    <th width="15%"></th>
                                    <th width="20%" class="text-end"><?php echo site_phrase('total'); ?></th>
                                </tr>
                            </thead>
                            <tbody class="strong">
                                <tr class="">
                                    <td>
                                        <?php echo $ebook['title']; ?>
                                    </td>
                                    <td class="gry-color"><?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?></td>
                                    <td></td>
                                    <td class="text-end"><?php echo currency($payment['paid_amount']); ?></td>
                                </tr>
                                <tr class="border-top">
                                    <td></td>
                                    <td class="gry-color"> <strong><?php echo site_phrase('paid_amount'); ?>:</strong> </td>
                                    <td></td>
                                    <td class="text-end"><strong><?php echo currency($payment['paid_amount']); ?></strong></td>
                                </tr>
                                <tr class="">
                                    <td></td>
                                    <td class="gry-color strong"><strong><?php echo site_phrase('grand_total'); ?></strong>:</td>
                                    <td></td>
                                    <td class="text-end"><strong><?php echo currency($payment['paid_amount']); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-print-none mb-2">
            <a href="javascript:0" onclick="printableDiv('printableDiv')" class="btn btn-info float-end mt-2"> <i class="fas fa-print"></i> <?php echo site_phrase('print'); ?></a>
        </div>
    </div>
</section>

<script type="text/javascript">

  "use strict"

  function printableDiv(printableAreaDivId) {
      var printContents = document.getElementById(printableAreaDivId).innerHTML;
      var originalContents = document.body.innerHTML;

      document.body.innerHTML = printContents;

      window.print();

      document.body.innerHTML = originalContents;
  }
  
</script>
