<?php

/**
 * User_Helper_Status
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_View_Helper_UserStatus extends Zend_View_Helper_Abstract {

    /**
     * Receives a status code of the user and translate to its string name
     * 
     * @param int $statusCode
     * @return String
     */
    public function userStatus($statusCode) {
        switch (intval($statusCode)) {
            case -1:
                return 'Blocked';
                break;
            case 0:
                return 'Inactive';
                break;
            case 1:
                return 'Active';
                break;
            default:
                break;
        }
        return 'Unknow = ' . $statusCode;
    }
}
