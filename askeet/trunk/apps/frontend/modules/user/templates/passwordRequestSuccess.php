<?php use_helper('Validation') ?>

<h2>Receive your login details by email</h2>
<p>Did you forget your password? Enter your email to receive your login details:</p>
<?php echo form_tag('@user_require_password') ?>
  <?php echo form_error('email') ?>
  <label for="email">email:</label>
  <?php echo input_tag('email', $sf_params->get('email'), 'style=width:150px') ?><br />
  <?php echo submit_tag('Send') ?>
</form>