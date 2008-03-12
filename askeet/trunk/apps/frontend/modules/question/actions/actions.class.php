<?php

/**
 * question actions.
 *
 * @package    askeet
 * @subpackage question
 * @author     Fabien Potencier
 * @version    SVN: $Id: actions.class.php 40 2005-12-16 09:09:27Z fabien $
 */
class questionActions extends sfActions
{
  public function executeList ()
  {
    $this->question_pager = QuestionPeer::getHomepagePager($this->getRequestParameter('page', 1));
  }

  public function executeShow()
  {
    $this->question = QuestionPeer::getQuestionFromTitle($this->getRequestParameter('stripped_title'));
    $this->forward404Unless($this->question);

    $this->answers = $this->question->getPopularAnswers();

  }

  public function executeRecent()
  {
    $this->question_pager = QuestionPeer::getRecentPager($this->getRequestParameter('page', 1));

    $this->getResponse()->setTitle('askeet! &raquo; recent questions');
  }

  public function executeAdd()
  {
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      // create question
      $user = $this->getUser()->getSubscriber();

      $question = new Question();
      $question->setTitle($this->getRequestParameter('title'));
      $question->setBody($this->getRequestParameter('body'));
      $question->setUser($user);
      $question->save();

      $user->isInterestedIn($question);

      $question->addTagsForUser($this->getRequestParameter('tag'), $user->getId());

      return $this->redirect('@question?stripped_title='.$question->getStrippedTitle());
    }
  }

  public function handleErrorAdd()
  {
    return sfView::SUCCESS;
  }
}

?>