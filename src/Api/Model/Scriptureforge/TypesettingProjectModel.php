<?php

namespace Api\Model\Scriptureforge;

class TypesettingProjectModel extends SfProjectModel
{
    public function __construct($id = '')
    {
        $this->rolesClass = 'Api\model\Scriptureforge\Typesetting\TypesettingRoles';
        $this->appName = SfProjectModel::TYPESETTING_APP;

        // This must be last, the constructor reads data in from the database which must overwrite the defaults above.
        parent::__construct($id);
    }
}
