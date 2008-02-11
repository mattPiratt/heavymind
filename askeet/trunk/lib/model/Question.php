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
}
