<?php

class Admin_model
{
    private $pdo;
    private $table = 'admin';

    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function getByQuery($string, $array = null)
    {
        $this->pdo->query($string);
        $this->pdo->execute($array);
        return $this->pdo->resultSet();
    }
    public function getAdminByPK($org_id, $username)
    {
        $query = "SELECT * FROM $this->table WHERE org_id = ? AND username = ?";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $org_id, 1 => $username]);
        return $this->pdo->singleSet();
    }
    public function getAdminByAdminUsername($username)
    {
        $query = "SELECT * FROM $this->table WHERE username = ?";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $username]);
        return $this->pdo->resultSet();
    }

    public function getAdminByOrgId($org_id)
    {
        $query = "SELECT * FROM $this->table WHERE org_id = ?";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $org_id]);
        return $this->pdo->resultSet();
    }

    public function insertAdmin(
        $id = null,
        $org_id,
        $name,
        $email,
        $username,
        $role
    ) {
        $query =
            "
                INSERT INTO $this->table (id, org_id, name, email, username, role)
                VALUES
                    (?,?,?,?,?,?);
            ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $id,
            1 => $org_id,
            2 => $name,
            3 => $email,
            4 => $username,
            5 => $role
        ]);
        return $this->pdo->rowCount();
    }

    public function updateAdmin(
        $id,
        $org_id,
        $name,
        $email,
        $username
    ) {
        $query =
            "
            UPDATE $this->table
            SET 
                id = ?,
                org_id = ?,
                name = ?,
                email = ?,
                username=?
            WHERE 
                id = ? AND org_id = ?;
        ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $id,
            1 => $org_id,
            2 => $name,
            3 => $email,
            4 => $username,
            5 => $id,
            6 => $org_id,
        ]);

        return $this->pdo->rowCount();
    }
}