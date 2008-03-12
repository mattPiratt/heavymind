<h1>Receive your login details by email</h1>

<div class="in_form">
  <p>Did you forget your password?
  <br />Enter your email no receive your login details:</p>
</div>

<?php echo form_tag('@user_require_password', 'class=form') ?>
  <?php echo form_error('email') ?>
  <label for="email">email:</label>
  <?php echo input_tag('email', $sf_params->get('email'), 'style=width:150px') ?>
  <br class="clearleft" />

  <div class="right">
    <?php echo submit_tag('send it') ?>
  </div>
</form>
