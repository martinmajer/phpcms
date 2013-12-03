<?php

class User extends Model {

    const TABLE = "user";
    
    
    public $username;
    public $lastLogin;
    
    public $passwordMd5;
    
    
    public function load($rawData) {
        $this->username = $rawData['username'];
        $this->lastLogin = $rawData['lastLogin'];
        $this->passwordMd5 = $rawData['password'];
    }
    
    public function updateLastLogin() {
        $this->lastLogin = date("Y-m-d H:i:s");
        $sqlHelper = new SqlHelper(User::TABLE);
        $sqlHelper->update(array(
            'lastLogin!' => $this->lastLogin
        ), $sqlHelper->idWhere($this->id));
    }

    public function saveNew() {
        return false;
    }

    public function update() {
        return false;
    }
    
    public function updatePassword() {
        $helper = new SqlHelper(User::TABLE);
        return $helper->update(array(
            'password!' => $this->passwordMd5
        ), $helper->idWhere($this->id));
    }
    
    public function delete() {
        return false;
    }
    
}

class UserFactory extends ModelFactory {
    
    /**
     * Najde uživatele podle přihlašovacího jména a hesla.
     * @param string $username
     * @param string $password
     * @return User
     */
    public function findUser($username, $password) {
        $users = $this->loadCollection("username = '" . db()->escape_string($username) . "' AND password = '" . md5($password) . "'");
        if (!$users) return null;
        else return current($users);
    }
    
    public function loadCollection($where = null, $order = null, $offset = null, $count = null) {
        $helper = new ModelFactoryHelper($this, User::TABLE);
        return $helper->simpleLoadCollection($where, $order, $offset, $count);
    }

    public function loadSingle($id) {
        $helper = new ModelFactoryHelper($this, User::TABLE);
        return $helper->simpleLoadSingle($id);
    }

    public function makeNew() {
        return new User();
    }

    public function getCount($where = null) {
        $helper = new ModelFactoryHelper($this, User::TABLE);
        return $helper->simpleGetCount($where);
    }
    
}