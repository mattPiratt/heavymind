<?php

/**
 * feed actions.
 *
 * @package    askeet
 * @subpackage feed
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class feedActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 */
	public function executeIndex()
	{
		$this->forward('default', 'module');
	}

	public function executePopular()
	{
		// questions
		$c = new Criteria();
		$c->addDescendingOrderByColumn(QuestionPeer::INTERESTED_USERS);
		$c->setLimit(sfConfig::get('app_feed_max'));
		$questions = QuestionPeer::doSelectJoinUser($c);

		$feed = sfFeed::newInstance('rss201rev2');

		// channel
		$feed->setTitle('Popular questions on askeet');
		$feed->setLink('@homepage');
		$feed->setDescription('A list of the most popular questions asked on the askeet site, rated by the community.');

		// items
		$feed->setFeedItemsRouteName('@question');
		$feed->setItems($questions);

		$this->feed = $feed;
	}
}
