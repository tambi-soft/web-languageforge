<?php

namespace models\scriptureforge\webtypesetting;

use models\shared\rights\ProjectRoles;
use models\shared\rights\Domain;
use models\shared\rights\Operation;

class WebtypesettingRoles extends ProjectRoles
{
    public static function init()
    {
        // Project Member
        $rights = array();
        $rights[] = Domain::TEXTS + Operation::VIEW;
        self::$_rights[self::CONTRIBUTOR] = $rights;

        // Project Manager (everything an user has... plus the following)
        $rights = self::$_rights[self::CONTRIBUTOR];
        $rights[] = Domain::TEXTS + Operation::EDIT;
        self::$_rights[self::MANAGER] = $rights;
    }

    private static $_rights;
    public static function hasRight($role, $right) { return self::_hasRight(self::$_rights, $role, $right); }
    public static function getRightsArray($role) { return self::_getRightsArray(self::$_rights, $role); }

}
WebtypesettingRoles::init();
