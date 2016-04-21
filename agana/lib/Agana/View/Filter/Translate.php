<?php

/**
 * Agana_View_Filter_Translate translate content inner tags <translate>.
 * Based on article from janburhl @link http://devzone.zend.com/article/4513
 *
 * @category   Agana
 * @package    Agana_View
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Filter_Translate implements Zend_Filter_Interface {
    /**
     * Starting delimiter for translation snippets in view
     *
     */
    const I18N_DELIMITER_START = '<translate>';

    /**
     * Ending delimiter for translation snippets in view
     *
     */
    const I18N_DELIMITER_END = '</translate>';

    /**
     * Filter the value for i18n Tags and translate
     * 
     * @param string $value
     * @return string
     */
    public function filter($value) {
        $startDelimiterLength = strlen(self::I18N_DELIMITER_START);
        $endDelimiterLength = strlen(self::I18N_DELIMITER_END);

        $translator = Zend_Registry::get('Zend_Translate');

        $offset = 0;
        while (($posStart = strpos($value, self::I18N_DELIMITER_START, $offset)) !== false) {
            $offset = $posStart + $startDelimiterLength;
            if (($posEnd = strpos($value, self::I18N_DELIMITER_END, $offset)) === false) {
                throw new Zend_Exception("No ending " . self::I18N_DELIMITER_START . " tag after position [$offset] found!");
            }
            $translate = substr($value, $offset, $posEnd - $offset);

            $translate = $translator->_($translate);

            $offset = $posEnd + $endDelimiterLength;
            $value = substr_replace($value, $translate, $posStart, $offset - $posStart);
            $offset = $offset - $startDelimiterLength - $endDelimiterLength;
        }

        return $value;
    }

}
