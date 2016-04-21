<?php

/**
 * Description of Log
 *
 * @author nuno
 */
class Agana_Util_Log {

    /**
     * Returns the path to system file configurated to log errors. If no paramter
     * is passed, tries to load bootstrap from Agana_Util_Bootstrap, else, loads
     * from parameter variable.
     * 
     * @param Bootstrap $bootsrap
     * @return string System error file path
     */
    public static function getSystemLogPath($bootsrap = null) {
        if ($bootsrap) {
            $options = $bootsrap->getOption('agana');
        } else {
            $options = Agana_Util_Bootstrap::getOption('agana');
        }

        if (isset($options['app']['syserrorfile'])) {
            $sysLogFile = $options['app']['syserrorfile'];
        } else {
            $sysLogFile = APPLICATION_DATA_PATH . '/app.error.log.xml';
        }

        return $sysLogFile;
    }

}
