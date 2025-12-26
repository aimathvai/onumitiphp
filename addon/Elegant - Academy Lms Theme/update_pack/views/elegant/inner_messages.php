<div class="inner-message-section">
  <?php if (!isset($message_thread_code)): ?>
      <div class="empty-convo">
          <img src="<?php echo base_url('assets/frontend/elegant/images/message.png'); ?>" alt=""><br>
          <?php echo site_phrase('select_a_message_thread_to_read_it_here'); ?>.
      </div>
  <?php else: ?>
      <?php
      if (isset($message_thread_code)):
          $message_thread_details = $this->db->get_where('message_thread', array('message_thread_code' => $message_thread_code))->row_array();
          if ($this->session->userdata('user_id') == $message_thread_details['sender']){
              $user_to_show_id = $message_thread_details['receiver'];
          }
          else{
              $user_to_show_id = $message_thread_details['sender'];
          }
          $user_to_show_details = $this->user_model->get_all_user($user_to_show_id)->row_array();
          $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();?>
          <div class="message-content">
              <?php foreach ($messages as $message): ?>
                  <?php if ($message['sender'] == $this->session->userdata('user_id')): ?>
                      <div class="message-box-wrap-me">
                          <span class="message-box">
                              <span class="messages"><?php echo $message['message']; ?></span>
                              <span class="time"> <i><?php echo date('d-M-Y', $message['timestamp']); ?></i> </span>
                          </span>
                      </div>
                  <?php else: ?>
                      <div class="message-box-wrap-other">
                          <span class="message-sender-image">
                              <img src="<?php echo $this->user_model->get_user_image_url($message['sender']);?>" alt="">
                          </span>
                          <span class="message-box">
                              <span class="messages"><?php echo $message['message']; ?></span>
                              <span class="time"> <i><?php echo date('d-M-Y', $message['timestamp']); ?></i> </span>
                          </span>
                      </div>
                  <?php endif; ?>
              <?php endforeach; ?>
          </div>
      <?php endif; ?>
      <form class="" action="<?php echo site_url('home/my_messages/send_reply/'.$message_thread_code); ?>" method="post">
          <span class="input">
              <textarea name="message" class="input_field" rows="2"></textarea>
              <label class="input_label">
                  <span class="input__label-content"><?php echo site_phrase('write_your_message').'....'; ?></span>
              </label>
          </span>
          <div class="row justify-content-center">
              <button type="submit" class="btn_1 rounded" name="button"><?php echo site_phrase('send_message'); ?></button>
          </div>
      </form>
  <?php endif; ?>
</div>
