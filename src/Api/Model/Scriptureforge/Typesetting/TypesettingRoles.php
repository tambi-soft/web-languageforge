<?php

namespace Api\Model\Scriptureforge\Typesetting;

use Api\Model\Shared\Rights\ProjectRoles;
use Api\Model\Shared\Rights\Domain;
use Api\Model\Shared\Rights\Operation;

class TypesettingRoles extends ProjectRoles
{
    public static function init()
    {
        // Project Member
        $rights = array();
        $rights[] = Domain::TEXTS + Operation::VIEW;
        $rights[] = Domain::QUESTIONS + Operation::VIEW;
        self::$_rights[self::CONTRIBUTOR] = $rights;

        // Project Manager (everything an user has... plus the following)
        $rights = self::$_rights[self::CONTRIBUTOR];
        $rights[] = Domain::TEXTS + Operation::EDIT;
        self::grantAllOnDomain($rights, domain::QUESTIONS);
        self::$_rights[self::MANAGER] = $rights;
    }

    private static $_rights;
    public static function hasRight($role, $right) { return self::_hasRight(self::$_rights, $role, $right); }
    public static function getRightsArray($role) { return self::_getRightsArray(self::$_rights, $role); }

}

TypesettingRoles::init();
