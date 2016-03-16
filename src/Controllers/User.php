<?php

namespace Masterclass\Controllers;
use Masterclass\Models\User as UserModel;

class User {

    protected $model;

    public function __construct(UserModel $userModel) {
        $this->model = $userModel;
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
                $id = $this->model->create($_POST['username'],$_POST['email'],$_POST['password']);
                header("Location: /user/login");
                exit;
            }
        }

        // Show the create form
        $config = '';
        require __DIR__.'/../../src/Views/create-user.phtml';

        require __DIR__.'/../../src/Views/layout.phtml';
        
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

        require __DIR__.'/../../src/Views/account.phtml';

        require __DIR__.'/../../src/Views/layout.phtml';
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

        require __DIR__.'/../../src/Views/login.phtml';

        require __DIR__.'/../../src/Views/layout.phtml';
        
    }
    
    public function logout() {
        // Log out, redirect
        $this->model->logout();
        header("Location: /");
    }
}