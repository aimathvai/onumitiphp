  <div class="row justify-content-center pt-5 pb-5 px-3" style="background-color: #4b4559; overflow-x: hidden;">
      <div class="col-md-6 col-lg-4 mt-5 pt-4 mb-5">
        <h4 class="text-white text-center "><?php echo site_phrase('verify_email_address'); ?></h4>
        <div class="user-dashboard-box mt-3">
            <div class="user-dashboard-content w-100 login-form">
                <div class="content-title-box text-center">
                    <div class="title text-white text-center"><?php echo site_phrase('enter_the_code_from_your_email'); ?></div>
                    <small class=" text-white text-center"><?php echo site_phrase('let_us_know_that_this_email_address_belongs_to_you'); ?> <?php echo site_phrase('Enter_the_code_from_the_email_sent_to').' '.$this->session->userdata('register_email'); ?>.</small>
                </div>
                <form action="javascript:;" method="post" class="mt-3">
                    <div class="content-box">
                        <div class="basic-group">
                            <div class="form-group">
                                <label for="login-email" class="text-white"><?php echo site_phrase('verification_code'); ?>:</label>
                                <input type="text" class="form-control" id = "verification_code" required>
                                <a href="javascript:;" class="text-left p-3" id="resend_mail_button" onclick="resend_verification_code()">
                                  <div class="float-left text-white"><?= site_phrase('resend_mail') ?></div>
                                  <div id="resend_mail_loader" class="float-left pl-2"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="content-update-box w-100">
                        <a href="javascript:;" onclick="continue_verify()" class="btn btn-warning float-right"><?php echo site_phrase('continue'); ?></a>
                    </div>
                </form>
            </div>
        </div>
      </div>
  </div>
<script type="text/javascript">
  function continue_verify() {
    var email = '<?= $this->session->userdata('register_email'); ?>';
    var verification_code = $('#verification_code').val();
    $.ajax({
      type: 'post',
      url: '<?php echo site_url('login/verify_email_address/'); ?>',
      data: {verification_code : verification_code, email : email},
      success: function(response){
        window.location.replace('<?= site_url('home/login'); ?>');
      }
    });
  }
  
  function resend_verification_code() {
    $("#resend_mail_loader").html('<img src="<?= base_url('assets/global/gif/page-loader-3.gif'); ?>" style="width: 25px;">');
    var email = '<?= $this->session->userdata('register_email'); ?>';
    $.ajax({
      type: 'post',
      url: '<?php echo site_url('login/resend_verification_code/'); ?>',
      data: {email : email},
      success: function(response){
        toastr.success('<?php echo site_phrase('mail_successfully_sent_to_your_inbox');?>');
        $("#resend_mail_loader").html('');
      }
    });
  }
</script>
