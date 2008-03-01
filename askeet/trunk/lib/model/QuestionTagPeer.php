<?php

/**
 * Subclass for performing query and update operations on the 'ask_question_tag' table.
 *
 *
 *
 * @package lib.model
 */
class QuestionTagPeer extends BaseQuestionTagPeer
{
  public static function getTagsForUserLike($user_id, $tag, $max = 10)
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
    $stmt->setLimit($max);
    $rs = $stmt->executeQuery();
    while ($rs->next())
    {
      $tags[] = $rs->getString('tag');
    }

    return $tags;
  }
  public static function getPopularTags($max = 5)
  {
    $tags = array();

    $con = Propel::getConnection();
    $query = '
    SELECT '.QuestionTagPeer::NORMALIZED_TAG.' AS tag,
    COUNT('.QuestionTagPeer::NORMALIZED_TAG.') AS count
    FROM '.QuestionTagPeer::TABLE_NAME.'
    GROUP BY '.QuestionTagPeer::NORMALIZED_TAG.'
    ORDER BY count DESC';

    $stmt = $con->prepareStatement($query);
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
}
