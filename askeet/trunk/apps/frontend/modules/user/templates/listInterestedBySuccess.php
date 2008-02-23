<?php use_helper('Date', 'Global') ?>

<h2><?php echo $question->getTitle() ?></h2>
<p>asked by <strong><?php echo $question->getUser() ?></strong> <?php echo time_ago_in_words($question->getCreatedAt('U')) ?> ago</p>
 
<?php echo $interested_users_pager->getNbResults() ?> askeet users are interested by this question
<ul>
  <?php foreach ($interested_users_pager->getResults() as $interested_user): ?>
  <li><?php echo link_to($interested_user->__toString(), '@user_profile?nickname='.$interested_user->getNickname()) ?></li>
  <?php endforeach ?>
</ul>

<div id="users_pager">
  <?php echo pager_navigation($interested_users_pager, '@user_interests?stripped_title='.$request->getParameter('stripped_title
')) ?>
</div>
