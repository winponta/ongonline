<?php
/**
 * Class that controls the version installed and available of Agana Framework
 *
 * @author  Ademir Mazer Jr
 * @version $Id: Version.php 1 2011-09-13 11:07 @nunomazer $
 */
final class Agana_Version {
    /**
     * Agana Framework version identification
     */
    const VERSION = 'beta.1.2.0';
    const DEPLOYDATE = '2013-06-18 02:53';
    
    /**
     * Returns the Agana framework version
     * 
     * @return String
     */
    public static function getFrameworkVersion() {
        return self::VERSION;
    }
    
    /**
     * Returns Framework deploy date at format yyyy-mm-dd HH:mm
     * @return String
     */
    public static function getFrameworkDeployDate() {
        return self::DEPLOYDATE;
    }
    
    public static function getAppVersion() {
        $v = "unknown";
        
        $boot = Agana_Util_Bootstrap::getBootstrap();
        
        $opt = $boot->getOption('agana');
        if (isset($opt['app']['version'])) {
            $v = $opt['app']['version'];
        }
        
        return $v;
    }
    
    public static function getAppDeployDate() {
        $d = "unknown";
        
        $boot = Agana_Util_Bootstrap::getBootstrap();
        
        $opt = $boot->getOption('agana');
        if (isset($opt['app']['deploydate'])) {
            $d = $opt['app']['deploydate'];
        }
        
        return $d;
    }
}

