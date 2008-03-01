<?php
function tags_for_question($question, $max = 5)
{
  $tags = array();

  foreach ($question->getPopularTags($max) as $tag => $count)
  {
    $tags[] = link_to($tag, '@tag?tag='.$tag);
  }

  return implode(' + ', $tags);
}
?>