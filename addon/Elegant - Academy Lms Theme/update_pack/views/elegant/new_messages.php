<div class="new-message-section">
    <?php
        $instructor_list = $this->user_model->get_instructor_list()->result_array();
    ?>
    <form class="" action="<?php echo site_url('home/my_messages/send_new'); ?>" method="post">
        <span class="input">
            <select class="form-control select2" name = "receiver">
                <option value=""><?php echo site_phrase('select_an_instructor'); ?></option>
                <?php foreach ($instructor_list as $instructor):
                    if ($instructor['id'] == $this->session->userdata('user_id'))
                        continue;
                    ?>
                    <option value="<?php echo $instructor['id']; ?>"><?php echo $instructor['first_name'].' '.$instructor['last_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </span>
        <span class="input">
            <textarea name="message" class="input_field" rows="2"></textarea>
            <label class="input_label">
                <span class="input__label-content"><?php echo site_phrase('write_your_message').'....'; ?></span>
            </label>
        </span>
        <div class="row justify-content-center">
            <button type="submit" class="btn_1 rounded" name="button"><?php echo site_phrase('send_message'); ?></button>
            <button type="button" class="btn_1 rounded cancel-btn" name="button" onclick="cancelNewMessage()"><?php echo site_phrase('cancel'); ?></button>
        </div>
    </form>
</div>
