<?php

class Org_model
{
    private $pdo;
    private $table = 'organizations';

    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function insertOrg($org_name, $estab_date, $org_email, $password)
    {
        $query = "
            INSERT INTO $this->table(org_name, estab_date, org_email, password)
            VALUES 
                (?,?,?,?);
        ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $org_name,
            1 => $estab_date,
            2 => $org_email,
            3 => $password
        ]);

        return $this->pdo->rowCount();
    }

    public function getByQuery($query, $array)
    {
        $this->pdo->query($query);
        $this->pdo->execute($array);
        return $this->pdo->resultSet();
    }

    public function getOrgByName($org_name)
    {
        $query = "SELECT * FROM $this->table WHERE org_name = ?";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $org_name]);
        return $this->pdo->singleSet();
    }

    public function getOrgById($org_id)
    {
        $query = "SELECT * FROM $this->table WHERE org_id = ?";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $org_id]);
        return $this->pdo->singleSet();
    }

    public function getOrgPassword($org_id)
    {
        $query = "SELECT password FROM $this->table WHERE org_id = ?";
        $this->pdo->query(($query));
        $this->pdo->execute(
            [0 => $org_id]
        );
        return $this->pdo->singleSet();
    }

    public function updateOrgDetail($org_name, $org_email, $estab_date, $org_id)
    {
        $query = "
            UPDATE $this->table
            SET org_name = ?, org_email = ?, estab_date = ?
            WHERE org_id = ?
        ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $org_name,
            1 => $org_email,
            2 => $estab_date,
            3 => $org_id
        ]);
        return $this->pdo->rowCount();
    }

    public function updateOrgPassword($password, $org_id)
    {
        $query = "
            UPDATE $this->table
            SET password = ?
            WHERE org_id = ?
        ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $password,
            1 => $org_id
        ]);
        return $this->pdo->rowCount();
    }

    public function deleteOrg($org_id)
    {
        $query = "DELETE FROM $this->table WHERE org_id = ?";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $org_id]);
    }
}