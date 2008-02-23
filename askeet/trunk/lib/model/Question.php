<?php

require_once 'model/om/BaseQuestion.php';


/**
 * Skeleton subclass for representing a row from the 'ask_question' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class Question extends BaseQuestion
{
  public function setTitle($v)
  {
    parent::setTitle($v);

    $this->setStrippedTitle(myTools::stripText($v));
  }

  public function setBody($v)
  {
    parent::setBody($v);

    require_once('markdown.php');

    $this->setHtmlBody(markdown($v));
  }

  public function getAllInterestedUsers()
  {
    $c = new Criteria();
    $c->addJoin(UserPeer::ID, InterestPeer::USER_ID, Criteria::LEFT_JOIN);
    $c->add(InterestPeer::QUESTION_ID, $this->getId());

    return UserPeer::doSelect($c);
  }

  public function getInterestedUsersPager($page)
  {   
    $c = new Criteria();
    $c->addJoin(UserPeer::ID, InterestPeer::USER_ID, Criteria::LEFT_JOIN);
    $c->add(InterestPeer::QUESTION_ID, $this->getId());

    $pager = new sfPager('User', APP_PAGER_USERS_MAX);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }
}

?>