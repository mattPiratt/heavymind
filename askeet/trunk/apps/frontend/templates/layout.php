<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-200000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php echo include_http_metas() ?>
<?php echo include_metas() ?>

<?php echo include_title() ?>

<?php echo include_stylesheets() ?>
<?php echo include_javascripts() ?>

<link rel="shortcut icon" href="/favicon.ico">

</head>
<body>

  <?php use_helper('Javascript') ?>

  <div id="indicator" style="display: none"></div>

  <div id="header">
    <ul>
      <?php if ($sf_user->hasAttribute('nickname', 'subscriber')): ?>
        <li><?php echo link_to('sign out', '@logout') ?></li>
        <li><?php echo link_to($sf_user->getAttribute('nickname', '', 'subscriber').' profile', '@current_user_profile') ?></li>
      <?php else: ?>
        <li><?php echo link_to('sign in/register', '@login') ?></li>
      <?php endif ?>
      <li><?php echo link_to('about', 'question/list') ?></li>
    </ul>
    <h1><?php echo link_to(image_tag('askeet_logo.gif', 'alt=askeet'), '@homepage') ?></h1>
  </div>

  <div id="login" style="display: none">
    <h2>Please sign-in first</h2>
    
    <?php echo link_to_function('cancel', visual_effect('blind_up', 'login', array('duration' => 0.5))) ?>
    
    <?php echo form_tag('@login', 'id=loginform') ?>
      nickname: <?php echo input_tag('nickname') ?><br />
      password: <?php echo input_password_tag('password') ?><br />
      <?php echo input_hidden_tag('referer', $sf_params->get('referer') ? $sf_params->get('referer') : $sf_request->getUri()) ?>
      <?php echo submit_tag('login') ?>
    </form>
  </div>

  <div id="content">
    <div id="content_main">
      <?php echo $content ?>
      <div class="verticalalign"></div>
    </div>

    <div id="content_bar">
            <?php include_component_slot('sidebar') ?>
      <div class="verticalalign"></div>
    </div>
  </div>

</body>
</html>