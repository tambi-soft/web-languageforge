<?php

namespace models\scriptureforge\rapuma;

use models\shared\RunnableJobArtifact;

use models\shared\RunnableJob;

class RapumaSystem {
	
	const RAPUMACONF = '/home/rapuma/.config/rapuma/rapuma.conf';
	
	
	/**
	 * @return string
	 */
	public static function getVersion() {
		$lines = array();
		exec("rapuma -h", $lines);
		;
		if (preg_match('Version (\S+)', join(" ", $lines), $matches)) {
			return $matches[0];	
		} else {
			return "unknown";
		}
	}
	
	/**
	 * @return array
	 */
	public static function readSystemConfig() {
		
	}
	
	/**
	 * 
	 * @param array $config
	 */
	public static function updateSystemConfig($config) {
		
	}
	
}

?>