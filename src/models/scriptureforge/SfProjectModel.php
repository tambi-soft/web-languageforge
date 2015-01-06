<?php

namespace models\scriptureforge;

use models\ProjectModel;

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
