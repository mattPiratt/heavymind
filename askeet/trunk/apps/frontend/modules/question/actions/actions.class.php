<?php
// auto-generated by sfPropelCrud
// date: 2008/02/06 21:35:59
?>
<?php

/**
 * question actions.
 *
 * @package		askeet
 * @subpackage question
 * @author		 Your name here
 * @version		SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class questionActions extends sfActions
{
	public function executeList()
	{
		$this->questions = QuestionPeer::doSelect(new Criteria());
	}

	public function executeShow()
	{
		$c = new Criteria();
		$c->add(QuestionPeer::STRIPPED_TITLE, $this->getRequestParameter('stripped_title'));
		$this->question = QuestionPeer::doSelectOne($c);
		$this->forward404Unless($this->question);
	}

}
