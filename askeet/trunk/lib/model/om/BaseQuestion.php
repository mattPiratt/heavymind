<?php


abstract class BaseQuestion extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $user_id;


	
	protected $title;


	
	protected $stripped_title;


	
	protected $body;


	
	protected $html_body;


	
	protected $interested_users = 0;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aUser;

	
	protected $collAnswers;

	
	protected $lastAnswerCriteria = null;

	
	protected $collInterests;

	
	protected $lastInterestCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getStrippedTitle()
	{

		return $this->stripped_title;
	}

	
	public function getBody()
	{

		return $this->body;
	}

	
	public function getHtmlBody()
	{

		return $this->html_body;
	}

	
	public function getInterestedUsers()
	{

		return $this->interested_users;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
						$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = QuestionPeer::ID;
		}

	} 
	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = QuestionPeer::USER_ID;
		}

		if ($this->aUser !== null && $this->aUser->getId() !== $v) {
			$this->aUser = null;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = QuestionPeer::TITLE;
		}

	} 
	
	public function setStrippedTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->stripped_title !== $v) {
			$this->stripped_title = $v;
			$this->modifiedColumns[] = QuestionPeer::STRIPPED_TITLE;
		}

	} 
	
	public function setBody($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->body !== $v) {
			$this->body = $v;
			$this->modifiedColumns[] = QuestionPeer::BODY;
		}

	} 
	
	public function setHtmlBody($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->html_body !== $v) {
			$this->html_body = $v;
			$this->modifiedColumns[] = QuestionPeer::HTML_BODY;
		}

	} 
	
	public function setInterestedUsers($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->interested_users !== $v || $v === 0) {
			$this->interested_users = $v;
			$this->modifiedColumns[] = QuestionPeer::INTERESTED_USERS;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = QuestionPeer::CREATED_AT;
		}

	} 
	
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = QuestionPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->user_id = $rs->getInt($startcol + 1);

			$this->title = $rs->getString($startcol + 2);

			$this->stripped_title = $rs->getString($startcol + 3);

			$this->body = $rs->getString($startcol + 4);

			$this->html_body = $rs->getString($startcol + 5);

			$this->interested_users = $rs->getInt($startcol + 6);

			$this->created_at = $rs->getTimestamp($startcol + 7, null);

			$this->updated_at = $rs->getTimestamp($startcol + 8, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 9; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Question object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			QuestionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(QuestionPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(QuestionPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


												
			if ($this->aUser !== null) {
				if ($this->aUser->isModified()) {
					$affectedRows += $this->aUser->save($con);
				}
				$this->setUser($this->aUser);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = QuestionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += QuestionPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collAnswers !== null) {
				foreach($this->collAnswers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collInterests !== null) {
				foreach($this->collInterests as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}


			if (($retval = QuestionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collAnswers !== null) {
					foreach($this->collAnswers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collInterests !== null) {
					foreach($this->collInterests as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = QuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUserId();
				break;
			case 2:
				return $this->getTitle();
				break;
			case 3:
				return $this->getStrippedTitle();
				break;
			case 4:
				return $this->getBody();
				break;
			case 5:
				return $this->getHtmlBody();
				break;
			case 6:
				return $this->getInterestedUsers();
				break;
			case 7:
				return $this->getCreatedAt();
				break;
			case 8:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = QuestionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getStrippedTitle(),
			$keys[4] => $this->getBody(),
			$keys[5] => $this->getHtmlBody(),
			$keys[6] => $this->getInterestedUsers(),
			$keys[7] => $this->getCreatedAt(),
			$keys[8] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = QuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUserId($value);
				break;
			case 2:
				$this->setTitle($value);
				break;
			case 3:
				$this->setStrippedTitle($value);
				break;
			case 4:
				$this->setBody($value);
				break;
			case 5:
				$this->setHtmlBody($value);
				break;
			case 6:
				$this->setInterestedUsers($value);
				break;
			case 7:
				$this->setCreatedAt($value);
				break;
			case 8:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = QuestionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setStrippedTitle($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setBody($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setHtmlBody($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setInterestedUsers($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUpdatedAt($arr[$keys[8]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(QuestionPeer::DATABASE_NAME);

		if ($this->isColumnModified(QuestionPeer::ID)) $criteria->add(QuestionPeer::ID, $this->id);
		if ($this->isColumnModified(QuestionPeer::USER_ID)) $criteria->add(QuestionPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(QuestionPeer::TITLE)) $criteria->add(QuestionPeer::TITLE, $this->title);
		if ($this->isColumnModified(QuestionPeer::STRIPPED_TITLE)) $criteria->add(QuestionPeer::STRIPPED_TITLE, $this->stripped_title);
		if ($this->isColumnModified(QuestionPeer::BODY)) $criteria->add(QuestionPeer::BODY, $this->body);
		if ($this->isColumnModified(QuestionPeer::HTML_BODY)) $criteria->add(QuestionPeer::HTML_BODY, $this->html_body);
		if ($this->isColumnModified(QuestionPeer::INTERESTED_USERS)) $criteria->add(QuestionPeer::INTERESTED_USERS, $this->interested_users);
		if ($this->isColumnModified(QuestionPeer::CREATED_AT)) $criteria->add(QuestionPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(QuestionPeer::UPDATED_AT)) $criteria->add(QuestionPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(QuestionPeer::DATABASE_NAME);

		$criteria->add(QuestionPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUserId($this->user_id);

		$copyObj->setTitle($this->title);

		$copyObj->setStrippedTitle($this->stripped_title);

		$copyObj->setBody($this->body);

		$copyObj->setHtmlBody($this->html_body);

		$copyObj->setInterestedUsers($this->interested_users);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getAnswers() as $relObj) {
				$copyObj->addAnswer($relObj->copy($deepCopy));
			}

			foreach($this->getInterests() as $relObj) {
				$copyObj->addInterest($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new QuestionPeer();
		}
		return self::$peer;
	}

	
	public function setUser($v)
	{


		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}


		$this->aUser = $v;
	}


	
	public function getUser($con = null)
	{
		if ($this->aUser === null && ($this->user_id !== null)) {
						include_once 'lib/model/om/BaseUserPeer.php';

			$this->aUser = UserPeer::retrieveByPK($this->user_id, $con);

			
		}
		return $this->aUser;
	}

	
	public function initAnswers()
	{
		if ($this->collAnswers === null) {
			$this->collAnswers = array();
		}
	}

	
	public function getAnswers($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswers === null) {
			if ($this->isNew()) {
			   $this->collAnswers = array();
			} else {

				$criteria->add(AnswerPeer::QUESTION_ID, $this->getId());

				AnswerPeer::addSelectColumns($criteria);
				$this->collAnswers = AnswerPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AnswerPeer::QUESTION_ID, $this->getId());

				AnswerPeer::addSelectColumns($criteria);
				if (!isset($this->lastAnswerCriteria) || !$this->lastAnswerCriteria->equals($criteria)) {
					$this->collAnswers = AnswerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAnswerCriteria = $criteria;
		return $this->collAnswers;
	}

	
	public function countAnswers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AnswerPeer::QUESTION_ID, $this->getId());

		return AnswerPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addAnswer(Answer $l)
	{
		$this->collAnswers[] = $l;
		$l->setQuestion($this);
	}


	
	public function getAnswersJoinUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswers === null) {
			if ($this->isNew()) {
				$this->collAnswers = array();
			} else {

				$criteria->add(AnswerPeer::QUESTION_ID, $this->getId());

				$this->collAnswers = AnswerPeer::doSelectJoinUser($criteria, $con);
			}
		} else {
									
			$criteria->add(AnswerPeer::QUESTION_ID, $this->getId());

			if (!isset($this->lastAnswerCriteria) || !$this->lastAnswerCriteria->equals($criteria)) {
				$this->collAnswers = AnswerPeer::doSelectJoinUser($criteria, $con);
			}
		}
		$this->lastAnswerCriteria = $criteria;

		return $this->collAnswers;
	}

	
	public function initInterests()
	{
		if ($this->collInterests === null) {
			$this->collInterests = array();
		}
	}

	
	public function getInterests($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseInterestPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInterests === null) {
			if ($this->isNew()) {
			   $this->collInterests = array();
			} else {

				$criteria->add(InterestPeer::QUESTION_ID, $this->getId());

				InterestPeer::addSelectColumns($criteria);
				$this->collInterests = InterestPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(InterestPeer::QUESTION_ID, $this->getId());

				InterestPeer::addSelectColumns($criteria);
				if (!isset($this->lastInterestCriteria) || !$this->lastInterestCriteria->equals($criteria)) {
					$this->collInterests = InterestPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastInterestCriteria = $criteria;
		return $this->collInterests;
	}

	
	public function countInterests($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseInterestPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(InterestPeer::QUESTION_ID, $this->getId());

		return InterestPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addInterest(Interest $l)
	{
		$this->collInterests[] = $l;
		$l->setQuestion($this);
	}


	
	public function getInterestsJoinUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseInterestPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInterests === null) {
			if ($this->isNew()) {
				$this->collInterests = array();
			} else {

				$criteria->add(InterestPeer::QUESTION_ID, $this->getId());

				$this->collInterests = InterestPeer::doSelectJoinUser($criteria, $con);
			}
		} else {
									
			$criteria->add(InterestPeer::QUESTION_ID, $this->getId());

			if (!isset($this->lastInterestCriteria) || !$this->lastInterestCriteria->equals($criteria)) {
				$this->collInterests = InterestPeer::doSelectJoinUser($criteria, $con);
			}
		}
		$this->lastInterestCriteria = $criteria;

		return $this->collInterests;
	}

} 