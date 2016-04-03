<?php

class User_Domain_User {

    /**
     * To be used with getAll method
     */
    const LIST_ALL = null;
    const STATUS_BLOCKED = '-1';
    const STATUS_ACTIVE = '1';
    const STATUS_INACTIVE = '0';

    /**
     *
     * @var User_Model_User
     */
    protected $_user = null;

    public function __construct($userModel = null) {
        if (is_null($userModel)) {
            $userModel = new User_Model_User();
        }
        $this->setUser($userModel);
    }

    public function getAll($appaccount_id, $show = null) {
        if ($this->_isAllowed()) {
            try {
                if ($show != null) {
                    if (!is_array($show)) {
                        $show = explode(',', $show);
                    }
                }
                $u = new User_Persist_Dao_User();
                return $u->getAll(Zend_Auth::getInstance()->getIdentity()->appaccount_id, $show);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    /**
     * @return User_Model_User
     */
    public function getUser() {
        return $this->_user;
    }

    /**
     * @param User_Model_User $user 
     */
    public function setUser($user) {
        if (!($user instanceof User_Model_User) && !is_null($user)) {
            $lastLogin = (is_array($user)) ? @$user['last_login'] : $user->last_login;
            $salt = (is_array($user)) ? @$user['rnd_salt'] : $user->rnd_salt;
            $user = new User_Model_User($user);
            $user->setSalt($salt);
            $user->setLastLogin($lastLogin);
        }

        if ($user && $user->appaccount_id && !$user->getAppAccount()) {
            $ad = new App_Domain_Account();
            $app = $ad->getById($user->appaccount_id);
            $user->setAppAccount($app);
        }

        if ($user && $user->person_id && !$user->getPerson()) {
            $pd = new Persons_Domain_Person();
            $person = $pd->getById($user->person_id);
            $this->_user->setPerson($person);
        }

        $this->_user = $user;
    }

    public function populateUser($data) {
        if (is_array($data)) {
            Agana_Data_BeanUtil::populate($this->_user, $data);
        } else {
            $this->setUser($data);
        }

        $ad = new App_Domain_Account();
        if (!is_null($this->_user->appaccount_id)) {
            $app = $ad->getById($this->_user->appaccount_id);
        } else {
            $app = $ad->getById(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
        }
        $this->_user->setAppAccount($app);

        $pd = new Persons_Domain_Person();
        $person = $pd->getById($this->_user->person_id);
        $this->_user->setPerson($person);
    }

    /**
     * This function is used to perform the add new user in database. It's necessary
     * because the createAdmin function does not need to test if user is allowed
     * 
     * @return User_Model_User
     * @throws Exception 
     */
    private function _add() {
        $this->_user->setSalt(Agana_Util_Crypt::calcRndTimeSalt($this->_user->getPwd(), $this->_user->getName()));
        $this->_user->setPwd(md5($this->_user->getPwd() . $this->_user->getSalt()));
        $this->_user->setCreated(time());

        try {
            $u = new User_Persist_Dao_User();
            $u->beginTransaction();

            // save a new person if needed
            $person = $this->_user->getPerson();
            if (!isset($person) || !$person->getId()) {
                if ($person) {
                    $personName = ($person->getName()) ? $person->getName() : $this->_user->getName();
                } else {
                    $personName = $this->_user->getName();
                    $this->_user->setPerson(new Persons_Model_Person());
                }
                $personToSave = $this->_user->getPerson();
                $personToSave->setName($personName);
                $personToSave->setGender(' ');
                $personDomain = new Persons_Domain_Person($personToSave);

                // do not need to use trasaction so false is passed
                $personResultId = $personDomain->create(false);
                $person = $personDomain->getById($personResultId);
                $this->_user->setPerson($person);
            }

            $app = $this->_user->getAppAccount();
            if (!isset($app) || !$app->getId()) {
                throw new Agana_Exception('An App Account must be provided to include a new user');
            }

            $u->setUseTransaction(false);
            $res = $u->save($this->_user);
            $u->commit();
            return $res;
        } catch (Exception $e) {
            $u->rollback();
            throw $e;
        }
    }

    public function add() {
        if ($this->_isAllowed()) {
            return $this->_add();
        }
    }

    /**
     * Creates a new user based on a person register and associate them
     * 
     * @param int $id The person id with user wil be associated
     */
    public function createForPerson($id) {
        $pd = new Persons_Domain_Person();
        $person = $pd->getById($id);

        if (($person) && ($person->getId())) {
            $user = new User_Model_User();
            $user->setAppaccount_id(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
            $user->setPerson_id($id);
            $user->setStatus(1);

            $name = split(' ', $person->getName());
            $name = array_shift($name);
            $name .= $id;
            $f = new Agana_Filter_Transliterate();
            $name = $f->filter($name);

            $user->setName($name);
            $user->setPwd($name);

            $user->setEmail(
                    ($person->getEmail()) ? $person->getEmail() : $name . '@no.validemail.com'
            );

            $this->setUser($user);

            if ($this->existUser()) {
                throw new Exception('There is already a user in database with one of the key fields: email, name');
            } else {
                return $this->add();
            }
        } else {
            throw new Exception('There is no person with this id');
        }
    }

    /**
     * Create an admin register in database. If no user model is passed then create with the default values.
     * @param User_Model_User $user 
     */
    public function createSuperAdmin($user = null, $app = null) {
        if ($user == null) {
            $user = new User_Model_User(null);
            $user->setCreated(time());
            $user->setEmail('superadmin@system.com');
            $user->setName('superadmin');
            $user->setPwd('superadmin');
            $user->setStatus(1);

            $person = new Persons_Model_Person();
            $person->setName('Super Admin');

            $user->setPerson($person);

            $user->setAppAccount($app);
        }

        $this->setUser($user);
        $this->_add();
    }

    public function update() {
        if ($this->_isAllowed()) {
            $user = $this->getUser();

            try {
                $u = new User_Persist_Dao_User();
                return $u->save($this->_user);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function updatePwd($fromReset = false) {
        if ($this->_isAllowed() || $fromReset) {
            $user = $this->getUser();

            try {
                $pwdAux = $this->_user->getPwd();
                if (!empty($pwdAux)) {
                    $nameAux = $this->_user->getName();
                    if (empty($nameAux)) {
                        $userAux = $this->getById($this->_user->getId());
                        $this->_user->setName($userAux->getName());
                    }

                    $this->_user->setSalt(Agana_Util_Crypt::calcRndTimeSalt($this->_user->getPwd(), $this->_user->getName()));
                    $this->_user->setPwd(md5($this->_user->getPwd() . $this->_user->getSalt()));
                }

                $u = new User_Persist_Dao_User();
                return $u->savePwd($this->_user);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    /**
     * Update the last login information in database to actual timestamp
     * @return type
     * @throws Exception 
     */
    public function updateLastLogin() {
        if ($this->_isAllowed()) {
            $user = $this->getUser();
            //$user->setLastLogin(date('Y-m-d H:m:s'));
            $user->setLastLogin(Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss'));

            try {
                return $this->update();
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            $user = $this->getUser();

            try {
                $u = new User_Persist_Dao_User();
                return $u->delete($this->_user->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        if (!is_null($id)) {
            try {
                $u = new User_Persist_Dao_User();
                return $u->get($id);
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            return $id;
        }
    }

    public function getByName($name) {
        try {
            $u = new User_Persist_Dao_User();
            return $u->getByName(
                            $name, null
                            //Zend_Auth::getInstance()->getIdentity()->appaccount_id
            );
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByEmail($email) {
        try {
            $u = new User_Persist_Dao_User();
            return $u->getByEmail(
                            $email, null
                            //Zend_Auth::getInstance()->getIdentity()->appaccount_id
            );
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByPersonId($id) {
        try {
            $u = new User_Persist_Dao_User();
            return $u->getByPersonId($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function sendResetPasswordEmail(User_Model_User $user) {
        if ($user) {
            $translate = Zend_Registry::get('Zend_Translate');

            $boot = Agana_Util_Bootstrap::getBootstrap();
            $aganaOptions = $boot->getOption('agana');

            $adminEmail = $aganaOptions['app']['admin']['email'];
            $appName = $aganaOptions['app']['name'];

            $mail = new Zend_Mail('UTF-8');
            $mail->setFrom($adminEmail, $appName);
            $mail->setSubject(
                    '[' . $appName . '] ' .
                    $translate->_('Url requested to reset password')
            );
            $mail->addTo($user->email);

            $requestUrl = $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getBaseUrl() . '/user/reset-password/create-new/id/' .
                    $user->id . '/key/' . $this->getResetPasswordKey($user);

            $body = '<html>';
            $body .= '<body>';
            $body .= '<p>';
            $body .= 'Esta mensagem foi enviada pela aplicação <em>' . $appName . '</em>';
            $body .= '</p>';
            $body .= '<p><strong>' . $user->name . '</strong>, </p>';
            $body .= '<p>';
            $body .= 'fez uma solicitação para recriar a sua senha.';
            $body .= '</p>';
            $body .= '<p>';
            $body .= 'Clique no link a seguir para confirmar esta solicitação e ';
            $body .= 'criar uma nova senha:';
            $body .= '</p>';
            $body .= '<a href="' . $requestUrl . '">';
            $body .= $requestUrl;
            $body .= '</a>';
            $body .= '<p>';
            $body .= 'Por favor, note que este link irá expirar em 24 horas.';
            $body .= 'Se você não solicitou ';
            $body .= 'esta ação, por favor ignore esta mensagem.';
            $body .= '</p>';
            $body .= '</body>';
            $body .= '</html>';

            $mail->setBodyHtml($body);

            $mail->send();
        } else {
            throw new Exception('Wrong user parameter !');
        }
    }

    private function _isAllowed() {
        return $this->isAllowed();
    }

    static public function isAllowed() {
        return Zend_Auth::getInstance()->hasIdentity();
    }

    public function getAuthAdapter() {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('user')
                ->setIdentityColumn('name')
                ->setCredentialColumn('pwd')
                //->setCredentialTreatment('MD5(CONCAT(?,rnd_salt))');
                ->setCredentialTreatment('(MD5(? || rnd_salt))');

        return $authAdapter;
    }

    public function authenticate($username, $password) {
        // Get our authentication adapter and check credentials
        $adapter = $this->getAuthAdapter();
        $adapter->setIdentity($username);
        $adapter->setCredential($password);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);

        echo "SALT: " . $salt = Agana_Util_Crypt::calcRndTimeSalt("123456", "hebertomb");
        echo "<br>SENHA: " . md5("123456" . $salt);

        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();

            // updates the last login time
            $user = $this->getById($user->id);
            $this->setUser($user);
            $this->updateLastLogin();

            // write the standard class for user because of problems with 
            // session serialization of the objects
            // must to populate a new User_Model_User when recovering identity
            $auth->getStorage()->write($adapter->getResultRowObject());

            return $user;
        } else {
            $m = $result->getMessages();
            throw new Agana_Exception($m[0]);
        }
    }

    /**
     * Try to identify if a user exist based on its unique keys: id, name, email
     * @return boolean | String Return false if none of the keys identify a user in database. Returns a string with each key identified.
     */
    public function existUser() {
        $dao = new User_Persist_Dao_User();

        $find = '';

        if ($this->getUser()->getId()) {
            if ($dao->get($this->getUser()->getId())) {
                $find .= 'id|';
            }
        }

        if ($this->getUser()->getName()) {
            if ($dao->getByName($this->getUser()->getName(), $this->getUser()->getAppaccount_id())) {
                $find .= 'name|';
            }
        }

        if ($this->getUser()->getEmail()) {
            if ($dao->getByEmail($this->getUser()->getEmail())) {
                $find .= 'email|';
            }
        }
    }

    public function getResetPasswordKey(User_Model_User $user) {
        $timeScrambled = Agana_Util_DateTime::timestampToScrambleChars();
        $key = md5($user->id . $user->getSalt() . $timeScrambled);
        $key .= Agana_Util_DateTime::timestampToScrambleChars();
        $key .= md5($user->email . $user->getPwd() . $timeScrambled);

        return $key;
    }

    public function isValidResetPasswordKey(User_Model_User $user, $key) {
        $first = substr($key, 0, 32);
        $last = substr($key, 42);
        $timeScrambled = substr($key, 32, 10);

        $firstOk = (md5($user->id . $user->getSalt() . $timeScrambled)) == $first;
        $lastOk = (md5($user->email . $user->getPwd() . $timeScrambled)) == $last;

        $time = Agana_Util_DateTime::scrambledCharsToTimestamp($timeScrambled);

        $day = 24 * 60 * 60;
        $linkAge = time() - floatval($time);

        $ageOk = ($day - $linkAge) >= 0;

        return $firstOk && $lastOk && $ageOk;
    }

}
