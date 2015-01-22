<?php

namespace models\scriptureforge\webtypesetting;

use models\mapper\MapOf;
class ParagraphPropertiesMapOf extends MapOf {
	public function __construct() {
		parent::__construct(
				function ($data) {
				return new ParagraphProperty ();
			}
		);
	}
}

?>