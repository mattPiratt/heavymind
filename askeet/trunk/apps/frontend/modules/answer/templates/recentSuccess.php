<?php use_helper('Date', 'Answer', 'Question') ?>

<h1>recent answers</h1>

<div id="answers">
<?php foreach ($answer_pager->getResults() as $answer): ?>
  <div class="answer">
    <h2><?php echo link_to_question($answer->getQuestion()) ?></h2>
    <?php include_partial('answer/answer', array('answer' => $answer)) ?>
  </div>
<?php endforeach ?>
</div>

<?php if ($answer_pager->haveToPaginate()): ?>
  <div id="answers_pager">

  <?php echo link_to('&laquo;', '@recent_answers?page=1') ?>
  <?php echo link_to('&lt;', '@recent_answers?page='.$answer_pager->getPreviousPage()) ?>

  <?php foreach ($answer_pager->getLinks() as $page): ?>
    <?php echo ($page == $answer_pager->getPage()) ? $page : link_to($page, '@recent_answers?page='.$page) ?>
    <?php echo ($page != $answer_pager->getCurrentMaxLink()) ? '-' : '' ?>
  <?php endforeach ?>

  <?php echo link_to('&gt;', '@recent_answers?page='.$answer_pager->getNextPage()) ?>
  <?php echo link_to('&raquo;', '@recent_answers?page='.$answer_pager->getLastPage()) ?>

  </div>
<?php endif ?>
