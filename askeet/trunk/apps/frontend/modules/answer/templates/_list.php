<?php use_helper('Date') ?>

<div id="answers">
<?php foreach ($answer_pager->getResults() as $answer): ?>
  <div>
    <div class="vote_block" id="vote_<?php echo $answer->getId() ?>">
      <?php echo include_partial('answer/vote_user', array('answer' => $answer)) ?>
    </div>
    posted by <?php echo $answer->getUser() ?>
    on <?php echo format_date($answer->getCreatedAt(), 'p') ?>
    <div>
      <?php echo $answer->getHtmlBody() ?>
    </div>
  </div>
<?php endforeach ?>
</div>
