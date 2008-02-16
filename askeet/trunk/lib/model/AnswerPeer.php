<?php

/**
 * Subclass for performing query and update operations on the 'ask_answer' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AnswerPeer extends BaseAnswerPeer
{

	public static function getRecentPager($page)
	{
	  $pager = new sfPropelPager('Answer', sfConfig::get('app_pager_homepage_max'));
	  $c = new Criteria();
	  $c->addDescendingOrderByColumn(self::CREATED_AT);
	  $pager->setCriteria($c);
	  $pager->setPage($page);
	  $pager->setPeerMethod('doSelectJoinUser');
	  $pager->init();
	 
	  return $pager;
	}

}
