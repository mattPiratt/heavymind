<?php use_helper('Date', 'Global') ?>
 
<h1>recent answers</h1>
 
<div id="answers">
<?php foreach ($answer_pager->getResults() as $answer): ?>
  <div class="answer">
    <h2><?php echo link_to($answer->getQuestion()->getTitle(), 'question/show?stripped_title='.$answer->getQuestion()->getStrippedTitle()) ?></h2>
    <?php echo count($answer->getRelevancys()) ?> points
    posted by <?php echo link_to($answer->getUser(), 'user/show?id='.$answer->getUser()->getId()) ?> 
    on <?php echo format_date($answer->getCreatedAt(), 'p') ?>
    <div>
      <?php echo $answer->getBody() ?>
    </div>
  </div>
<?php endforeach ?>
</div>        
 
<div id="question_pager">
  <?php echo pager_navigation($answer_pager, 'answer/recent') ?>
</div>