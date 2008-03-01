<?php include_partial('sidebar/default') ?>
 
<h2>question tags</h2>
 
<ul id="question_tags">
  <?php include_partial('tag/question_tags', array('question' => $question, 'tags' => $question->getTags())) ?> 
</ul>
 