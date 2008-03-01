<?php

/**
 * Subclass for representing a row from the 'ask_question_tag' table.
 *
 *
 *
 * @package lib.model
 */
class QuestionTag extends BaseQuestionTag
{
  public function setTag($v)
  {
    parent::setTag($v);

    $this->setNormalizedTag(Tag::normalize($v));
  }
}
