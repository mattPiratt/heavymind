<?php

  // include base peer class
  require_once 'model/om/BaseQuestionPeer.php';
  
  // include object class
  include_once 'model/Question.php';


/**
 * Skeleton subclass for performing query and update operations on the 'ask_question' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class QuestionPeer extends BaseQuestionPeer
{
  public static function getQuestionFromTitle($title)
  {
    $c = new Criteria();
    $c->add(self::STRIPPED_TITLE, $title);

    $questions = self::doSelectJoinUser($c);

    return $questions ? $questions[0] : null;
  }

  public static function getHomepagePager($page)
  {
    $pager = new sfPropelPager('Question', sfConfig::get('app_pager_homepage_max'));
    $c = new Criteria();
    $c->addDescendingOrderByColumn(self::INTERESTED_USERS);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c = self::addPermanentTagToCriteria($c);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinUser');
    $pager->init();

    return $pager;
  }

  public static function getPopular($max = 10)
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(self::INTERESTED_USERS);
    $c = self::addPermanentTagToCriteria($c);
    $c->setLimit($max);

    return self::doSelectJoinUser($c);
  }

  public static function getRecentPager($page)
  {
    $pager = new sfPropelPager('Question', sfConfig::get('app_pager_homepage_max'));
    $c = new Criteria();
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c = self::addPermanentTagToCriteria($c);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinUser');
    $pager->init();

    return $pager;
  }

  public static function getRecent($max = 10)
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c = self::addPermanentTagToCriteria($c);
    $c->setLimit($max);

    return self::doSelectJoinUser($c);
  }

  public static function getPopularByTag($tag, $page)
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(QuestionPeer::INTERESTED_USERS);

    // tags
    $c->addJoin(self::ID, QuestionTagPeer::QUESTION_ID, Criteria::LEFT_JOIN);
    $criterion = $c->getNewCriterion(QuestionTagPeer::NORMALIZED_TAG, $tag);
    if (defined('APP_PERMANENT_TAG'))
    {
      $criterion->addAnd($c->getNewCriterion(QuestionTagPeer::NORMALIZED_TAG, APP_PERMANENT_TAG));
    }
    $c->add($criterion);
    $c->setDistinct();

    $pager = new sfPropelPager('Question', 20);
    $pager->setCriteria($c);
    $pager = new sfPropelPager('Question', sfConfig::get('app_pager_homepage_max'));
    $pager->init();

    return $pager;
  }

  private static function addPermanentTagToCriteria($criteria)
  {
    if (sfConfig::get('app_permanent_tag'))
    {
      $criteria->addJoin(self::ID, QuestionTagPeer::QUESTION_ID, Criteria::LEFT_JOIN);
      $criteria->add(QuestionTagPeer::NORMALIZED_TAG, sfConfig::get('app_permanent_tag'));
      $criteria->setDistinct();
    }

    return $criteria;
  }
}

?>
