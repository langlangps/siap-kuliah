<?php

class Participant_model
{
    private $pdo;
    private $table = 'participant';
    private $tablePrtcTO = 'participant_tos';

    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function getParticipantByUsername($username)
    {
        $query = "SELECT * FROM $this->table WHERE username = ?";
        $this->pdo->query($query);
        $this->pdo->execute([0 => $username]);
        return $this->pdo->singleSet();
    }

    public function insertParticipant(
        $name,
        $gender,
        $email,
        $username
    ) {
        $query =
            "
                INSERT INTO $this->table (name, gender, email, username)
                VALUES
                    (?,?,?,?);
            ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $name,
            1 => $gender,
            2 => $email,
            3 => $username
        ]);
    }

    public function updateParticipant(
        $name,
        $gender,
        $age,
        $email,
        $address,
        $school_name,
        $motto,
        $username
    ) {
        $query =
            "
            UPDATE $this->table
            SET 
                name = ?,
                gender = ?,
                age = ?,
                email = ?,
                address = ?,
                school_name = ?,
                motto = ?
            WHERE 
                username = ?
        ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $name,
            1 => $gender,
            2 => $age,
            3 => $email,
            4 => $address,
            5 => $school_name,
            6 => $motto,
            7 => $username
        ]);

        return $this->pdo->rowCount();
    }


    public function getParticipantTOsByUsername($username)
    {
        $query = "SELECT * FROM $this->tablePrtcTO WHERE username=?;";
        $this->pdo->query($query);
        $this->pdo->execute([$username]);
        return $this->pdo->resultSet();
    }

    public function getParticipantTOsByPK($username, $to_id)
    {
        $query = "SELECT * FROM $this->tablePrtcTO WHERE username=? AND to_id=?;";
        $this->pdo->query($query);
        $this->pdo->execute([$username, $to_id]);
        return $this->pdo->singleSet();
    }
    public function insertParticipantTO($to_id, $username, $date_get_to)
    {
        $query = "INSERT INTO $this->tablePrtcTO(to_id, username, date_get_to) VALUES (?,?,?);";
        $this->pdo->query($query);
        $this->pdo->execute([
            $to_id,
            $username,
            $date_get_to
        ]);
        return $this->pdo->rowCount();
    }
    public function deleteParticipantTo($username, $to_id)
    {
        $query = "DELETE FROM $this->tablePrtcTO WHERE username = ? AND to_id = ?";
        $this->pdo->query($query);
        $this->pdo->execute([
            $username,
            $to_id
        ]);
        return $this->pdo->rowCount();
    }
}