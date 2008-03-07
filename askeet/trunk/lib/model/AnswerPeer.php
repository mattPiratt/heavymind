<?php

// include base peer class
require_once 'model/om/BaseAnswerPeer.php';

// include object class
include_once 'model/Answer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'ask_answer' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */
class AnswerPeer extends BaseAnswerPeer
{
  public static function getPager($question_id, $page)
  {
    $pager = new sfPropelPager('Answer', sfConfig::get('app_pager_homepage_max'));
    $c = new Criteria();
    $c->add(self::QUESTION_ID, $question_id);
    $c->addDescendingOrderByColumn(self::RELEVANCY_UP);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c = self::addPermanentTagToCriteria($c);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  public static function getRecentPager($page)
  {
    $pager = new sfPropelPager('Answer', sfConfig::get('app_pager_homepage_max'));
    $c = new Criteria();
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c = self::addPermanentTagToCriteria($c);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinUser');
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