<?php

/**
 * Gerencia a impressão de um relatório, podendo instanciar e executar os métodos 
 * corretos de carregamento dos registros, de acordo com parâmetros passados.
 * Também contem os templates de cabeçalhos e rodapés
 */
class Agana_Print_Report {

    private function viewToRender($params, $renderViews) {
        $viewToRender = $renderViews['report'];
        
        $keys = array_keys($params);
        
        for ($i = 0; $i < count($keys); $i++) {
            if (array_key_exists($keys[$i], $renderViews)) {
                if($params[$keys[$i]]) {
                    $viewToRender = $renderViews[$keys[$i]];
                }
            }            
        }
        
        return $viewToRender;
    }

    /**
     * Manipula uma chamada para relatório, mostrando o formulário correto,
     * executando a classe e operação de domínio que levanta os dados e renderizando
     * a view/partial correta
     * <br/>
     * $renderViews são um array onde o índice é o nome de um parâmetro que pode ser
     * recebido no request e o valor é a view a ser renderizada.<br/>
     * O índice 'report' deve ser usado com a view de relatório padrão. 'form'
     * deve ser utilizado para a view de interface para renderizar o formulário.
     * <br/>
     *  ['report'] => 'view-padrao'<br/>
     *  ['form'] => 'view-form'<br/>
     *  ['summarized'] => 'view-summarized'<br/>
     * 
     * @param String $domainClass
     * @param String $domainAction
     * @param String $formClass name of the form class
     * @param ArrayObject $renderViews
     * @param String $viewFolder é o nome do diretório onde estão as views, para ser renderizada com retorno, em geral para o pdf
     * @param Zend_View $view o objeto view
     * @param Zend_Request $request o objeto request
     * @return String
     */
    public function handleRequest(
            $domainClass, $domainAction, $formClass,
            array $renderViews, 
            $viewFolder, Agana_Print_Meta $metaReport,
            Zend_Controller_Action $controller) {

//        die(Zend_Debug::dump($controller->view));
        
        $controller->view->records = null;
        
        if ($controller->getRequest()->getParam('format')) {
            $layout = Zend_Layout::getMvcInstance();
            $layout->setLayout('report.layout');

            $domain = new $domainClass();

            $controller->view->records = $domain->$domainAction(
                    Zend_Auth::getInstance()->getIdentity()->appaccount_id, 
                    $controller->getRequest()->getParams());

            $viewToRender = $this->viewToRender($controller->getRequest()->getParams(), $renderViews);

            $controller->view->format = $controller->getParam('format');

            $personDomain = new Persons_Domain_Person();
            $person = $personDomain->getById(Zend_Auth::getInstance()->getIdentity()->person_id);
            $appAccount = $person->getAppaccount();
            
            $metaReport->setAccountName($appAccount->getName());
            
            if ($controller->getParam('format') == 'pdf') {
                $report = new Agana_Print_Pdf_Report($metaReport, $controller->view->theme_path);

                $controller->view->assign('report', $report);

                $layout->disableLayout();

                $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
                        'ViewRenderer');
                $viewRenderer->setNoRender(true);

                $content = $controller->view->render($viewFolder . '/' . $viewToRender . '.phtml');

                $report->addPage($content);
                $report->download();
            } else {
                $report = new Agana_Print_Html_Report($metaReport, '');

                $controller->view->assign('report', $report);

                return $controller->render($viewToRender);
            }
        } else {
            $form = new $formClass();
            $controller->view->assign('form', $form);
            $viewToRender = $renderViews['form'];
            
            return  $controller->render($viewToRender);            
        }
    }

}
