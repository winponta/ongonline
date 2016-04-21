<?php

/**
 * Agana_Person_Module_Menu
 *
 * @category   Agana
 * @package    Agana_Person
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Persons_Module_Menu extends Zend_Controller_Plugin_Abstract implements Agana_Module_Menu_Interface {

    public function injectGlobalMenu() {
        //TODO ACL

        $menuReg = Agana_Module_Menu_Global::getMenuRegistrations();

        Agana_Module_Menu_Global::navigationHeader('menu-persons-header', 'icon-user', 'Persons', -30, $menuReg);

        Agana_Module_Menu_Global::navigationPageMVC('menu-persons-list', 
                'icon-user', 'List Persons', 'persons', 'persons', 'list', 
                'content-container', -20, $menuReg);

        /** PERSON HELPED **/
        if (Persons_Domain_PersonHelped::isControllerEnabled()) {
            Agana_Module_Menu_Global::navigationPageMVC('menu-person-helped-list', 
                    'icon-heart', 'List Helped Persons', 'persons', 'person-helped', 'list', 
                    'content-container', -15, $menuReg);

            $menuReport = Agana_Module_Menu_Global::getMenuReports();

            $url = Zend_Controller_Action_HelperBroker::getStaticHelper('Url');
            $projectReposrtUrl = $url->url(array(
                    'module'    =>  'aganacore',
                    'controller'=>  'gm',
                    'action'    =>  'report',
                    'id' => 'project',
                    'direction' => 'left-sidebar'
                ));
            
            Agana_Module_Menu_Global::navigationPageURI('menu-reports-projects', 'icon-folder-close', 'Projects', $projectReposrtUrl, -10, $menuReport);
        }

        Agana_Module_Menu_Global::navigationPageMVC('menu-persons-addnew', 
                'icon-plus', 'Add new Person', 'persons', 'person', 'create', 
                'content-container', -10, $menuReg);

        Agana_Module_Menu_Global::navigationDivider(-1, $menuReg);

    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $this->injectGlobalMenu();
    }

}


