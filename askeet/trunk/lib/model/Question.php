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

  public function getTags()
  {
    $c = new Criteria();
    $c->add(QuestionTagPeer::QUESTION_ID, $this->getId());
    $c->addGroupByColumn(QuestionTagPeer::NORMALIZED_TAG);
    $c->setDistinct();
    $c->addAscendingOrderByColumn(QuestionTagPeer::NORMALIZED_TAG);

    $tags = array();
    foreach (QuestionTagPeer::doSelect($c) as $tag)
    {
      if (sfConfig::get('app_permanent_tag') == $tag)
      {
        continue;
      }

      $tags[] = $tag->getNormalizedTag();
    }

    return $tags;
  }

  public function getPopularTags($max = 5)
  {
    $tags = array();

    $con = Propel::getConnection();
    $query = '
      SELECT %s AS tag, COUNT(%s) AS count
      FROM %s
      WHERE %s = ?
      GROUP BY %s
      ORDER BY count DESC
    ';

    $query = sprintf($query,
      QuestionTagPeer::NORMALIZED_TAG,
      QuestionTagPeer::NORMALIZED_TAG,
      QuestionTagPeer::TABLE_NAME,
      QuestionTagPeer::QUESTION_ID,
      QuestionTagPeer::NORMALIZED_TAG
    );

    $stmt = $con->prepareStatement($query);
    $stmt->setInt(1, $this->getId());
    $stmt->setLimit($max);
    $rs = $stmt->executeQuery();
    while ($rs->next())
    {
      $tag = $rs->getString('tag');
      if (sfConfig::get('app_permanent_tag') == $tag)
      {
        continue;
      }

      $tags[$rs->getString('tag')] = $rs->getInt('count');
    }

    return $tags;
  }

  public function addTagsForUser($phrase, $userId)
  {
    // split phrase into individual tags
    $tags = Tag::splitPhrase($phrase.(sfConfig::get('app_permanent_tag') ? ' '.sfConfig::get('app_permanent_tag') : ''));

    // add tags
    foreach ($tags as $tag)
    {
      $questionTag = new QuestionTag();
      $questionTag->setQuestionId($this->getId());
      $questionTag->setUserId($userId);
      $questionTag->setTag($tag);
      try
      {
        $questionTag->save();
      }
      catch (PropelException $e)
      {
        // duplicate tag for this user and question
      }
    }
  }

  public function getPopularAnswers()
  {
    $c = new Criteria();
    $c->add(AnswerPeer::QUESTION_ID, $this->getId());
    $c->addAsColumn('relevancy', AnswerPeer::RELEVANCY_UP.' / ('.AnswerPeer::RELEVANCY_UP.' + '.AnswerPeer::RELEVANCY_DOWN.')');
    $c->addDescendingOrderByColumn('relevancy');

    return AnswerPeer::doSelect($c);
  }
}

?>
