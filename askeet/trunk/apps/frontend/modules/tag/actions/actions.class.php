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
}
