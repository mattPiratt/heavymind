<?php

/**
 * answer actions.
 *
 * @package    askeet
 * @subpackage answer
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 18 2005-12-06 11:05:10Z fabien $
 */
class answerActions extends sfActions
{
  public function executeRecent()
  {
    $this->answer_pager = AnswerPeer::getRecentPager($this->getRequestParameter('page', 1));
  }
}

?>