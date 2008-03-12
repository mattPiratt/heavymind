<?php use_helper('Javascript') ?>

<?php if ($sf_user->isAuthenticated()): ?>
  <?php $user_tags = $sf_user->getSubscriber()->getTagsFor($question) ?>
  <ul>
  <?php foreach ($question->getPopularTags(20) as $tag => $count): ?>
    <li>
      <?php if (isset($user_tags[$tag])): ?>
        <?php echo link_to($user_tags[$tag], '@tag?tag='.$tag, 'rel=tag') ?>
        &nbsp;<?php echo link_to_remote('[x]', array(
          'url'      => '@tag_remove?stripped_title='.$question->getStrippedTitle().'&tag='.$tag,
          'update'   => 'question_tags',
          'loading'  => "Element.show('indicator')",
          'complete' => "Element.hide('indicator');".visual_effect('highlight', 'question_tags'),
        )) ?>
      <?php else: ?>
        <?php echo link_to($tag, '@tag?tag='.$tag, 'rel=tag') ?>
      <?php endif ?>
    </li>
  <?php endforeach ?>
  </ul>
<?php else: ?>
  <?php if (!cache('question_tags', 3600)): ?>
    <?php echo include_partial('tag/tag_cloud', array('tags' => QuestionTagPeer::getPopularTagsFor($question))) ?>
    <?php cache_save() ?>
  <?php endif ?>
<?php endif ?>
