<?php use_helper('Answer') ?>

<span class="vote_up_mark" id="vote_up_<?php echo $answer->getId() ?>">
  <?php echo $answer->getRelevancyUpPercent() ?>%
</span> <?php echo link_to_user_relevancy_up($sf_user, $answer) ?>

<span class="vote_down_mark" id="vote_down_<?php echo $answer->getId() ?>">
  <?php echo $answer->getRelevancyDownPercent() ?>%
</span> <?php echo link_to_user_relevancy_down($sf_user, $answer) ?>
