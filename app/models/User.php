<?php

declare(strict_types=1);

class User
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




    public function registerUser(array $data): bool
    {
        // Prepare query
        $query = 'INSERT INTO users (name, email, password) values(:name, :email, :password)';
        $this->db->sqlQuery($query);

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        // Execute and check if succeeded
        return $this->db->execute();
    }

    // Find user by email
    public function getUserByEmail(string $email): bool
    {
        // Prepare query
        $query = 'SELECT * FROM users WHERE email=:email;';
        $this->db->sqlQuery($query);

        // Bind values
        $this->db->bind(':email', $email);

        // Check if record exists
        $this->db->getSingleRecord();
        return $this->db->getRowCount() > 0;
    }

    // Login user
    public function isPasswordCorrect(string $email, string $password):bool {

        $query = 'SELECT * FROM users WHERE email = :email';
        $this->db->sqlQuery($query);
        $this->db->bind(':email', $email);

        $hashPassword = $this->db->getSingleRecord()->password;

        return password_verify($password, $hashPassword);
    }

    public function getUserById(int $id): object
    {
        // Prepare query
        $query = 'SELECT * FROM users WHERE id =:id;';
        $this->db->sqlQuery($query);

        // Bind values
        $this->db->bind(':id', $id);

        // Return user as object
       return  $this->db->getSingleRecord();

    }
}