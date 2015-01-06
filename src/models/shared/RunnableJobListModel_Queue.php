<?php
namespace models\shared;

use models\mapper\MapperListModel;

class RunnableJobListModel_Queue extends MapperListModel {

	public static function mapper($databaseName) {
		static $instance = null;
		if (null === $instance) {
			$instance = new \models\mapper\MongoMapper($databaseName, 'jobs');
		}
		return $instance;
	}
	
	/**
	 *
	 * @param ProjectModel $projectModel
	 */
	public function __construct($projectModel) {
		// TODO sort by dateCreated (ask Darcy about this)
		parent::__construct( self::mapper($projectModel->databaseName()), array('endTime' => 0), array('startTime', 'endTime'));
	}
	
}