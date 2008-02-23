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
	    $this->getRequest()->getParameterHolder()->set('referer', $this->getRequest()->getReferer());
	 
	    return sfView::SUCCESS;
	  }
	  else
	  {
	    // handle the form submission
	    // redirect to last page
	    return $this->redirect($this->getRequestParameter('referer', '@homepage'));
	  }
	}
	
	public function executeLogout()
	{
		$this->getUser()->signOut();
		$this->redirect('@homepage');
	}
	
	public function handleErrorLogin()
	{
	  return sfView::SUCCESS;
	}

	public function executeShow()
	{
	  $this->subscriber = UserPeer::retrieveByNickname($this->getRequestParameter('nickname'));
	  $this->forward404Unless($this->subscriber);
	 
	  $this->interests = $this->subscriber->getInterestsJoinQuestion();
	  $this->answers   = $this->subscriber->getAnswersJoinQuestion();
	  $this->questions = $this->subscriber->getQuestions();
	}

	public function executeInterested()
	{
	  $this->question = QuestionPeer::retrieveByPk($this->getRequestParameter('id'));
	  $this->forward404Unless($this->question);
	 
	  $user = $this->getUser()->getSubscriber();
	 
	  $interest = new Interest();
	  $interest->setQuestion($this->question);
	  $interest->setUser($user);
	  $interest->save();
	}
}
