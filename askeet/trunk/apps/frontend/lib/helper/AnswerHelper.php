<?php

use_helper('Global');

function answer_pager_link($name, $question, $page)
{
  return link_to($name, '@question?stripped_title='.$question->getStrippedTitle().'&page='.$page);
}

function link_to_user_relevancy_up($user, $answer)
{
  return link_to_user_relevancy('up', $user, $answer);
}

function link_to_user_relevancy_down($user, $answer)
{
  return link_to_user_relevancy('down', $user, $answer);
}

function link_to_user_relevancy($name, $user, $answer)
{
  use_helper('Javascript');

  $img = image_tag('thumb_'.$name.'.gif');

  if ($user->isAuthenticated())
  {
    $has_already_voted = RelevancyPeer::retrieveByPk($answer->getId(), $user->getSubscriberId());
    if ($has_already_voted || $answer->getUserId() == $user->getSubscriberId())
    {
      // already interested
      return $img;
    }
    else
    {
      // didn't declare interest yet
      return link_to_remote($img, array(
        'url'      => 'user/vote?id='.$answer->getId().'&score='.($name == 'up' ? 1 : -1),
        'update'   => array('success' => 'vote_'.$answer->getId()),
        'loading'  => "Element.show('indicator')",
        'complete' => "Element.hide('indicator');".visual_effect('highlight', 'vote_'.$name.'_'.$answer->getId()),
      ));
    }
  }
  else
  {
    return link_to_login($img);
  }
}

?>