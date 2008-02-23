<?php use_helper('User') ?>
 
<div class="interested_mark" id="mark_<?php echo $question->getId() ?>">
  <?php echo $question->getInterestedUsers() ?>
</div>
 
<?php echo link_to_user_interested($sf_user, $question) ?>