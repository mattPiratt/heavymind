<h1>popular questions for tag "<?php echo $sf_params->get('tag') ?>"</h1>
 
<?php include_partial('question/list', array('question_pager' => $question_pager, 'rule' => '@tag?tag='.$sf_params->get('tag'))) ?>