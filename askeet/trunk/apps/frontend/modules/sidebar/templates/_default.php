<?php use_helper('Global') ?>

<div id="add_question">
  <?php echo link_to_login('ask a new question', '@add_question') ?>
</div>

<h2>popular tags</h2>
<?php echo include_partial('tag/tag_cloud', array('tags' => QuestionTagPeer::getPopularTags(20))) ?>
<div class="right" style="padding-top: 5px"><?php echo link_to('more popular tags &raquo;', '@popular_tags') ?></div>

<h2>browse askeet</h2>
<?php echo include_partial('sidebar/rss_links') ?>
