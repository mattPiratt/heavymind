<?php use_helper('Global') ?>
<?php echo link_to('ask a new question', '@add_question') ?>
 
<ul>
  <li><?php echo link_to('popular questions', '@popular_questions') ?> 
  	<?php echo link_to_feed('popular questions', '@feed_popular_questions') ?></li>
  <li><?php echo link_to('latest questions', '@recent_questions') ?></li>
  <li><?php echo link_to('latest answers', '@recent_answers') ?></li>
</ul>
