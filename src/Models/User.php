<?php

namespace Masterclass\Models;
use PDO;

class User {
    
    public $db;
    protected $config;
    protected $error = null;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function fetchByUsername($username)
    {
        $check_sql = 'SELECT * FROM user WHERE username = ? LIMIT 1';
        $check_stmt = $this->db->prepare($check_sql);
        $check_stmt->execute(array($username));
        return $check_stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function exists($username)
    {
        return (bool) $this->fetchByUsername($username);
    }

    public function fetchOne($id)
    {
        $sql = 'SELECT * FROM user WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getError()
    {
        return $this->error;
    }

    public function isValidCreate($username=null,$email=null,$password=null,$password_check=null)
    {
        if(empty($username) || empty($email) ||
            empty($password) || empty($_POST['password_check'])) {
            $this->error = 'You did not fill in all required fields.';
            return false;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = 'Your email address is invalid';
            return false;
        }

        if($password != $password_check) {
            $this->error = "Your passwords didn't match.";
            return false;
        }

        if($this->exists($username)) {
            $this->error = 'Your chosen username already exists. Please choose another.';
            return false;
        }

        return true;
    }

    public function authenticate($username,$password)
    {
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $sql = 'SELECT password FROM user WHERE username = ? LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($username));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(isset($user['password']) && password_verify($password, $user['password']))
        {
            return true;
        }

        $this->error = 'Your username/password did not match.';
        return false;
    }

    public function login($username)
    {
        session_regenerate_id();
        $_SESSION['username'] = $username;
        $_SESSION['AUTHENTICATED'] = true;
    }

    public function logout()
    {
        session_destroy();
    }

    public function isValidUpdate($password,$password_check)
    {
        if($password != $password_check) {
            $this->error = "The password fields were blank or they did not match. Please try again.";
            return false;
        }

        return true;
    }

    public function create($username,$email,$password)
    {
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($username, $email, password_hash($password, PASSWORD_BCRYPT)));
        return $this->db->lastInsertId();
    }

    public function update($username,$password)
    {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(password_hash($_POST['password'], PASSWORD_BCRYPT), $_SESSION['username']));
    }
}