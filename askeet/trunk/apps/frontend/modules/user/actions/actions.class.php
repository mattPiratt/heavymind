<?php

/**
 * user actions.
 *
 * @package    askeet
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class userActions extends sfActions {

public function executeLogin()
{
  if ($this->getRequest()->getMethod() != sfRequest::POST)
  {
    // display the form
    $this->getRequest()->setAttribute('referer', $this->getRequest()->getReferer());
  }
  else
  {
    // handle the form submission
    $nickname = $this->getRequestParameter('nickname');
 
    $c = new Criteria();
    $c->add(UserPeer::NICKNAME, $nickname);
    $user = UserPeer::doSelectOne($c);
 
    // nickname exists?
    if ($user)
    {
      // password is OK?
      if (true)
      {
        $this->getUser()->setAuthenticated(true);
        $this->getUser()->addCredential('subscriber');
 
        $this->getUser()->setAttribute('subscriber_id', $user->getId(), 'subscriber');
        $this->getUser()->setAttribute('nickname', $user->getNickname(), 'subscriber');
 
        // redirect to last page
        return $this->redirect($this->getRequestParameter('referer', '@homepage'));
      }
    }
  }
}

public function executeLogout()
{
  $this->getUser()->setAuthenticated(false);
  $this->getUser()->clearCredentials();
 
  $this->getUser()->getAttributeHolder()->removeNamespace('subscriber');
 
  $this->redirect('@homepage');
}

}
