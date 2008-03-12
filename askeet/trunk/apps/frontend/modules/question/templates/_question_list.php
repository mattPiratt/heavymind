<?php use_helper('Text', 'Global', 'Question', 'Date') ?>

<?php foreach($question_pager->getResults() as $question): ?>
<div class="question">
  <div class="interested_block" id="block_<?php echo $question->getId() ?>">
    <?php echo include_partial('question/interested_user', array('question' => $question)) ?>
  </div>

  <h2><?php echo link_to_question($question) ?></h2>

  <div class="subtitle">asked by <?php echo link_to_profile($question->getUser()) ?> on <?php echo format_date($question->getCreatedAt(), 'f') ?></div>

  <div class="question_body">
    <?php echo truncate_text(strip_tags($question->getHtmlBody()), 200) ?>

    <div class="tags">

    <?php if ($question->getAnswers()): ?>
      <?php echo link_to(count($question->getAnswers()).' answer'.(count($question->getAnswers()) > 1 ? 's' : ''), '@question?stripped_title='.$question->getStrippedTitle()) ?>
    <?php else: ?>
      <?php echo link_to('answer it', '@question?stripped_title='.$question->getStrippedTitle()) ?>
    <?php endif ?>

    &nbsp;-&nbsp;

    <?php if ($question->getTags()): ?>
      tags: <?php echo tags_for_question($question) ?>
    <?php endif ?>

    </div>

  </div>
</div>
<?php endforeach ?>

<div id="question_pager" class="right">
  <?php echo pager_navigation($question_pager, '@popular_questions') ?>
</div>
