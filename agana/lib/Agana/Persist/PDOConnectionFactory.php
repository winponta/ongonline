<?php
/**
 * A PDO Factory class ofr connection
 */
class Agana_Persist_PDOConnectionFactory {

    /**
     * @var PDO
     */
    protected $_con = null;
    protected $_driver = "";
    protected $_host = "";
    protected $_user = "";
    protected $_pwd = "";
    protected $_dbName = "";

    protected $_persistent = false;
    
    protected static $_instance = null;

    /**
     * The constructor instantiate connections params from agana.ini config application
     */
    private function __construct() {
        $c = Agana_Util_Bootstrap::getOption('agana');
        if (isset($c['pdo']['params'])) {
            $p = $c['pdo']['params'];
            $this->_driver = $p['driver'];
            $this->_user = $p['user'];
            $this->_pwd = $p['password'];
            $this->_host = $p['host'];
            $this->_dbName = $p['dbname'];
        } else {
            throw new Agana_Exception("No AGANA.PDO configuration founded !");
        }
    }
    
    /**
     * Singleton instance
     *
     * @return Agana_Persist_PDOConnectionFactory
     */
    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     *
     * @param type $persistent
     * @return PDO
     */
    public function getConnection($persistent=false) {
        if ($persistent != false) {
            $this->_persistent = true;
        }
        
        try {
            $this->_con = new PDO($this->_driver . ":host=" . $this->_host . ";dbname=" . $this->_dbName, $this->_user, $this->_pwd,
                            array(PDO::ATTR_PERSISTENT => $this->_persistent));
            // by default throws exceptions on PDO errors
            $this->_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // success
            return $this->_con;
            // error;
        } catch (PDOException $ex) {
            // TODO corrigir a insercao do erro da excecao, lancar corretamente
            throw new Agana_Exception($ex->getMessage());
        }
    }

    /**
     * Closes connection
     */
    public function Close() {
        if ($this->_con != null) {
            $this->_con = null;
        }
    }

}

?>
