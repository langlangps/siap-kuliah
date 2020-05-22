<?php

class Database
{
    // KONSTANTA DATABASE DI DEFINE DI ../config/config.php
    // Jika ingin melakukan perubahan database, lakukan perubahan tersebut di file config.php
    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;

    private $statement;
    private $dbh;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $option = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];


        try {
            $this->dbh = new PDO($dsn, $this->username, $this->password, $option);
        } catch (Throwable $th) {
            die($th->getMessage());
        }
    }

    public function query($stm)
    {
        $this->statement = $this->dbh->prepare($stm);
    }

    public function execute($array = null)
    {
        $this->statement->execute($array);
    }

    public function resultSet()
    {
        return $this->statement->fetchAll();
    }

    public function singleSet()
    {
        return $this->statement->fetch();
    }

    public function rowCount()
    {
        return $this->statement->rowCount();
    }
}