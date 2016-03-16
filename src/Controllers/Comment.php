<?php

namespace Masterclass\Controllers;
use Masterclass\Models\Comment as CommentModel;

class Comment {

    protected $model;

    public function __construct(CommentModel $commentModel) {
        $this->model = $commentModel;
    }
    
    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {

            header("Location: /");
            exit;
        }

        $this->model->create($_SESSION['username'], $_POST['story_id'], $_POST['comment']);

        header("Location: /story/?id=" . $_POST['story_id']);
    }
    
}