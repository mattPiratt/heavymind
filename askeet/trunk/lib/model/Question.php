<?php

/**
 * Subclass for representing a row from the 'ask_question' table.
 *
 *
 *
 * @package lib.model
 */
class Question extends BaseQuestion {

	public function setTitle($v) {
		parent::setTitle($v);
		$this->setStrippedTitle( myTools::stripText( $v ) );
	}

	public function setBody($v)
	{
		parent::setBody($v);

		require_once('markdown.php');

		// strip all HTML tags
		$v = htmlentities($v, ENT_QUOTES, 'UTF-8');

		$this->setHtmlBody(markdown($v));
	}
}
