<?php use_helper('Date', 'Answer') ?>

<div class="interested_block">
  <?php echo include_partial('interested_user', array('question' => $question)) ?>
</div>
    
<h2><?php echo $question->getTitle() ?></h2>
    
<div class="question_body">
  <?php echo $question->getHtmlBody() ?>
</div>

<?php include_partial('answer/list', array('answer_pager' => $answer_pager)) ?>

<?php if ($answer_pager->haveToPaginate()): ?>
  <div id="answers_pager">

  <?php echo answer_pager_link('&laquo;', $question, 1) ?>
  <?php echo answer_pager_link('&lt;', $question, $answer_pager->getPreviousPage()) ?>

  <?php foreach ($answer_pager->getLinks() as $page): ?>
    <?php echo ($page == $answer_pager->getPage()) ? $page : answer_pager_link($page, $question, $page) ?>
    <?php echo ($page != $answer_pager->getCurrentMaxLink()) ? '-' : '' ?>
  <?php endforeach ?>

  <?php echo answer_pager_link('&gt;', $question, $answer_pager->getNextPage()) ?>
  <?php echo answer_pager_link('&raquo;', $question, $answer_pager->getLastPage()) ?>

  </div>
<?php endif ?>
