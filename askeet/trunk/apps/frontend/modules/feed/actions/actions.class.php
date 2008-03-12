<?php

/**
 * feed actions.
 *
 * @package    askeet
 * @subpackage feed
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 40 2005-12-16 09:09:27Z fabien $
 */
class feedActions extends sfActions
{
  public function preExecute()
  {
    $this->getRequest()->setAttribute('disable_web_debug', true, 'debug/web');
  }

  public function executePopular()
  {
    // questions
    $questions = QuestionPeer::getPopular(sfConfig::get('app_feed_max'));

    $feed = sfFeed::newInstance('rss201rev2');

    // channel
    $feed->setTitle('Popular questions on askeet');
    $feed->setLink('@homepage');
    $feed->setFeedUrl('feed/popular');
    $feed->setDescription('A list of the most popular questions asked on the askeet site, rated by the community.');

    // items
    $feed->setFeedItemsRouteName('@question');
    $feed->setItems($questions);

    $this->feed = $feed;
  }

  public function executeRecent()
  {
    // questions
    $questions = QuestionPeer::getRecent(sfConfig::get('app_feed_max'));

    $feed = sfFeed::newInstance('rss201rev2');

    // channel
    $feed->setTitle('Recent questions on askeet');
    $feed->setLink('@recent_questions');
    $feed->setFeedUrl('@feed_recent_questions');
    $feed->setDescription('A list of the most recent questions asked on the askeet site.');

    // items
    $feed->setFeedItemsRouteName('@question');
    $feed->setItems($questions);

    $this->feed = $feed;
  }

  public function executeRecentAnswers()
  {
    // questions
    $answers = AnswerPeer::getRecent(sfConfig::get('app_feed_max'));

    $feed = sfFeed::newInstance('rss201rev2');

    // channel
    $feed->setTitle('Recent answers on askeet');
    $feed->setLink('@recent_answers');
    $feed->setFeedUrl('@feed_recent_answers');
    $feed->setDescription('A list of the most recent question answers on the askeet site.');

    // items
    $feed->setFeedItemsRouteName('@recent_answers');
    $feed->setItems($answers);

    $this->feed = $feed;
  }

  public function executeQuestion()
  {
    $question = QuestionPeer::getQuestionFromTitle($this->getRequestParameter('stripped_title'));
    $this->forward404Unless($question);

    // answers
    $c = new Criteria();
    $c->add(AnswerPeer::QUESTION_ID, $question->getId());
    $c->addDescendingOrderByColumn(AnswerPeer::CREATED_AT);
    $c->setLimit(sfConfig::get('app_feed_max'));
    $answers = AnswerPeer::doSelect($c);

    $feed = sfFeed::newInstance('rss201rev2');

    // channel
    $feed->setTitle($question->getTitle().' feed');
    $feed->setLink('@question?stripped_title='.$question->getStrippedTitle());
    $feed->setFeedUrl('@feed_question?stripped_title='.$question->getStrippedTitle());
    $feed->setDescription('Latest answers to the question: '.$question->getTitle());

    // items
    $feed->setItems($answers);

    $this->feed = $feed;
  }
}

?>