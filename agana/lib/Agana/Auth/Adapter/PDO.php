<?php

/**
 * PDO
 *
 * @category   Agana
 * @package    Agana_PDO
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Auth_Adapter_PDO implements Zend_Auth_Adapter_Interface {

    /**
     * @var Zend_Db_Select
     */
    protected $_dbSelect = null;

    /**
     * $_tableName - the table name to check
     *
     * @var string
     */
    protected $_tableName = null;

    /**
     * $_identityColumn - the column to use as the identity
     *
     * @var string
     */
    protected $_identityColumn = null;

    /**
     * $_credentialColumns - columns to be used as the credentials
     *
     * @var string
     */
    protected $_credentialColumn = null;

    /**
     * $_saltColumns - columns to be used as the credentials salt
     *
     * @var string
     */
    protected $_saltColumn = null;

    /**
     * $_identity - Identity value
     *
     * @var string
     */
    protected $_identity = null;

    /**
     * $_credential - Credential values
     *
     * @var string
     */
    protected $_credential = null;

    /**
     * $_credentialTreatment - Treatment applied to the credential, such as MD5(), PASSWORD() or SALT()
     *
     * @var string
     */
    protected $_credentialTreatment = null;

    /**
     * $_authenticateResultInfo
     *
     * @var array
     */
    protected $_authenticateResultInfo = null;

    /**
     * $_resultRow - Results of database authentication query
     *
     * @var array
     */
    protected $_resultRow = null;

    /**
     * $_ambiguityIdentity - Flag to indicate same Identity can be used with
     * different credentials. Default is FALSE and need to be set to true to
     * allow ambiguity usage.
     *
     * @var boolean
     */
    protected $_ambiguityIdentity = false;

    /**
     * __construct() - Sets configuration options
     *
     * @param  string                   $tableName
     * @param  string                   $identityColumn
     * @param  string                   $credentialColumn
     * @param  string                   $saltColumn
     * @param  string                   $credentialTreatment
     * @return void
     */
    public function __construct($tableName = null, $identityColumn = null, 
            $credentialColumn = null, $saltColumn = null, $credentialTreatment = null) {
        
        if (null !== $tableName) {
            $this->setTableName($tableName);
        }

        if (null !== $identityColumn) {
            $this->setIdentityColumn($identityColumn);
        }

        if (null !== $credentialColumn) {
            $this->setCredentialColumn($credentialColumn);
        }

        if (null !== $saltColumn) {
            $this->setSaltColumn($saltColumn);
        }

        if (null !== $credentialTreatment) {
            $this->setCredentialTreatment($credentialTreatment);
        }
    }

    /**
     * authenticate() - defined by Zend_Auth_Adapter_Interface.  This method is called to
     * attempt an authentication.  Previous to this call, this adapter would have already
     * been configured with all necessary information to successfully connect to a database
     * table and attempt to find a record matching the provided identity.
     *
     * @throws Zend_Auth_Adapter_Exception if answering the authentication query is impossible
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        $this->_authenticateSetup();

        $dbSelect = $this->_authenticateCreateSelect();
        $resultIdentities = $this->_authenticateQuerySelect($dbSelect);

        if (($authResult = $this->_authenticateValidateResultSet($resultIdentities)) instanceof Zend_Auth_Result) {
            return $authResult;
        }

        if (true === $this->getAmbiguityIdentity()) {
            $validIdentities = array();
            $zendAuthCredentialMatchColumn = $this->_zendDb->foldCase('zend_auth_credential_match');
            foreach ($resultIdentities as $identity) {
                if (1 === (int) $identity[$zendAuthCredentialMatchColumn]) {
                    $validIdentities[] = $identity;
                }
            }
            $resultIdentities = $validIdentities;
        }

        $authResult = $this->_authenticateValidateResult(array_shift($resultIdentities));
        return $authResult;

///////////////////////////////////////////////////////////////////////////qq
        if (empty($this->_username) || empty($this->_password)) {
            return new Zend_Auth_Result(
                            Zend_Auth_Result::FAILURE, array()
            );
        }

        if ($this->_username != self::DEFAULT_USERNAME ||
                $this->_password != self::DEFAULT_PASSWORD) {
            return new Zend_Auth_Result(
                            Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, array()
            );
        }
        return new Zend_Auth_Result(
                        Zend_Auth_Result::SUCCESS,
                        array(
                            'username' => self::DEFAULT_USERNAME,
                            'firstName' => self::DEFAULT_PASSWORD
                        )
        );

        throw new Zend_Auth_Adapter_Exception();
    }

    /**
     * setTableName() - set the table name to be used in the select query
     *
     * @param  string $tableName
     * @return Agana_Auth_Adapter_PDO
     */
    public function setTableName($tableName) {
        $this->_tableName = $tableName;
        return $this;
    }

    /**
     * setIdentityColumn() - set the column name to be used as the identity column
     *
     * @param  string $identityColumn
     * @return Agana_Auth_Adapter_PDO
     */
    public function setIdentityColumn($identityColumn) {
        $this->_identityColumn = $identityColumn;
        return $this;
    }

    /**
     * setCredentialColumn() - set the column name to be used as the credential column
     *
     * @param  string $credentialColumn
     * @return Agana_Auth_Adapter_PDO
     */
    public function setCredentialColumn($credentialColumn) {
        $this->_credentialColumn = $credentialColumn;
        return $this;
    }

    /**
     * setSaltColumn() - set the column name to be used as the salt column
     *
     * @param  string $credentialColumn
     * @return Agana_Auth_Adapter_PDO
     */
    public function setSaltColumn($saltColumn) {
        $this->_saltColumn = $saltColumn;
        return $this;
    }

    /**
     * setCredentialTreatment() - allows the developer to pass a parameterized string that is
     * used to transform or treat the input credential data.
     *
     * In many cases, passwords and other sensitive data are encrypted, hashed, encoded,
     * obscured, or otherwise treated through some function or algorithm. By specifying a
     * parameterized treatment string with this method, a developer may apply arbitrary SQL
     * upon input credential data.
     *
     * Examples:
     *
     *  'PASSWORD(?)'
     *  'MD5(?)'
     *  'SALT(?)'
     *
     * @param  string $treatment
     * @return Agana_Auth_Adapter_PDO
     */
    public function setCredentialTreatment($treatment) {
        $this->_credentialTreatment = $treatment;
        return $this;
    }

    /**
     * setIdentity() - set the value to be used as the identity
     *
     * @param  string $value
     * @return Agana_Auth_Adapter_PDO
     */
    public function setIdentity($value) {
        $this->_identity = $value;
        return $this;
    }

    /**
     * setCredential() - set the credential value to be used, optionally can specify a treatment
     * to be used, should be supplied in parameterized form, such as 'MD5(?)' or 'PASSWORD(?)'
     *
     * @param  string $credential
     * @return Agana_Auth_Adapter_PDO
     */
    public function setCredential($credential) {
        $this->_credential = $credential;
        return $this;
    }

    /**
     * setAmbiguityIdentity() - sets a flag for usage of identical identities
     * with unique credentials. It accepts integers (0, 1) or boolean (true,
     * false) parameters. Default is false.
     *
     * @param  int|bool $flag
     * @return Agana_Auth_Adapter_PDO
     */
    public function setAmbiguityIdentity($flag) {
        if (is_integer($flag)) {
            $this->_ambiguityIdentity = (1 === $flag ? true : false);
        } elseif (is_bool($flag)) {
            $this->_ambiguityIdentity = $flag;
        }
        return $this;
    }

    /**
     * getAmbiguityIdentity() - returns TRUE for usage of multiple identical
     * identies with different credentials, FALSE if not used.
     *
     * @return bool
     */
    public function getAmbiguityIdentity() {
        return $this->_ambiguityIdentity;
    }

    /**
     * getDbSelect() - Return the preauthentication Db Select object for userland select query modification
     *
     * @return Zend_Db_Select
     */
    public function getDbSelect() {
        if ($this->_dbSelect == null) {
            $this->_dbSelect = $this->_zendDb->select();
        }

        return $this->_dbSelect;
    }

    /**
     * getResultRowObject() - Returns the result row as a stdClass object
     *
     * @param  string|array $returnColumns
     * @param  string|array $omitColumns
     * @return stdClass|boolean
     */
    public function getResultRowObject($returnColumns = null, $omitColumns = null) {
        if (!$this->_resultRow) {
            return false;
        }

        $returnObject = new stdClass();

        if (null !== $returnColumns) {

            $availableColumns = array_keys($this->_resultRow);
            foreach ((array) $returnColumns as $returnColumn) {
                if (in_array($returnColumn, $availableColumns)) {
                    $returnObject->{$returnColumn} = $this->_resultRow[$returnColumn];
                }
            }
            return $returnObject;
        } elseif (null !== $omitColumns) {

            $omitColumns = (array) $omitColumns;
            foreach ($this->_resultRow as $resultColumn => $resultValue) {
                if (!in_array($resultColumn, $omitColumns)) {
                    $returnObject->{$resultColumn} = $resultValue;
                }
            }
            return $returnObject;
        } else {

            foreach ($this->_resultRow as $resultColumn => $resultValue) {
                $returnObject->{$resultColumn} = $resultValue;
            }
            return $returnObject;
        }
    }

    /**
     * _authenticateSetup() - This method abstracts the steps involved with
     * making sure that this adapter was indeed setup properly with all
     * required pieces of information.
     *
     * @throws Zend_Auth_Adapter_Exception - in the event that setup was not done properly
     * @return true
     */
    protected function _authenticateSetup() {
        $exception = null;

        if ($this->_tableName == '') {
            $exception = 'A table must be supplied for the Agana_Auth_Adapter_PDO authentication adapter.';
        } elseif ($this->_identityColumn == '') {
            $exception = 'An identity column must be supplied for the Agana_Auth_Adapter_PDO authentication adapter.';
        } elseif ($this->_credentialColumn == '') {
            $exception = 'A credential column must be supplied for the Agana_Auth_Adapter_PDO authentication adapter.';
        } elseif ($this->_identity == '') {
            $exception = 'A value for the identity was not provided prior to authentication with Agana_Auth_Adapter_PDO.';
        } elseif ($this->_credential === null) {
            $exception = 'A credential value was not provided prior to authentication with Agana_Auth_Adapter_PDO.';
        }

        $this->_authenticateResultInfo = array(
            'code' => Zend_Auth_Result::FAILURE,
            'identity' => $this->_identity,
            'messages' => array($exception)
        );

        if (null !== $exception) {
            /**
             * @see Zend_Auth_Adapter_Exception
             */
            require_once 'Zend/Auth/Adapter/Exception.php';
            throw new Zend_Auth_Adapter_Exception($exception);
        }

        return true;
    }

    /**
     * _authenticateCreateSelect() - This method creates a Zend_Db_Select object that
     * is completely configured to be queried against the database.
     *
     * @return Zend_Db_Select
     */
    protected function _authenticateCreateSelect() {
        // build credential expression
        if (empty($this->_credentialTreatment) || (strpos($this->_credentialTreatment, '?') === false)) {
            $this->_credentialTreatment = '?';
        }

        $credentialExpression = new Zend_Db_Expr(
                        '(CASE WHEN ' .
                        $this->_zendDb->quoteInto(
                                $this->_zendDb->quoteIdentifier($this->_credentialColumn, true)
                                . ' = ' . $this->_credentialTreatment, $this->_credential
                        )
                        . ' THEN 1 ELSE 0 END) AS '
                        . $this->_zendDb->quoteIdentifier(
                                $this->_zendDb->foldCase('zend_auth_credential_match')
                        )
        );

        // get select
        $dbSelect = clone $this->getDbSelect();
        $dbSelect->from($this->_tableName, array('*', $credentialExpression))
                ->where($this->_zendDb->quoteIdentifier($this->_identityColumn, true) . ' = ?', $this->_identity);

        return $dbSelect;
    }

    /**
     * _authenticateQuerySelect() - This method accepts a Zend_Db_Select object and
     * performs a query against the database with that object.
     *
     * @param Zend_Db_Select $dbSelect
     * @throws Zend_Auth_Adapter_Exception - when an invalid select
     *                                       object is encountered
     * @return array
     */
    protected function _authenticateQuerySelect(Zend_Db_Select $dbSelect) {
        try {
            if ($this->_zendDb->getFetchMode() != Zend_DB::FETCH_ASSOC) {
                $origDbFetchMode = $this->_zendDb->getFetchMode();
                $this->_zendDb->setFetchMode(Zend_DB::FETCH_ASSOC);
            }
            $resultIdentities = $this->_zendDb->fetchAll($dbSelect);
            if (isset($origDbFetchMode)) {
                $this->_zendDb->setFetchMode($origDbFetchMode);
                unset($origDbFetchMode);
            }
        } catch (Exception $e) {
            /**
             * @see Zend_Auth_Adapter_Exception
             */
            require_once 'Zend/Auth/Adapter/Exception.php';
            throw new Zend_Auth_Adapter_Exception('The supplied parameters to Zend_Auth_Adapter_DbTable failed to '
                    . 'produce a valid sql statement, please check table and column names '
                    . 'for validity.', 0, $e);
        }
        return $resultIdentities;
    }

    /**
     * _authenticateValidateResultSet() - This method attempts to make
     * certain that only one record was returned in the resultset
     *
     * @param array $resultIdentities
     * @return true|Zend_Auth_Result
     */
    protected function _authenticateValidateResultSet(array $resultIdentities) {

        if (count($resultIdentities) < 1) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
            $this->_authenticateResultInfo['messages'][] = 'A record with the supplied identity could not be found.';
            return $this->_authenticateCreateAuthResult();
        } elseif (count($resultIdentities) > 1 && false === $this->getAmbiguityIdentity()) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS;
            $this->_authenticateResultInfo['messages'][] = 'More than one record matches the supplied identity.';
            return $this->_authenticateCreateAuthResult();
        }

        return true;
    }

    /**
     * _authenticateValidateResult() - This method attempts to validate that
     * the record in the resultset is indeed a record that matched the
     * identity provided to this adapter.
     *
     * @param array $resultIdentity
     * @return Zend_Auth_Result
     */
    protected function _authenticateValidateResult($resultIdentity) {
        $zendAuthCredentialMatchColumn = $this->_zendDb->foldCase('zend_auth_credential_match');

        if ($resultIdentity[$zendAuthCredentialMatchColumn] != '1') {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $this->_authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            return $this->_authenticateCreateAuthResult();
        }

        unset($resultIdentity[$zendAuthCredentialMatchColumn]);
        $this->_resultRow = $resultIdentity;

        $this->_authenticateResultInfo['code'] = Zend_Auth_Result::SUCCESS;
        $this->_authenticateResultInfo['messages'][] = 'Authentication successful.';
        return $this->_authenticateCreateAuthResult();
    }

    /**
     * _authenticateCreateAuthResult() - Creates a Zend_Auth_Result object from
     * the information that has been collected during the authenticate() attempt.
     *
     * @return Zend_Auth_Result
     */
    protected function _authenticateCreateAuthResult() {
        return new Zend_Auth_Result(
                        $this->_authenticateResultInfo['code'],
                        $this->_authenticateResultInfo['identity'],
                        $this->_authenticateResultInfo['messages']
        );
    }

}

?>
