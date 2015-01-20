<?php
namespace models\scriptureforge\webtypesetting;

class SettingListModel extends \models\mapper\MapperListModel
{

    public static function mapper($databaseName)
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new \models\mapper\MongoMapper($databaseName, 'settings');
        }

        return $instance;
    }

    /*
	protected function __construct($projectModel, $query, $fields)
	{
		parent::__construct(
				self::mapper($projectModel->databaseName()),
				$query,
				$fields
		);
	}
	*/

    /**
     *
     * @param ProjectModel $projectModel
     * @param int $newerThanTimestamp
     */
    public function __construct($projectModel, $newerThanTimestamp = null)
    {
        if (!is_null($newerThanTimestamp)) {
            $startDate = new \MongoDate($newerThanTimestamp);
            parent::__construct( self::mapper($projectModel->databaseName()), array('dateModified'=> array('$gte' => $startDate), 'isArchived' => false), array(), array('dateCreated' => -1));
        } else {
            parent::__construct( self::mapper($projectModel->databaseName()), array('isArchived' => false), array(), array('dateCreated' => -1));
        }
    }
	
    /*
	public static function all($projectModel)
	{
		return new SettingListModel(
				$projectModel,
				$query = array('description' => array('$regex' => '')),
				array('description')
		);
	}
	
	public static function templates($projectModel)
	{
		return new SettingListModel(
			$projectModel,
			array('templateName' => array('$ne' => "")),
			array('description')
		);
	}
	*/
	

}
