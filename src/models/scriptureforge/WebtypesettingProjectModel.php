<?php

namespace models\scriptureforge;

class WebtypesettingProjectModel extends SfProjectModel
{
    public function __construct($id = '')
    {
        $this->rolesClass = 'models\scriptureforge\webtypesetting\WebtypesettingRoles';
        $this->appName = SfProjectModel::WEBTYPESETTING_APP;

        // This must be last, the constructor reads data in from the database which must overwrite the defaults above.
        parent::__construct($id);
    }
}


