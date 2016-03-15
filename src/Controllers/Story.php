<?php

namespace Masterclass\Controllers;
use Masterclass\Models\Story as StoryModel;
use Masterclass\Models\Comment as CommentModel;

class Story {

    protected $config;
    protected $storyModel;

    public function __construct($config) {
        $this->config = $config;
        $this->storyModel = new StoryModel($config);
        $this->commentModel = new CommentModel($config);
    }
    
    public function index() {
        if(!isset($_GET['id'])) {
            header("Location: /");
            exit;
        }

        $story = $this->storyModel->fetchOne($_GET['id']);
        if(!$story) {
            header("Location: /");
            exit;
        }

        $comments = $this->commentModel->fetchForStory($story['id']);
        $story['count'] = count($comments);

        ob_start();
        include $this->config['path'].'/story.phtml';
        $content = ob_get_clean();

        if(isset($_SESSION['AUTHENTICATED'])) {
            include $this->config['path'].'/create-comment.phtml';
        }
        
        foreach($comments as $comment) {
            include $this->config['path'].'/comment.phtml';
        }

        require $this->config['path'].'/layout.phtml';
        
    }
    
    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }
        
        $error = '';
        if(isset($_POST['create'])) {
            if(!$this->storyModel->isValidCreate($_POST['headline'],$_POST['url'],$_SESSION['username']))
            {
                $error = $this->storyModel->getError();
            }
            else{
                $id = $this->model->create($_POST['headline'], $_POST['url'], $_SESSION['username']);
                header("Location: /story/?id=$id");
                exit;
            }
        }

        $content = '';
        include $this->config['path'].'/create-story.phtml';

        require $this->config['path'].'/layout.phtml';
    }
    
}