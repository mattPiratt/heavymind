<?php

/**
 * user actions.
 *
 * @package    askeet
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23 2005-12-08 09:47:03Z fabien $
 */
class userActions extends sfActions
{
  public function executeListInterestedBy()
  {
    $this->question = QuestionPeer::getQuestionFromTitle($this->getRequestParameter('stripped_title'));
    $this->forward404Unless($this->question instanceof Question);

    $page = $this->getRequestParameter('page', 1);

    $this->interested_users_pager = $this->question->getInterestedUsersPager($page);
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

  public function executeVote()
  {
    $this->answer = AnswerPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->answer);

    $user = $this->getUser()->getSubscriber();

    $relevancy = new Relevancy();
    $relevancy->setAnswer($this->answer);
    $relevancy->setUser($user);
    $relevancy->setScore($this->getRequestParameter('score') == 1 ? 1 : -1);
    $relevancy->save();
  }

  public function executeShow()
  {
    if ($this->hasRequestParameter('nickname'))
    {
      $this->subscriber = UserPeer::getUserFromNickname($this->getRequestParameter('nickname'));
    }
    else
    {
      $this->subscriber = UserPeer::retrieveByPk($this->getUser()->getSubscriberId());
    }
    $this->forward404Unless($this->subscriber);

    $this->interests = $this->subscriber->getInterestsJoinQuestion();
    $this->answers   = $this->subscriber->getAnswersJoinQuestion();
    $this->questions = $this->subscriber->getQuestions();
  }

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
}

?>