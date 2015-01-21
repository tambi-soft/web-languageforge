<?php

namespace models\scriptureforge\webtypesetting\dto;


use models\scriptureforge\webtypesetting\SettingListModel;

use models\mapper\JsonEncoder;

use models\ProjectModel;

class TypesettingRenderPageDtoAuthorEncoder extends JsonEncoder
{
	public function encodeIdReference($key, $model)
	{
		if ($key == 'createdByUserRef' || $key == 'modifiedByUserRef') {
			$user = new UserModel();
			if ($user->exists($model->asString())) {
				$user->read($model->asString());

				return array(
						'id' => $user->id->asString(),
						'avatar_ref' => $user->avatar_ref,
						'name' => $user->name,
						'username' => $user->username);
			} else {
				return '';
			}
		} else {
			return $model->asString();
		}
	}

	public static function encode($model)
	{
		$e = new TypesettingRenderPageDtoAuthorEncoder();

		return $e->_encode($model);
	}
}
class TypesettingRenderPageDto
{
    /**
     *
     * @param string $projectId
     * @returns array - the DTO array
     */
    public static function encode($projectId)
    {
    	$project = new ProjectModel($projectId);
    	$settingsList = new SettingListModel($project);
    	$settingsList->read();
    	$data = array();
    	// TODO implement using AuthorEncoder above
    	//$encodedList = TypesettingRenderPageDtoAuthorEncoder::encode($settingsList);
        $data['runs'] = $settingsList->entries;
        return $data;
    }
}
