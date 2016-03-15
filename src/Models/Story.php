<?php

namespace Masterclass\Models;
use PDO;

class Story {

    protected $db;
    protected $config;

    public function __construct($config) {
        $this->config = $config;
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function fetchOne($id)
    {
        $sql = 'SELECT * FROM story WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($stories as $key => $story) {
            $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
            $comment_stmt = $this->db->prepare($comment_sql);
            $comment_stmt->execute(array($story['id']));
            $count = $comment_stmt->fetch(PDO::FETCH_ASSOC);
            $stories[$key]['count'] = $count['count'];
        }

        return $stories;
    }

    public function isValidCreate($headline=null,$url=null,$username=null)
    {
        if(empty($headline) || empty($url) || !filter_var($url, FILTER_VALIDATE_URL))
        {
            $this->error = 'You did not fill in all the fields or the URL did not validate.';
            return false;
        }
        return true;
    }

    public function create($headline, $url, $username)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($headline, $url, $username));
        return $this->db->lastInsertId();
    }
    
}