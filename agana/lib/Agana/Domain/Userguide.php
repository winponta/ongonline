<?php

/**
 * Agana_Domain_Userguide
 *
 * controls the user guide feature
 * 
 * @category   Agana
 * @package    Agana_Userguide
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Domain_Userguide {

    protected $module = null;
    protected $page = '';
    protected $filepath = null;
    protected $error = array();

    public function __construct($page) {
        $page = preg_split('%\.%', $page);
        $this->module = array_shift($page);
        
        foreach ($page as $value) {
            $this->page .= ($this->page == '')?'':'.' ;
            $this->page .= $value;        
        }

        $this->filepath = Zend_Controller_Front::getInstance()->getModuleDirectory($this->module);

        if ($this->filepath == '') {
            throw new Exception("Can't find module with name: " . $this->module);
        } else {
            $this->filepath .= '/docs/userguide/' . $this->page;
        }
    }

    public function pageExists() {
        return file_exists($this->filepath);
    }
    
    public function isWritable() {
        return is_writable($this->filepath);
    }

    public function loadPage() {
        if ($this->pageExists()) {
            $xml = simplexml_load_file($this->filepath);
            $page['updated'] = $xml->updated;
            $page['title'] = $xml->title;
            $page['content'] = $xml->content;
            $page['name'] = $this->module .'.'. $this->page;
            
            return $page;
        } else {
            throw new Exception('Failed to load user guide page: ' . $this->module . '.' . $this->page);
        }
    }

    public function render() {
        $page = $this->loadPage();

        $page['content'] = html_entity_decode($page['content']);

        return $page;
    }

    public function isEditAllowed() {
        $boot = Agana_Util_Bootstrap::getBootstrap();
        $opt = $boot->getOption('agana');
        return strtolower($opt['userguide']['edit']) == 'on';
    }

    public function create($page) {
        if ($this->pageExists()) {
            $this->error[] = 'Page already exists and cannot be recreated!';
            return false;
        } else {
            $this->save($page);
        }
        return true;
    }

    public function getLastError() {
        return array_pop($this->error);
    }
    
    private function save($page) {
            $xmlSetup = "<?xml version='1.0' standalone='yes'?>
                    <page>
                    </page>
            ";
            
            $xml = new SimpleXMLElement($xmlSetup);
            $d = new Zend_Date(Zend_Date::now());
            $xml->addChild('updated', $d->toString('dd/MM/YYYY HH:mm'));
            $xml->addChild('title', $page->title);
            $xml->addChild('content', $page->content);
            
            try {
                $xml->saveXML($this->filepath);
            } catch (Exception $e) {
                throw $e;
            }
        
    }
    
    public function update($page) {
        if ($this->pageExists()) {
            $this->save($page);
        } else {
            $this->error[] = 'Page do not found!';
            return false;
        }
        return true;        
    }

}

?>
