<?php

namespace Peto16\Qanda\Question;

use \Peto16\Qanda\Question\QuestionStorageInterface;
use \Anax\Database\ActiveRecordModel;

/**
 * Class to communicate with the Database
 */
class QuestionActiveRecordModel extends ActiveRecordModel implements QuestionStorageInterface
{
    protected $tableName = "QandA_Question";

    public $id;
    public $userId;
    public $title;
    public $content;
    public $created;
    public $updated;
    public $deleted;



    /**
     * Method to Create a question in the database.
     *
     * @param Question     Question object
     * @return int
     */
    public function createQuestion(Question $question)
    {
        $this->setQuestionData($question);
        $this->save();
        return $this->db->lastInsertId();
    }



    /**
     * Method to read from the database. Nu param returns all unless id given.
     *
     * @param int       $commentId id for comment
     * @return array    with comments
     */
    public function readQuestion($orderBy = "id", $questionId = null, $limit = null)
    {
        $this->id = $questionId;

        $dbObj = $this->db->connect()
                        ->select("Q.id AS id,
                            U.id AS userId,
                            Q.title AS title,
                            Q.content AS content,
                            Q.created AS created,
                            Q.updated AS updated,
                            Q.deleted AS deleted,
                            U.email AS email,
                            U.firstname AS firstname,
                            U.lastname AS lastname,
                            U.administrator AS admin,
                            U.enabled AS enabled")
                        ->from($this->tableName . " AS Q")
                        ->join("ramverk1_User AS U", "Q.userId = U.id");

        $idWhere = "Q.deleted IS NULL";
        if ($questionId !== null) {
            $idWhere = $idWhere . " AND Q.id = " . $questionId;
        }
        $dbObj->where($idWhere);
        $dbObj->orderBy($orderBy);
        if ($limit !== null) {
            $dbObj->limit($limit);
        }
        return $dbObj->execute()
                     ->fetchAllClass(get_class($this));

    }



    /**
     * Method to update a question.
     *
     * @param Question     $question A Question object.
     * @return void
     */
    public function updateQuestion(Question $question)
    {
        $this->setQuestionData($question);
        $this->updated = date("Y-m-d H:i:s");
        return $this->save();
    }



    /**
     * Delete a Question
     *
     * @param int       $questionId the question id
     * @return void
     */
    public function deleteQuestion($questionId)
    {
        $this->find("id", $questionId);
        $this->deleted = date("Y-m-d H:i:s");
        return $this->save();
    }




    /**
     * Dynamicly set question properties to its value.
     *
     * @param array            $questionData Key, value array.
     */
    public function setQuestionData($questionData)
    {
        foreach ($questionData as $key => $value) {
            $this->{$key} = $value;
        }
    }



    /**
     * Dynamicly get question by field.
     *
     * @param  string               $field Fieldname to search.
     *
     * @param  mixed                $data Data to search for in the field.
     *
     * @return ActiveRecordModel    Returns a question.
     */
    public function getQuestionByField($field, $data)
    {
        return $this->find($field, $data);
    }



    public function getAllQuestionsByField($field, $data)
    {
    return $this->db->connect()
                    ->select("*")
                    ->from($this->tableName)
                    ->where($field . " = ? AND deleted IS NULL")
                    ->execute([$data])
                    ->fetchAllClass(get_class($this));
    }
}
