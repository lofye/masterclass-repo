<?php

namespace Masterclass\Controllers;
use Masterclass\Models\Story as StoryModel;

class Index {

    protected $model;
    
    public function __construct(StoryModel $storyModel) {
        $this->model = $storyModel;
    }
    
    public function index() {

        $stories = $this->model->fetchAll();

        $content = '<ol>';

        foreach($stories as $story) {
            ob_start();
            require __DIR__.'/../../src/Views/story.phtml';
            $content .= ob_get_clean();
        }
        
        $content .= '</ol>';
        
        require __DIR__.'/../../src/Views/layout.phtml';
    }
}

