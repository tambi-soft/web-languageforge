<?php
namespace models\scriptureforge\webtypesetting;

use models\mapper\MongoMapper;

use models\ProjectModel;

class TypesettingDiscussionPostListModel extends \models\mapper\MapperListModel
{
    public static function mapper($databaseName)
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new \models\mapper\MongoMapper($databaseName, 'typesettingDiscussionPosts');
        }

        return $instance;
    }

    /**
     *
     * @param ProjectModel $projectModel
     * @param int $newerThanTimestamp
     */
    public function __construct($projectModel, $threadId, $newerThanTimestamp = null)
    {
        if (!is_null($newerThanTimestamp)) {
            $startDate = new \MongoDate($newerThanTimestamp);
            parent::__construct( self::mapper($projectModel->databaseName()), array('threadRef' => MongoMapper::mongoID($threadId),  'dateModified'=> array('$gte' => $startDate), 'isDeleted' => false), array());
        } else {
            parent::__construct( self::mapper($projectModel->databaseName()), array('threadRef' => MongoMapper::mongoID($threadId), 'isDeleted' => false), array());
        }
    }
}
