<?php

/**
 * Default Module of Bootstrap
 *
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Default_Bootstrap extends Zend_Application_Module_Bootstrap {

    /**
     * defines routes for the controllers in aganacore module
     */
    public function _initRoutes() {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        // Specifying the \"api\" controller RESTful route:
        $restApiRoute = new Zend_Rest_Route(
            $front, array(), array(
            'aganacore' => array('rest'),
        ));
        $router->addRoute('restApiRoute', $restApiRoute);


        // Specifying the \"sitecontact\" controller RESTful route:
        $restContactRoute = new Zend_Rest_Route(
            $front, array(), array(
            'aganacore' => array('sitecontact'),
        ));
        $router->addRoute('restSiteContactRoute', $restContactRoute);

                // Specifying the \"sitecontact\" controller RESTful route:
        $restContactRoute = new Zend_Rest_Route(
            $front, array(), array(
            'aganacore' => array('servicetest'),
        ));
        $router->addRoute('restServiceTestRoute', $restContactRoute);
        
    }

    /**
     * initialize templates view directory for AganaCore
     * other modules does not need this because it is done by ModuleBasedThemes Plugin
     */
//    public function _initView() {
//        $front = Zend_Controller_Front::getInstance();
//        $bootstrap = $front->getParam("bootstrap");
//        $moduleName = $request->getModuleName();
//
//        // if the actual module is the default module returns without change
//        // the configuration of the layout and view
//        if ($moduleName == $front->getDefaultModule()) {
//            return;
//        }
//        $layout = Zend_Layout::getMvcInstance();
//        $view = $layout->getView();
//
//        $pathModule = $view->theme_path . '/' . $moduleName ;
//
//        $view->addBasePath($pathModule);
//
//        $layout->setView($view);
//
//    }
}
