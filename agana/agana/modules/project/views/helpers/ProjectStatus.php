<?php

/**
 * Returns project status variations (html tag with label) or name from code
 *
 * @category   Agana
 * @package    Agana_Project
 * @copyright  Copyright (c) 2011-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Project_View_Helper_ProjectStatus extends Zend_View_Helper_Abstract {

    public function projectStatus() {
        return $this;
    }
    
    public function name($code) {        
        
        switch ($code) {
            case Project_Model_Project::PROJECT_STATUS_DRAFT_ID:
                return $this->view->translate(Project_Model_Project::PROJECT_STATUS_DRAFT_LABEL);

                break;

            case Project_Model_Project::PROJECT_STATUS_ACTIVE_ID:
                return $this->view->translate(Project_Model_Project::PROJECT_STATUS_ACTIVE_LABEL);

                break;

            case Project_Model_Project::PROJECT_STATUS_FINISHED_ID:
                return $this->view->translate(Project_Model_Project::PROJECT_STATUS_FINISHED_LABEL);

                break;

            case Project_Model_Project::PROJECT_STATUS_CLOSED_ID:
                return $this->view->translate(Project_Model_Project::PROJECT_STATUS_CLOSED_LABEL);

                break;

            case Project_Model_Project::PROJECT_STATUS_PAUSED_ID:
                return $this->view->translate(Project_Model_Project::PROJECT_STATUS_PAUSED_LABEL);

                break;

            default:
                return "ERROR - NO CODE " . $code . " FOR STATUS";
                break;
        }
    }

    /**
     * Returns an HTML formated to show status
     * <br/><br/>
     * Params:<br/>
     * tag = span <br/>
     * class = "" <br/>
     * 
     * 
     * @param integer $code
     * @param array $params
     * @return string
     */
    public function html($code, $params = array()) {
        $class = isset($params['class']) ? $params['class'] : "";
        $tag = isset($params['tag']) ? $params['tag'] : "span";
        $tag = '<'.$tag.' class="%s '.$class.'">%s</'.$tag.'>';
        switch ($code) {
            case Project_Model_Project::PROJECT_STATUS_DRAFT_ID:
                return sprintf($tag, Project_Model_Project::PROJECT_STATUS_DRAFT_TAGCLASS, $this->name($code));

                break;

            case Project_Model_Project::PROJECT_STATUS_ACTIVE_ID:
                return sprintf($tag, Project_Model_Project::PROJECT_STATUS_ACTIVE_TAGCLASS, $this->name($code));

                break;

            case Project_Model_Project::PROJECT_STATUS_FINISHED_ID:
                return sprintf($tag, Project_Model_Project::PROJECT_STATUS_FINISHED_TAGCLASS, $this->name($code));

                break;

            case Project_Model_Project::PROJECT_STATUS_CLOSED_ID:
                return sprintf($tag, Project_Model_Project::PROJECT_STATUS_CLOSED_TAGCLASS, $this->name($code));

                break;

            case Project_Model_Project::PROJECT_STATUS_PAUSED_ID:
                return sprintf($tag, Project_Model_Project::PROJECT_STATUS_PAUSED_TAGCLASS, $this->name($code));

                break;

            default:
                return "ERROR - NO CODE " . $code . " FOR STATUS";
                break;
        }
    }
}
