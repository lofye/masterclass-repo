<?php

namespace Masterclass\Models;
use PDO;

class Comment {

    protected $db;
    protected $config;

    public function __construct($config) {
        $this->config = $config;
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function fetchForStory($id)
    {
        $sql = 'SELECT * FROM comment WHERE story_id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($username, $story_id, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($username, $story_id, filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
        return $this->db->lastInsertId();
    }
}