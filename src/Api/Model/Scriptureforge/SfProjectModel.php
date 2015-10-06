<?php

namespace Api\Model\Scriptureforge;

use Api\Model\ProjectModel;

class SfProjectModel extends ProjectModel
{
    // define scriptureforge project types here
    const SFCHECKS_APP = 'sfchecks';
    const WEBTYPESETTING_APP = 'webtypesetting';

    public function __construct($id = '')
    {
        parent::__construct($id);
    }
}
