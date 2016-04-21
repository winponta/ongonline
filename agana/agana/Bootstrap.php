<?php

/**
 * 
 * This is the main application bootstrap. It defines the common behavior of
 * Agana-fwk
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    const APP_ERROR_LOGGER = 'app.error.logger';

    protected function _initSystemLog() {
        $sysLogFile = Agana_Util_Log::getSystemLogPath($this);
        
        $fp = @fopen($sysLogFile, 'a+', false);
        
        if ($fp) {
            $sysLog = new Zend_Log_Writer_Stream($fp);
            $formatter = new Zend_Log_Formatter_Xml();
            $sysLog->setFormatter($formatter);  
        } else {
            // TODO improve this
            die('App error log file or directory is not writable');
        }            
        
        $systemLogger = new Zend_Log($sysLog);

        Zend_Registry::set(self::APP_ERROR_LOGGER, $systemLogger);
    }

        /**
     * Sets the global constant DEBUG based on the application.ini 
     * configuration.
     * It should be the first created _init function in the class, to be 
     * executed before others
     */
    protected function _initDebug() {
        $options = $this->getOption('agana');

        if (isset($options['debug'])) {
            define('DEBUG', intval($options['debug']));
        } else {
            define('DEBUG', 0);
        }
    }

    protected function _initZFDebug() {
        $options = $this->getOption('agana');

        if (isset($options['debug']) && intval($options['debug']['zf'])) {
            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace('ZFDebug');

            $options = array(
                'plugins' => array('Variables',
                    'File' => array('base_path' => '/path/to/project'),
                    'Memory',
                    'Time',
                    'Registry',
                    'Exception')
            );

            /**
             * Instantiate the database adapter and setup the plugin.
             * Alternatively just add the plugin like above and rely on the 
             * autodiscovery feature.
             */
            if ($this->hasPluginResource('db')) {
                $this->bootstrap('db');
                $db = $this->getPluginResource('db')->getDbAdapter();
                $options['plugins']['Database']['adapter'] = $db;
            }

            # Setup the cache plugin
            if ($this->hasPluginResource('cache')) {
                $this->bootstrap('cache');
                $cache = $this - getPluginResource('cache')->getDbAdapter();
                $options['plugins']['Cache']['backend'] = $cache->getBackend();
            }

            $debug = new ZFDebug_Controller_Plugin_Debug($options);

            $this->bootstrap('frontController');
            $frontController = $this->getResource('frontController');
            $frontController->registerPlugin($debug);
        }
    }

//    public function _initAganaDebugPlugin() {
//        $zfc = Zend_Controller_Front::getInstance();
//
//        // this plugin controls Agana Debug eases
//        $zfc->registerPlugin(new Agana_Controller_Plugin_Debug);
//    }

    protected function _initIn18() {
        // Get current registry
        $registry = Zend_Registry::getInstance();
        /**
         * Set application wide source Locale
         * This is usually your source string language;
         * i.e. $this->translate('Hi I am an English String');
         */
        $locale = new Zend_Locale('pt_BR');

        /**
         * Set up and load the translations (all of them!)
         * resources.translate.options.disableNotices = true
         * resources.translate.options.logUntranslated = true
         */
        $translate = new Zend_Translate(
            array(
                'adapter' => 'array',
                'content' => LIB_PATH . DIRECTORY_SEPARATOR . 'Agana' . 
                            DIRECTORY_SEPARATOR . 'locales',
                'scan' => Zend_Translate::LOCALE_DIRECTORY,
                'disableNotices' => true, // This is a very good idea!
                'logUntranslated' => false, // Change this if you debug,
                'locale' => $locale
            )
        );
        /**
         * Both of these registry keys are magical and makes
         * ZF 1.7+ do automagical things.
         */
        $registry->set('Zend_Locale', $locale);
        $registry->set('Zend_Translate', $translate);
        /**
         * set the default translator for labels in Zend_Form objects
         */
        Zend_Form::setDefaultTranslator($translate);
        return $registry;
    }

    protected function _initAutoloading() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->pushAutoloader(new Agana_Loader_Autoloader_WideImage());
        $autoloader->pushAutoloader(new Agana_Loader_Autoloader_mPDF());
        $autoloader->pushAutoloader(new Agana_Loader_Autoloader_WkHtmlToPdf());
    }

    /**
     * 
     * This method initilize the render object (view) for web layer application.
     * It defines:
     *   - ''agana'' as the main theme name if no other is specified in 
     *          application config or session
     *   - ''theme_path'' propertie of the ''view'' object as 
     *          ''basePath/themename/templates''
     *   - layout path as ''theme_path/layout''
     *   - view base path as ''theme_path''
     *   - aganacore module scripts view path as 
     *          ''theme_path/aganacore/scripts'' 
     */
    protected function _initView() {
        $theme = 'agana';
        $options = $this->getOption('themes');

        if (isset($options['name'])) {
            $theme = $options['name'];
        }

        // if there is a diferent theme in the session, use it
        $themeSession = new Zend_Session_Namespace("theme");
        if (isset($themeSession->themeName)) {
            $theme = $themeSession->themeName;
        }

        $themePath = $options['basePath'] . '/' . $theme . '/templates';

        $layout = Zend_Layout::startMvc()
                ->setLayout('layout')
                ->setLayoutPath($themePath . '/layout')
                ->setContentKey('content');

        $view = $layout->getView();
        $view->setBasePath($themePath);
        //$view->setScriptPath($theme_path . '/aganacore/scripts');

        // TODO describe php doc for this variables
        $view->assign("theme_name", $theme);
        $view->assign("theme_path", $themePath);
        $view->assign("path_css", '/themes/' . $theme . "/css");
        $view->assign("path_img", '/themes/' . $theme . "/img");
        $view->assign("path_js", '/themes/' . $theme . "/js");
        $view->assign("path_templates", '/themes/' . $theme . "/templates");
        $view->assign("path_vendor", '/themes/' . $theme . "/vendor");

        /**
         * Add the Agana View helpers path
         */
        $view->addHelperPath(
            APPLICATION_PATH . '/../lib/Agana/View/Helper', 
            'Agana_View_Helper'
        );

        /**
         * Add Zend_Dojo view helper
         */
//      $view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
//      $view->dojo()->enable();
//      Zend_Dojo::enableView($view);

        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

        /**
         * Add ZFBootstrap helper 
         */
        $view->addHelperPath(
            APPLICATION_PATH . 
            '/../lib/Agana/View/Helper/Navigation', 
            'Agana_View_Helper_Navigation'
        );
        $view->registerHelper(new Agana_View_Helper_Navigation_Menu(), 'menu');

        /**
         * Add the Agana View Translate filter and filters path
         */
        $view->addFilterPath('Agana/View/Filter', 'Agana_View_Filter');
        $view->setFilter('Translate');

        return $view;
    }

    /**
     * 
     * Initilize Agana's Plugins:
     * @see Agana_Controller_Plugin_ModuleBasedThemes
     */
    protected function _initPlugins() {
        $zfc = Zend_Controller_Front::getInstance();
        // this plugin controls the path of module themes
        $zfc->registerPlugin(new Agana_Controller_Plugin_ModuleBasedThemes());
        // this plugin controls the layout
        $zfc->registerPlugin(new Agana_Controller_Plugin_AppLayout());
        // this plugin controls the flash messages output
        $zfc->registerPlugin(new Agana_Controller_Plugin_FlashMessages());
        // this plugin controls the loading of ACL
        $zfc->registerPlugin(
            new Agana_Controller_Plugin_Navigation_GlobalMenu()
        );
    }

}

