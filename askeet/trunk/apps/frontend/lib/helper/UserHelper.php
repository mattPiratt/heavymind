<?php
 
use_helper('Javascript');
 
function link_to_user_interested($user, $question)
{
  if ($user->isAuthenticated())
  {
    $interested = InterestPeer::retrieveByPk($question->getId(), $user->getSubscriberId());
    if ($interested)
    {
      // already interested
      return 'interested!';
    }
    else
    {
      // didn't declare interest yet
      return link_to_remote('interested?', array(
        'url'      => 'user/interested?id='.$question->getId(),
        'update'   => array('success' => 'block_'.$question->getId()),
        'loading'  => "Element.show('indicator')",
        'complete' => "Element.hide('indicator');".visual_effect('highlight', 'mark_'.$question->getId()),
      ));
    }
  }
  else
  {
    return link_to_function('interested?', visual_effect('blind_down', 'login', array('duration' => 0.5)));
  }
}
?>