<?php

class Question_model
{

    private $pdo;
    private $table = 'questions';
    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function getQuestionsByToId($to_id)
    {
        $query = "SELECT * FROM $this->table WHERE to_id = ?";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $to_id
        ]);
        return $this->pdo->resultSet();
    }

    public function getQuestionByPK($to_id, $question_number)
    {
        $query = "SELECT * FROM $this->table WHERE to_id = ? AND question_number = ?";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $to_id,
            1 => $question_number
        ]);
        return $this->pdo->singleSet();
    }
    public function createQuestion(
        $question_number,
        $to_id,
        $question_body,
        $question_choices,
        $answer,
        $time_created,
        $admin_username
    ) {
        $this->pdo->query("
            INSERT INTO $this->table(
                question_number,
                to_id,
                question_body,
                question_choices,
                answer,
                time_created,
                admin_username)
            VALUES
                (?,?,?,?,?,?,?);
        ");
        $this->pdo->execute([
            0 => $question_number,
            1 => $to_id,
            2 => $question_body,
            3 => $question_choices,
            4 => $answer,
            5 => $time_created,
            6 => $admin_username
        ]);
        return $this->pdo->rowCount();
    }

    public function updateQuestion(
        $question_number,
        $question_body,
        $question_choices,
        $answer,
        $to_id,
        $old_question_number
    ) {
        $query = "
            UPDATE $this->table
            SET question_number = ?, question_body = ?, question_choices = ?, answer = ?
            WHERE to_id = ? AND question_number = ?;
        ";
        $this->pdo->query($query);
        $this->pdo->execute([
            $question_number,
            $question_body,
            $question_choices,
            $answer,
            $to_id,
            $old_question_number
        ]);
        return $this->pdo->rowCount();
    }

    public function updateQBody($to_id, $question_number, $new_q_body)
    {
        $query = "
        UPDATE questions
        SET question_body = ?
        WHERE to_id = ? AND question_number = ?;
        ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $new_q_body,
            1 => $to_id,
            2 => $question_number
        ]);


        return $this->pdo->rowCount();
    }

    public function updateQNumber($to_id, $question_number, $new_q_number)
    {
        $query = "
            UPDATE $this->table
            SET question_number = ?
            WHERE to_id = ? AND question_number = ?;
        ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $new_q_number,
            1 => $to_id,
            2 => $question_number
        ]);

        $this->pdo->rowCount();
    }

    public function updateQChoices($to_id, $question_number, $new_q_choices)
    {
        $query = "
            UPDATE $this->table
            SET question_choices = ?
            WHERE to_id = ? AND question_number = ?;
        ";
        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $new_q_choices,
            1 => $to_id,
            2 => $question_number
        ]);

        $this->pdo->rowCount();
    }


    public function deleteQuestionByPK($to_id, $question_number)
    {
        $query = "
            DELETE FROM $this->table
            WHERE to_id = ? AND question_number = ?;
        ";

        $this->pdo->query($query);
        $this->pdo->execute([
            0 => $to_id,
            1 => $question_number
        ]);
        return $this->pdo->rowCount();
    }
}