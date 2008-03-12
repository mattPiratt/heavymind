<ul id="rss_links">
  <li><?php echo link_to('popular questions', '@homepage') ?> <?php echo link_to_rss('popular questions', 'feed/popular') ?></li>
  <li><?php echo link_to('latest questions', '@recent_questions') ?> <?php echo link_to_rss('latest questions', '@feed_recent_questions') ?></li>
  <li><?php echo link_to('latest answers', '@recent_answers') ?> <?php echo link_to_rss('latest answers', '@feed_recent_answers') ?></li>
</ul>
