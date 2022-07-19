<?php

declare(strict_types=1);

class Database

    /*
     * PDO database Class
     * Connect to database
     * Create prepared statements
     * Bind values
     * Return rows and results
     */
{
    private string $host = DB_HOST;
    private string $user = DB_USER;
    private string $password = DB_PASSWORD;
    private string $db = DB_NAME;

    private PDO $dbh;
    private PDOStatement $stmt;
    private string $error;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        // Create new PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $ex) {
            $this->error = $ex->getMessage();
            echo $this->error;
        }
    }

    // Prepare  statement with query

    public function sqlQuery(string $query): void
    {
        $this->stmt = $this->dbh->prepare($query);

    }


    public function bind(string $param, mixed $value, mixed $type = null): void
    {
        if (is_null($type)) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute prepared statement
    public function execute(): bool
    {
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function getResultSet(): bool|array
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function getSingleRecord(): object
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }


    public function getRowCount(): int
    {
        return $this->stmt->rowCount();
    }


}