<h1>popular questions for tag '<?php echo $sf_request->getParameter('tag') ?>'</h1>

<?php echo include_partial('question/question_list', array('question_pager' => $question_pager)) ?>
<?php echo pager_navigation($question_pager, '@tag?tag='.$sf_request->getParameter('tag')) ?>
