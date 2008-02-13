<?php foreach($question_pager->getResults() as $question): ?>
  <div class="question">
    <div class="interested_block">
      <?php include_partial('interested_user', array('question' => $question)) ?>
    </div>
 
    <h2><?php echo link_to($question->getTitle(), 'question/show?stripped_title='.$question->getStrippedTitle()) ?></h2>
 
    <div class="question_body">
      <?php echo truncate_text($question->getBody(), 200) ?>
    </div>
  </div>
<?php endforeach; ?>

<div id="question_pager">
<?php if ($question_pager->haveToPaginate()): ?>
  <?php echo link_to('&laquo;', 'question/list?page=1') ?>
  <?php echo link_to('&lt;', 'question/list?page='.$question_pager->getPreviousPage()) ?>
 
  <?php foreach ($question_pager->getLinks() as $page): ?>
    <?php echo link_to_unless($page == $question_pager->getPage(), $page, 'question/list?page='.$page) ?>
    <?php echo ($page != $question_pager->getCurrentMaxLink()) ? '-' : '' ?>
  <?php endforeach; ?>
 
  <?php echo link_to('&gt;', 'question/list?page='.$question_pager->getNextPage()) ?>
  <?php echo link_to('&raquo;', 'question/list?page='.$question_pager->getLastPage()) ?>
<?php endif; ?>
</div>