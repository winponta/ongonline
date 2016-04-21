<?php
/**
 * Agana_Report
 *
 * @category   Agana
 * @package    Agana_Report
 * @copyright  Copyright (c) 2011-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
abstract class Agana_Print_Menu_Global {
    protected $_reports = array();
    protected $_name = '';
    
    /**
     * Returns an array registered as Reports-Global or empty array
     * to control the dependencies of reports and other modules
     * 
     * @return array
     */
    public static function getAllReports() {
        if (Zend_Registry::isRegistered('Reports-Global')) {
            $p = Zend_Registry::get('Reports-Global');
        } else {
            $p = array();
        }
        
        return $p;
    }
    
    /**
     * Save an array registered as Reports-Global 
     * to control the dependencies of reports and other modules
     */
    public static function saveReports($reports) {
        $p = Zend_Registry::set('Reports-Global', $reports);
    }
    
    /**
     * Save a new group in the global reports
     * 
     * @param Agana_Print_Menu_Report $group
     */
    public static function saveGroup(Agana_Print_Menu_Report $group) {
        $reps = self::getAllReports();
        
        $groupExists = false;
        foreach ($reps as $r) {
            if ($r->getId() == $group->getId()) {
                $groupExists = true;
                break;
            }
        }
        
        if ( ! $groupExists ) {
            $reps[] = $group;
        }
        
        self::saveReports($reps);
    }
    
    /**
     * Save a new report in the global reports
     * 
     * @param Agana_Print_Menu_Report $report
     */
    public static function saveReport(Agana_Print_Menu_Report $report) {
        $reps = self::getAllReports();
        
        $reps[] = $report;
        
        self::saveReports($reps);
    }
    
    public static function getReportsFromGroup($groupId) {
        $repsAll = self::getAllReports();
        
        $reps = array();
        foreach ($repsAll as $r) {
            // put group at first position
            if (strtolower($r->getId()) == strtolower($groupId)) {
                array_unshift($reps, $r);
            } else {
                if (strtolower($r->getGroup()) == strtolower($groupId)) {
                    $reps[] = $r;
                }
            }
        }
        
        return $reps;
    }
}
