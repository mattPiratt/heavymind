<?php

class sidebarComponents extends sfComponents
{
  public function executeDefault()
  {
  }

  public function executeQuestion()
  {
    $this->question = QuestionPeer::getQuestionFromTitle($this->getRequestParameter('stripped_title'));
  }
}