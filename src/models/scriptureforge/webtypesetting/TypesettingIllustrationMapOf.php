<?php

namespace models\scriptureforge\webtypesetting;

use models\mapper\MapOf;
class TypesettingIllustrationMapOf extends MapOf{
	
	/**
	 */
	public function __construct() {
		parent::__construct ( function ($data) {
			return new TypesettingIllustrationModel();
		} );
	}
}
