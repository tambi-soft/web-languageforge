<?php

namespace Api\Library\Shared\Palaso;

use Api\Model\Mapper\MapperListModel;
use Api\Model\Mapper\MongoMapper;
use Api\Model\ProjectModel;

class RunnableJobListModel_Queue extends MapperListModel
{
    public static function mapper($databaseName)
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new MongoMapper($databaseName, 'jobs');
        }

        return $instance;
    }
    
    /**
     *
     * @param ProjectModel $projectModel
     */
    public function __construct($projectModel)
    {
        // TODO sort by dateCreated (ask Darcy about this)
        parent::__construct( self::mapper($projectModel->databaseName()), array('endTime' => 0), array('startTime', 'endTime'));
    }
}
