<?php

namespace Masterclass\Controllers;
use Masterclass\Models\User as UserModel;

class User {

    protected $config;
    protected $model;

    public function __construct($config) {
        $this->config = $config;
        $this->model = new UserModel($config);
    }
    
    public function create() {
        $error = null;
        
        // Do the create
        if(isset($_POST['create'])) {
            if(!$this->model->isValidCreate($_POST['username'],$_POST['email'],$_POST['password'],$_POST['password_check']))
            {
                $error = $this->model->getError();
            }
            
            if(is_null($error)) {
                $id = $this->model->create($_POST['username'],$_POST['email'],md5($_POST['username'].$_POST['password']));
                header("Location: /user/login");
                exit;
            }
        }

        // Show the create form
        $config = '';
        include $this->config['path'].'/create-user.phtml';

        require $this->config['path'].'/layout.phtml';
        
    }
    
    public function account() {
        $error = null;
        if(!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }
        
        if(isset($_POST['updatepw']))
        {
            if(!$this->model->isValidUpdate($_POST['password'],$_POST['password_check']))
            {
                $error = $this->model->getError();
            }
            else{
                $this->model->update($_SESSION['username'], $_POST['password']);
                $error = 'Your password has been updated.';
            }
        }

        $details = $this->model->fetchByUsername($_SESSION['username']);

        include $this->config['path'].'/account.phtml';

        require $this->config['path'].'/layout.phtml';
    }
    
    public function login() {
        $error = null;
        // Do the login
        if(isset($_POST['login'])) {

            if($this->model->authenticate($_POST['user'],$_POST['pass'])) {
               $user = $this->model->fetchByUsername($_POST['user']);
               $this->model->login($user['username']);
               header("Location: /");
               exit;
            }
            else {
                $error = $this->model->getError();
            }
        }

        include $this->config['path'].'/login.phtml';

        require $this->config['path'].'/layout.phtml';
        
    }
    
    public function logout() {
        // Log out, redirect
        $this->model->logout();
        header("Location: /");
    }
}