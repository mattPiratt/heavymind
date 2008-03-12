<?php use_helper('Date', 'Answer') ?>

<h1></h1>

<div class="question">
  <div class="interested_block" id="block_<?php echo $question->getId() ?>">
    <?php echo include_partial('interested_user', array('question' => $question)) ?>
  </div>

  <h2><?php echo $question->getTitle() ?>&nbsp;<?php echo link_to_rss('this question feed', '@feed_question?stripped_title='.$question->getStrippedTitle()) ?></h2>

  <div class="subtitle">asked by <?php echo link_to_profile($question->getUser()) ?> on <?php echo format_date($question->getCreatedAt(), 'f') ?></div>

  <div class="question_body">
    <?php echo $question->getHtmlBody() ?>
  </div>
</div>

<h2>Answers</h2>

<?php include_partial('answer/list', array('question' => $question, 'answers' => $answers)) ?>
