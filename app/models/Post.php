<?php

declare(strict_types=1);

class Post
{

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @return Database
     */
    public function getDb(): Database
    {
        return $this->db;
    }

    public function getPosts(): array|object
    {
        $query = 'SELECT *,
                    p.id AS post_id,
                    u.id AS user_id,
                    p.created_at AS post_created_at,
                    u.created_at AS user_created_at
                        FROM posts p 
                        JOIN users u ON p.user_id = u.id  
                        ORDER BY post_created_at DESC;';
        $this->db->sqlQuery($query);

        return $this->db->getResultSet();
    }

    public function addPost(array $data): bool
    {
        $query = "INSERT INTO posts (user_id, title, body) values(:user_id, :title, :body);";
        $this->db->sqlQuery($query);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);


        return $this->db->execute();
    }

    public function getPost(string $id): bool|object
    {
        $query = "SELECT * FROM posts WHERE id = :id;";
        $this->db->sqlQuery($query);
        $this->db->bind('id', $id);

        return $this->db->getSingleRecord();

    }

    public function updatePost(array $data): bool {
        $query = 'UPDATE posts SET title = :title, body = :body WHERE id = :id';
        $this->db->sqlQuery($query);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':id', $data['id']);

        return $this->db->execute();
    }

    public function deletePost(string $id): bool {
        $query = 'DELETE FROM posts WHERE id = :id;';
        $this->db->sqlQuery($query);
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

}