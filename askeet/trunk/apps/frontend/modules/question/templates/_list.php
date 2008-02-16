<?php use_helper('Text', 'Global', 'Date') ?>

<?php foreach($question_pager->getResults() as $question): ?>
  <div class="question">
    	<div>
    		<br/><br/>
    		asked by <?php echo link_to($question->getUser(), 'user/show?id='
    		.$question->getUser()->getId()) ?>
    		on <?php echo format_date($question->getCreatedAt(), 'f') ?>
    	</div>
    <div class="interested_block">
 
      <?php include_partial('interested_user', array('question' => $question)) ?>
    </div>
 
    <h2><?php echo link_to($question->getTitle(), 'question/show?stripped_title='
      .$question->getStrippedTitle()) ?></h2>
 
    <div class="question_body">
      <?php echo truncate_text($question->getBody(), 200) ?>
    </div>
  </div>
<?php endforeach; ?>

<div id="question_pager">
 <?php echo pager_navigation($question_pager, $rule) ?>
</div>