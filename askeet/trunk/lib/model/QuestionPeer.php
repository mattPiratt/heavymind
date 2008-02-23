<?php

/**
 * Subclass for performing query and update operations on the 'ask_question' table.
 *
 *
 *
 * @package lib.model
 */
class QuestionPeer extends BaseQuestionPeer {

	public static function getHomepagePager($page)
	{
		$pager = new sfPropelPager('Question', sfConfig::get('app_pager_homepage_max'));
		$c = new Criteria();
		$c->addDescendingOrderByColumn(self::INTERESTED_USERS);
		$pager->setCriteria($c);
		$pager->setPage($page);
		$pager->setPeerMethod('doSelectJoinUser');
		$pager->init();

		return $pager;
	}

	public static function getQuestionFromTitle($title)
	{
		$c = new Criteria();
		$c->add(QuestionPeer::STRIPPED_TITLE, $title);

		return self::doSelectOne($c);
	}

	public static function getRecentPager($page)
	{
		$pager = new sfPropelPager('Question', sfConfig::get('app_pager_homepage_max'));
		$c = new Criteria();
		$c->addDescendingOrderByColumn(self::CREATED_AT);
		$pager->setCriteria($c);
		$pager->setPage($page);
		$pager->setPeerMethod('doSelectJoinUser');
		$pager->init();

		return $pager;
	}
}
