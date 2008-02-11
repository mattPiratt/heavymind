<?php

/**
 * Subclass for representing a row from the 'ask_interest' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Interest extends BaseInterest {

	public function save($con = null)
	{
		$con = Propel::getConnection();
		try {
			$con->begin();
	
			$ret = parent::save($con);
	
			// update interested_users in question table
			$question = $this->getQuestion();
			$interested_users = $question->getInterestedUsers();
			$question->setInterestedUsers($interested_users + 1);
			$question->save($con);
			 
			$con->commit();
			 
			return $ret;
		} catch (Exception $e) {
			$con->rollback();
			throw $e;
		}
	}
}
?>