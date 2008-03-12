<?php

  // include base peer class
  require_once 'model/om/BaseQuestionTagPeer.php';
  
  // include object class
  include_once 'model/QuestionTag.php';


/**
 * Skeleton subclass for performing query and update operations on the 'ask_question_tag' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class QuestionTagPeer extends BaseQuestionTagPeer
{
  public static function getPopularTags($max = 5)
  {
    $tags = array();

    $con = Propel::getConnection();
    $query = '
      SELECT t1.normalized_tag AS tag,
      COUNT(t1.normalized_tag) AS count
      FROM '.QuestionTagPeer::TABLE_NAME.' AS t1';

    if (defined('APP_PERMANENT_TAG'))
    {
      $query .= '
        INNER JOIN '.QuestionTagPeer::TABLE_NAME.' AS t2 ON t1.question_id = t2.question_id
        WHERE t2.normalized_tag = ? AND t1.normalized_tag != ?
      ';
    }

    $query .= '
      GROUP BY t1.normalized_tag
      ORDER BY count DESC
    ';

    $stmt = $con->prepareStatement($query);
    if (defined('APP_PERMANENT_TAG'))
    {
      $stmt->setString(1, APP_PERMANENT_TAG);
      $stmt->setString(2, APP_PERMANENT_TAG);
    }
    $stmt->setLimit($max);
    $rs = $stmt->executeQuery();
    $max_popularity = 0;
    while ($rs->next())
    {
      if (!$max_popularity)
      {
        $max_popularity = $rs->getInt('count');
      }

      $tags[$rs->getString('tag')] = floor(($rs->getInt('count') / $max_popularity * 3) + 1);
    }

    ksort($tags);

    return $tags;
  }

  public static function getPopularTagsFor($question, $max = 10)
  {
    $tags = array();

    $con = Propel::getConnection();

    // get popular tags
    $query = '
      SELECT '.QuestionTagPeer::NORMALIZED_TAG.' AS tag, COUNT('.QuestionTagPeer::NORMALIZED_TAG.') AS count
      FROM '.QuestionTagPeer::TABLE_NAME;
    if ($question !== null)
    {
      $query .= '  WHERE '.QuestionTagPeer::QUESTION_ID.' = ?';
    }
    $query .= '
      GROUP BY '.QuestionTagPeer::NORMALIZED_TAG.'
      ORDER BY count DESC
    ';

    $stmt = $con->prepareStatement($query);
    if ($question !== null)
    {
      $stmt->setInt(1, $question->getId());
    }
    $stmt->setLimit($max);
    $rs = $stmt->executeQuery();
    $max_popularity = 0;
    while ($rs->next())
    {
      if (defined('APP_PERMANENT_TAG') && APP_PERMANENT_TAG == $rs->getString('tag'))
      {
        continue;
      }

      if (!$max_popularity)
      {
        $max_popularity = $rs->getInt('count');
      }

      $tags[$rs->getString('tag')] = floor(($rs->getInt('count') / $max_popularity * 3) + 1);
    }

    ksort($tags);

    return $tags;
  }

  public static function getForUserLike($user_id, $tag)
  {
    $tags = array();

    $con = Propel::getConnection();
    $query = '
      SELECT DISTINCT %s AS tag
      FROM %s
      WHERE %s = ? AND %s LIKE ?
      ORDER BY %s
    ';

    $query = sprintf($query,
      QuestionTagPeer::TAG,
      QuestionTagPeer::TABLE_NAME,
      QuestionTagPeer::USER_ID,
      QuestionTagPeer::TAG,
      QuestionTagPeer::TAG
    );

    $stmt = $con->prepareStatement($query);
    $stmt->setInt(1, $user_id);
    $stmt->setString(2, $tag.'%');
    $stmt->setLimit(10);
    $rs = $stmt->executeQuery();
    while ($rs->next())
    {
      $tags[] = $rs->getString('tag');
    }

    return $tags;
  }
}

?>