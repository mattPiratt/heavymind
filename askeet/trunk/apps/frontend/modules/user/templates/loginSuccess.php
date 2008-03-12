<?php use_helper('Validation', 'Javascript') ?>

<h1>sign in / register</h1>

<div class="in_form">
  <p>Registration is free and required only to create a new question or rate an answer.</p>
</div>

<?php echo form_tag($sf_request->getAttribute('newaccount', false) ? '@add_account' : '@login', 'id=login_form class=form') ?>

  <fieldset>

  <?php echo form_error('nickname') ?>
  <label for="nickname">nickname:</label>
  <?php echo input_tag('nickname', $sf_params->get('nickname')) ?>
  <br class="clearleft"/>

  <?php echo form_error('password') ?>
  <label for="password">password:</label>
  <?php echo input_password_tag('password') ?>&nbsp;<?php echo link_to('forgot your password?', '@user_require_password') ?>
  <br class="clearleft"/>

  <div class="in_form">
  <?php echo checkbox_tag('new', 1, $sf_request->getAttribute('newaccount', false) ? 1 : 0, array('onclick' => 'toggleForm()')) ?>
  &nbsp;<label for="new" style="display: inline; float: none">click here to create a new account</label>
  </div>
  <br class="clearleft"/>

  <div id="new_account"<?php echo $sf_request->getAttribute('newaccount', false) ? '' : ' style="display: none"' ?>>

    <label for="password_bis">confirm your password:</label>
    <?php echo input_password_tag('password_bis') ?>
    <br class="clearleft"/>

    <?php echo form_error('email') ?>
    <label for="email">your email:</label>
    <?php echo input_tag('email', $sf_params->get('email')) ?>
    <br class="clearleft"/>
    <div class="small in_form">askeet will never disclose this address to a third party</div>

  </div>

  </fieldset>

  <?php echo input_hidden_tag('referer', $sf_request->getAttribute('referer')) ?>
  <div class="right">
    <?php echo submit_tag('sign in') ?>
  </div>

</form>

<?php echo javascript_tag("function toggleForm()
{
  if (Element.visible('new_account'))
  {
    Effect.BlindUp('new_account');
    $('login_form').action = '".url_for('@login')."';
  }
  else
  {
    Effect.BlindDown('new_account');
    $('login_form').action = '".url_for('@add_account')."';
  }

  return false;
}") ?>
