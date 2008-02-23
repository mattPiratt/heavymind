<?php

  // include base peer class
  require_once 'model/om/BaseUserPeer.php';
  
  // include object class
  include_once 'model/User.php';


/**
 * Skeleton subclass for performing query and update operations on the 'ask_user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class UserPeer extends BaseUserPeer
{
  public static function getUserFromNickname($nickname)
  {
    $c = new Criteria();
    $c->add(self::NICKNAME, $nickname);

    return self::doSelectOne($c);
  }
}

?>