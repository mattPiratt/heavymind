<?php use_helper('Date') ?>

<div id="answers">
<?php foreach ($answer_pager->getResults() as $answer): ?>
  <div>
	<?php echo include_partial('answer/answer', array('answer'=>$answer)); ?>
  </div>
<?php endforeach ?>
</div>
