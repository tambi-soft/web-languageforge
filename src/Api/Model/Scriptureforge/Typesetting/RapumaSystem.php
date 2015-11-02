<?php

namespace Api\Model\Scriptureforge\Typesetting;

class RapumaSystem
{
    const RAPUMACONF = '/var/lib/rapuma/config/rapuma.conf';

    /**
     * @return string
     */
    public static function getVersion()
    {
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
    public static function readSystemConfig()
    {
        
    }
    
    /**
     * 
     * @param array $config
     */
    public static function updateSystemConfig($config)
    {
        
    }
}
