<?php

namespace Masterclass\Controllers;
use Masterclass\Models\Story as StoryModel;

class Index {

    protected $config;
    protected $model;
    
    public function __construct($config) {
        $this->config = $config;
        $this->model = new StoryModel($config);
    }
    
    public function index() {

        $stories = $this->model->fetchAll();

        $content = '<ol>';

        foreach($stories as $story) {
            ob_start();
            include $this->config['path'].'/story.phtml';
            $content .= ob_get_clean();
        }
        
        $content .= '</ol>';
        
        require $this->config['path'].'/layout.phtml';
    }
}

