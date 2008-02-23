<?php

/**
 * Subclass for performing query and update operations on the 'ask_user' table.
 *
 *
 *
 * @package lib.model
 */
class UserPeer extends BaseUserPeer {

	public static function retrieveByNickname($nickname)
	{
		$c = new Criteria();
		$c->add(self::NICKNAME, $nickname);

		return self::doSelectOne($c);
	}
}
