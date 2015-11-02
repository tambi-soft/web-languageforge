<?php

namespace Api\Model\Scriptureforge;

use Api\Model\ProjectModel;

class SfProjectModel extends ProjectModel
{
    // define Scriptureforge project types here
    const SFCHECKS_APP = 'sfchecks';
    const TYPESETTING_APP = 'typesetting';

    public function __construct($id = '')
    {
        parent::__construct($id);
    }
}
