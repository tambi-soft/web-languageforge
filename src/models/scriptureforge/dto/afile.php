<?php

include "UsxHelper.php";
use models\scriptureforge\dto\UsxHelper;

//$usx = file_get_contents('./../../../../docs/usx/043JHN.usx');
$usx = file_get_contents('./../../../../docs/usx/CEV_PSA001.usx');
$usxHelper = new UsxHelper($usx);
$result = $usxHelper->toHtml();

echo $result;

