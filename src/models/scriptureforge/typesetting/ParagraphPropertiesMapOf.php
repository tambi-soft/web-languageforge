<?php

namespace models\scriptureforge\typesetting;

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