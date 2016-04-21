<?php
/**
 * Agana_Module_Menu_Interfacce
 *
 * @category   Agana
 * @package    Agana_Interfacce
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
interface Agana_Module_Menu_Interface {
    /**
     * injects the pages needed for the module in global menu
     */
    public function injectGlobalMenu();
}
