<?php

/**
 * Subclass for representing a row from the 'ask_user' table.
 *
 * 
 *
 * @package lib.model
 */ 
class User extends BaseUser {

	public function __toString() {
		return $this->getFirstName().' '.$this->getLastName();
	}

}
