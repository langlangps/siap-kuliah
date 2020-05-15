<?php

class Tryout_model
{
    private $tryoutTable = 'tryout';
    private $orgTable = 'organizations';
    private $pdo;

    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function getByQuery($string, $array)
    {
        $this->pdo->query($string);
        $this->pdo->execute($array);
        return $this->pdo->resultSet();
    }

    public function getAllTryOut()
    {
        $query = "
            SELECT * FROM $this->tryoutTable t, $this->orgTable o WHERE t.org_id = o.org_id
        ";
        $this->pdo->query($query);
        $this->pdo->execute();
        return $this->pdo->resultSet();
    }

    public function getTryOutById($to_id)
    {
        $query = "SELECT * FROM $this->tryoutTable WHERE to_id = ?";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $to_id]);
        return $this->pdo->singleSet();
    }

    public function getTryOutByOrgName($company_name)
    {
        $query = "SELECT * FROM $this->table WHERE company_name LIKE %?%";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $company_name]);
        return $this->pdo->resultSet();
    }

    public function getTryOutByTryOutName($to_name)
    {
        $query = "SELECT * FROM $this->table WHERE name LIKE %?%";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $to_name]);
        return $this->pdo->resultSet();
    }

    public function getTryOutByOrgId($org_id)
    {
        $query = "SELECT * FROM $this->tryoutTable WHERE org_id = ?";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $org_id]);
        return $this->pdo->resultSet();
    }

    public function insertTryOut(
        $name,
        $description,
        $date_created,
        $date_start = null,
        $date_end = null,
        $owner_id
    ) {
        try {
            $query =
                "
                INSERT INTO $this->tryoutTable(name, description, date_created, date_start, date_end, org_id)
                VALUES
                    (?,?,?,?,?,?);
            ";
            $this->pdo->query($query);
            $this->pdo->execute([
                0 => $name,
                1 => $description,
                2 => $date_created,
                3 => $date_start,
                4 => $date_end,
                5 => $owner_id
            ]);
            return $this->pdo->rowCount();
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }


    public function updateByQuery($string, $array = null)
    {
        $this->pdo->query($string);
        $this->pdo->execute($array);
        return $this->pdo->rowCount();
    }
    public function updateTryOutById(
        $to_name,
        $description,
        $date_start,
        $date_end,
        $to_id
    ) {
        $query = "
            UPDATE $this->tryoutTable
            SET name = ?, description = ?, date_start = ?,date_end = ?
            WHERE to_id = ?
        ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $to_name,
            1 => $description,
            2 => $date_start,
            3 => $date_end,
            4 => $to_id
        ]);
        return $this->pdo->rowCount();
    }
}