<?php use_helper('Date') ?>

<div class="interested_block">
  <?php include_partial('interested_user', array('question' => $question)) ?>
</div>

<h2><?php echo $question->getTitle() ?></h2>

<div class="question_body">
  <?php echo $question->getHtmlBody() ?>
</div>

<div id="answers">
<?php foreach ($question->getAnswers() as $answer): ?>
  <div class="answer">
    <?php echo $answer->getRelevancyUpPercent() ?>% UP <?php echo $answer->getRelevancyDownPercent() ?> % DOWN
    posted by <?php echo link_to($question->getUser(), 'user/show?nickname='.$question->getUser()->getNickname()) ?> 
    on <?php echo format_date($answer->getCreatedAt(), 'p') ?>
    <div>
      <?php echo $answer->getBody() ?>
    </div>
  </div>
<?php endforeach; ?>
</div>