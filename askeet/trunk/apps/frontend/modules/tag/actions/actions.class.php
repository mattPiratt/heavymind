<?php

/**
 * tag actions.
 *
 * @package    askeet
 * @subpackage tag
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class tagActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('default', 'module');
  }

  public function executeShow()
  {
    $this->question_pager = QuestionPeer::getPopularByTag($this->getRequestParameter('tag'), $this->getRequestParameter('page'));
  }

  public function executeAutocomplete()
  {
    $this->tags = QuestionTagPeer::getTagsForUserLike($this->getUser()->getSubscriberId(), $this->getRequestParameter('tag'), 10);
  }

  public function executeAdd()
  {
    $this->question = QuestionPeer::retrieveByPk($this->getRequestParameter('question_id'));
    $this->forward404Unless($this->question);

    $userId = $this->getUser()->getSubscriberId();
    $phrase = $this->getRequestParameter('tag');
    $this->question->addTagsForUser($phrase, $userId);

    $this->tags = $this->question->getTags();
  }

  public function executePopular()
  {
    $this->tags = QuestionTagPeer::getPopularTags(sfConfig::get('app_tag_cloud_max'));
  }
}
