<?php

namespace Masterclass\Controllers;
use Masterclass\Models\Story as StoryModel;
use Masterclass\Models\Comment as CommentModel;

class Story {

    protected $storyModel;
    protected $commentModel;

    public function __construct(StoryModel $storyModel, CommentModel $commentModel) {
        $this->storyModel = $storyModel;
        $this->commentModel = $commentModel;
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
        require __DIR__.'/../../src/Views/story.phtml';
        $content = ob_get_clean();

        if(isset($_SESSION['AUTHENTICATED'])) {
            require __DIR__.'/../../src/Views/create-comment.phtml';
        }
        
        foreach($comments as $comment) {
            require __DIR__.'/../../src/Views/comment.phtml';
        }

        require __DIR__.'/../../src/Views/layout.phtml';
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
                $id = $this->storyModel->create($_POST['headline'], $_POST['url'], $_SESSION['username']);
                header("Location: /story/?id=$id");
                exit;
            }
        }

        $content = '';
        require __DIR__.'/../../src/Views/create-story.phtml';

        require __DIR__.'/../../src/Views/layout.phtml';
    }
    
}