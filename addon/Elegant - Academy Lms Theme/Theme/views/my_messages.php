<?php
$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
$my_message_banner = $banners['my_message_banner'];
 ?>
<section id="hero_in" class="general message-section">
	<div class="banner-img" style="background: url(<?php echo base_url($my_message_banner); ?>) center center no-repeat;"></div>
	<div class="wrapper">
		<div class="container">
			<h1 class="fadeInUp"><span></span><?php echo site_phrase('messages'); ?></h1>
		</div>
	</div>
</section>
<!--/hero_in-->
<div class="container margin_120_95">
	<div class="row">
		<div class="col-lg-3 separator">
			<div class="text-center mb-2">
				<button type="button" name="button" class="btn_1 rounded compose-btn" onclick="showNewMessageSection()"> <i class="icon-plus"></i> <?php echo site_phrase('compose'); ?></button>
			</div>
			<ul class="message-sender-list">
				<?php
				$current_user = $this->session->userdata('user_id');
				$this->db->where('sender', $current_user);
				$this->db->or_where('receiver', $current_user);
				$message_threads = $this->db->get('message_thread')->result_array();
				foreach ($message_threads as $row):
					// defining the user to show
					if ($row['sender'] == $current_user)
					$user_to_show_id = $row['receiver'];
					if ($row['receiver'] == $current_user)
					$user_to_show_id = $row['sender'];
					$last_messages_details =  $this->crud_model->get_last_message_by_message_thread_code($row['message_thread_code'])->row_array();?>
					<a href="<?php echo site_url('home/my_messages/read_message/'.$row['message_thread_code']); ?>">
						<?php
							$status = "";
							if (isset($message_thread_code)) {
								if ($row['message_thread_code'] == $message_thread_code) {
									$status = "active";
								}
							}
						 ?>
						<li class="<?php echo $status; ?>">
							<img src="<?php echo $this->user_model->get_user_image_url($user_to_show_id);?>" alt="">
							<?php
								$user_to_show_details = $this->user_model->get_all_user($user_to_show_id)->row_array();
								echo $user_to_show_details['first_name'].' '.$user_to_show_details['last_name'];
							?>
							<small> <i><?php echo date('D, d-M-Y', $last_messages_details['timestamp']); ?></i> </small>
						</li>
					</a>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="col-lg-9">
			<?php include 'inner_messages.php'; ?>
			<?php include 'new_messages.php'; ?>
		</div>
	</div>
</div>

<script type="text/javascript">

</script>
