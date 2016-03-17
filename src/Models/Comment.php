<?php

namespace Masterclass\Models;
use Masterclass\Dbal\AbstractDb;

class Comment {

    /**
     * @var AbstractDb
     */
    protected $db;

    protected $config;
    protected $error;

    /**
     * @param AbstractDb $db
     */
    public function __construct(AbstractDb $db) {
        $this->db = $db;
    }

    public function fetchForStory($id)
    {
        $sql = 'SELECT * FROM comment WHERE story_id = ?';
        return $this->db->fetchAll($sql, array($id));
    }

    public function create($username, $story_id, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $result = $this->db->execute($sql, array($username, $story_id, filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
        return $this->db->lastInsertId();
    }
}