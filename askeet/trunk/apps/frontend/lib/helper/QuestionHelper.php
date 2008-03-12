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

function link_to_question($question)
{
  return link_to($question->getTitle(), '@question?stripped_title='.$question->getStrippedTitle());
}

?>