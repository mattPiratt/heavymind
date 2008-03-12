<?php use_helper('Date', 'User') ?>

<div class="vote_block" id="vote_<?php echo $answer->getId() ?>">
  <?php echo include_partial('answer/vote_user', array('answer' => $answer)) ?>
</div>

<div class="answer_body">
  <?php echo $answer->getHtmlBody() ?>
  <div class="subtitle" style="margin-top: -8px">answered by <?php echo link_to_profile($answer->getUser()) ?> on <?php echo format_date($answer->getCreatedAt(), 'f') ?></div>
</div>

<br class="clearleft" />
