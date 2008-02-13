<?php echo form_tag('user/login') ?>
 
  <fieldset>
 
  <div class="form-row">
    <label for="nickname">nickname:</label>
    <?php echo input_tag('nickname', $sf_params->get('nickname')) ?>
  </div>
 
  <div class="form-row">
    <label for="password">password:</label>
    <?php echo input_password_tag('password') ?>
  </div>
 
  </fieldset>
 
  <?php echo input_hidden_tag('referer', $sf_request->getAttribute('referer')) ?>
  <?php echo submit_tag('sign in') ?>
 
</form>