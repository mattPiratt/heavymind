<?php

/**
 * question actions.
 *
 * @package    askeet
 * @subpackage question
 * @author     Fabien Potencier
 * @version    SVN: $Id: actions.class.php 18 2005-12-06 11:05:10Z fabien $
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

		$this->answer_pager = AnswerPeer::getPager($this->question->getId(), $this->getRequestParameter('page', 1));
	}

	public function executeRecent()
	{
		$this->question_pager = QuestionPeer::getRecentPager($this->getRequestParameter('page', 1));
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

			return $this->redirect('@question?stripped_title='.$question->getStrippedTitle());
		}
	}

	public function handleErrorAdd()
	{
		return sfView::SUCCESS;
	}
}

?>