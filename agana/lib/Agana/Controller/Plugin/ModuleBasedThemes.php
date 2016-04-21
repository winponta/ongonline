<?php

/**
 * The ModuleBasedThemes Controller Plugin adds the correct module theme path
 * to the Zend View object MVC when the module called is not the default one.
 *  
 * The function gets the theme_path propertie defined in the $view object and adds the module name. 
 * 
 * For example, if we have a module named <strong>Blog</strong>, and the theme <strong>agana</strong>
 * with theme_path like <code>/path/to/templates/agana</code>, so the module template path will be
 * build as <code>/path/to/templates/agana/blog</code>.  
 *
 * @author Ademir Mazer Jr [Nuno Mazer] - <ademir.mazer.jr@gmail.com>
 * 
 */
class Agana_Controller_Plugin_ModuleBasedThemes extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $front = Zend_Controller_Front::getInstance();
        $bootstrap = $front->getParam("bootstrap");
        $moduleName = $request->getModuleName();

        // if the actual module is the default module returns without change
        // the configuration of the layout and view
//        if ($moduleName == $front->getDefaultModule()) {
//            return;
//        }

        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();

        $moduleDir = $front->getControllerDirectory($moduleName);
        if ((null === $moduleDir) || is_array($moduleDir)) {
            /**
             * @see Zend_Controller_Action_Exception
             */
            require_once 'Zend/Controller/Action/Exception.php';
            throw new Zend_Controller_Action_Exception('ViewRenderer cannot locate module directory for module "' . $moduleName . '"');
        }
        $moduleDir = dirname($moduleDir);

        $moduleDir .= '/views';

        // Determine if this path has already been registered
        $currentPaths = $view->getScriptPaths();
        $moduleDir = str_replace(array('/', '\\'), '/', $moduleDir);
        $pathExists = false;
        foreach ($currentPaths as $tmpPath) {
            $tmpPath = str_replace(array('/', '\\'), '/', $tmpPath);
            if (strstr($tmpPath, $moduleDir)) {
                $pathExists = true;
                break;
            }
        }
        if (!$pathExists) {
            $view->addBasePath($moduleDir);
        }

        $moduleThemePath = $view->theme_path . '/' . $moduleName;

        $scriptsPath = $view->getScriptPaths();
        $firstPath = array_shift($scriptsPath);

        $view->setScriptPath($firstPath);

        $q = count($scriptsPath);
        foreach ($scriptsPath as $path) {
            $path = substr($path, 0, strrpos($path, "scripts/"));

            $view->addBasePath($path);            
        }

        $view->addBasePath($moduleThemePath);
        
        $scriptsPath = $view->getScriptPaths();
    }

    public function __postDispatch(Zend_Controller_Request_Abstract $request) {
        $front = Zend_Controller_Front::getInstance();
        $bootstrap = $front->getParam("bootstrap");
        $moduleName = $request->getModuleName();

        // if the actual module is the default module returns without change
        // the configuration of the layout and view
//        if ($moduleName == $front->getDefaultModule()) {
//            return;
//        }
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();

        $pathModule = $view->theme_path . '/' . $moduleName;

        $scriptsPath = $view->getScriptPaths();
        $firstPath = array_shift($scriptsPath);

//        $view->setScriptPath($firstPath);
//
//        Zend_Debug::dump($view->getScriptPaths(), 'AFTER');
//        $q = count($scriptsPath);
//         for ($i=0;$i<$q;$i++){
//            $view->addBasePath($scriptsPath[$i]);
//            Zend_Debug::dump($view->getScriptPaths());
//        }
//        $view->addBasePath($pathModule);
//        $view->setScriptPath($pathModule);

        Zend_Debug::dump($view->getScriptPaths());

        parent::postDispatch($request);
    }

}