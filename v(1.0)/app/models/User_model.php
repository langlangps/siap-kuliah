<?php

class User_model
{
    private $table = 'user';
    private $pdo;
    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function userRegistry($username, $password, $name, $gender, $email)
    {
        $this->pdo->query("INSERT INTO user (username, password, name, gender, email)
                            VALUES
                            (?,?,?,?);");
        $this->pdo->execute([
            1 => $username,
            2 => $password,
            3 => $name,
            4 => $gender,
            5 => $email
        ]);

        return $this->pdo->rowCount();
    }

    public function getUserByUsername($username)
    {
        $this->pdo->query("SELECT * FROM $this->table WHERE username = ?");
        $this->pdo->execute([0 => $username]);
        return $this->pdo->singleSet();
    }

    public function getUserById($user_id)
    {
        $this->pdo->query("SELECT * FROM $this->table WHERE id = ?");
        $this->pdo->execute([0 => $user_id]);
        return $this->pdo->singleSet();
    }

    public function insertUser(
        $username,
        $password,
        $date_joined,
        $role
    ) {
        $query =
            "
            INSERT INTO user (username, password, date_joined, role)
            VALUES   
                (? , ?, ?, ?);
            ";
        $this->pdo->query($query);
        $this->pdo->execute(
            [
                0 => $username,
                1 => $password,
                2 => $date_joined,
                3 => $role
            ]
        );
        return $this->pdo->rowCount();
    }

    public function updateUsername($newUsername, $user_id)
    {
        $this->pdo->query("
            UPDATE $this->table 
            SET username = ?
            WHERE id = ?;
        ");
        $this->pdo->execute([
            0 => $newUsername,
            1 => $user_id
        ]);
        return $this->pdo->rowCount();
    }

    public function updatePassword($newPassword, $user_id)
    {
        $this->pdo->query("
            UPDATE $this->table
            SET password = ?
            WHERE id = ?;
        ");
        $this->pdo->execute([
            0 => $newPassword,
            1 => $user_id
        ]);
        return $this->pdo->rowCount();
    }
}