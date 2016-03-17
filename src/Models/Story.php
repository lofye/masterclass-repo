<?php

namespace Masterclass\Models;
use Masterclass\Dbal\AbstractDb;

class Story {

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

    public function fetchOne($id)
    {
        $sql = 'SELECT * FROM story WHERE id = ?';
        return $this->db->fetchOne($sql, array($id));
    }

    public function fetchAll()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stories = $this->db->fetchAll($sql);

        foreach ($stories as $key => $story) {
            $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
            $count = $this->db->fetchOne($comment_sql, array($story['id']));
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
        $this->db->execute($sql, array($headline, $url, $username));
        return $this->db->lastInsertId();
    }
    
}