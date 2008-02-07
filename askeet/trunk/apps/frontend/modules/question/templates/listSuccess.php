<?php use_helper('Text') ?>
 
<h1>popular questions</h1> 
 
<?php foreach($questions as $question): ?>
  <div class="question">
    <div class="interested_block">
      <div class="interested_mark" id="interested_in_<?php echo $question->getId() ?>">
        <?php echo count($question->getInterests()) ?>
      </div>
    </div>
 
    <h2><?php echo link_to($question->getTitle(), 'question/show?id='.$question->getId()) ?></h2>
 
    <div class="question_body">
      <?php echo truncate_text($question->getBody(), 200) ?>
    </div>
  </div>
<?php endforeach; ?>