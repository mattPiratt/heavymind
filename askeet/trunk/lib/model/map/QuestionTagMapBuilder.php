<?php



class QuestionTagMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.QuestionTagMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('ask_question_tag');
		$tMap->setPhpName('QuestionTag');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignKey('QUESTION_ID', 'QuestionId', 'int', CreoleTypes::INTEGER, 'ask_question', 'ID', false, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'ask_user', 'ID', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('TAG', 'Tag', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('NORMALIZED_TAG', 'NormalizedTag', 'string', CreoleTypes::VARCHAR, false, 100);

	} 
} 