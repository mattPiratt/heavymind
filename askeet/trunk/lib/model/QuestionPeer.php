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
    $c = self::addPermanentTagToCriteria($c);

    $questions = self::doSelectJoinUser($c);

    return $questions ? $questions[0] : null;
  }

  public static function getHomepagePager($page)
  {
    $pager = new sfPropelPager('Question', sfConfig::get('app_pager_homepage_max'));
    $c = new Criteria();
    $c->addDescendingOrderByColumn(self::INTERESTED_USERS);
    $c = self::addPermanentTagToCriteria($c);

    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinUser');
    $pager->init();

    return $pager;
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

  public static function getPopularByTag($tag, $page)
  {
    $c = new Criteria();
    $c->add(QuestionTagPeer::NORMALIZED_TAG, $tag);
    $c->addDescendingOrderByColumn(QuestionPeer::INTERESTED_USERS);
    $c->addJoin(QuestionTagPeer::QUESTION_ID, QuestionPeer::ID, Criteria::LEFT_JOIN);
    $c = self::addPermanentTagToCriteria($c);

    $pager = new sfPropelPager('Question', sfConfig::get('app_pager_homepage_max'));
    $pager->setCriteria($c);
    $pager->setPage($page);
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
