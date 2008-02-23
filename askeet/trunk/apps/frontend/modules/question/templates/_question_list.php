<?php use_helper('Text', 'Global') ?>

<?php foreach($question_pager->getResults() as $question): ?>
  <div class="interested_block" id="block_<?php echo $question->getId() ?>">
    <?php echo include_partial('interested_user', array('question' => $question)) ?>
  </div>

  <h2><?php echo link_to($question->getTitle(), '@question?stripped_title='.$question->getStrippedTitle()) ?></h2>

  <div class="question_body">
    <?php echo truncate_text(strip_tags($question->getHtmlBody()), 200) ?>
  </div>
<?php endforeach ?>

<div id="question_pager">
<?php echo pager_navigation($question_pager, '@popular_questions') ?>
</div>
