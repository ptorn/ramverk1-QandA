<?php

namespace Peto16\Qanda\Awnser;

use \Peto16\Qanda\Awnser\AwnserStorageInterface;
use \Anax\Database\ActiveRecordModel;

/**
 * Class to communicate with the Database
 */
class AwnserActiveRecordModel extends ActiveRecordModel implements AwnserStorageInterface
{
    protected $tableName = "QandA_Awnser";

    public $id;
    public $userId;
    public $title;
    public $content;
    public $created;
    public $updated;



    /**
     * Method to Create a awnser in the database.
     *
     * @param Awnser     Question object
     * @return void
     */
    public function createAwnser(Awnser $awnser)
    {
        $this->setAwnserData($awnser);
        $this->save();
    }



    /**
     * Method to read from the database. Nu param returns all unless id given.
     *
     * @param int       $awnserId id for awnser
     * @return array    with awnsers
     */
    public function readAwnser($awnserId = null)
    {
        $this->id = $awnserId;
        if ($awnserId === null) {
            return $this->db->connect()
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
                            ->join("ramverk1_User AS U", "Q.userId = U.id")
                            ->orderBy("id")
                            ->execute()
                            ->fetchAllClass(get_class($this));
        }
        return $this->db->connect()
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
                        ->join("ramverk1_User AS U", "Q.userId = U.id")
                        ->where("Q.id = " . $awnserId)
                        ->orderBy("id")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }



    /**
     * Method to update a awnser.
     *
     * @param Awnser     $anwser A Awnser object.
     * @return void
     */
    public function updateAwnser(Awnser $awnser)
    {
        $this->setAwnserData($awnser);
        $this->updated = date("Y-m-d H:i:s");
        return $this->save();
    }



    /**
     * Delete a Awnser
     *
     * @param int       $awnserId the awnser id
     * @return void
     */
    public function deleteAwnser($awnserId)
    {
        $this->find("id", $awnserId);
        $this->deleted = date("Y-m-d H:i:s");
        return $this->save();
    }




    /**
     * Dynamicly set awnser properties to its value.
     *
     * @param array            $awnserData Key, value array.
     */
    public function setAwnserData($awnserData)
    {
        foreach ($awnserData as $key => $value) {
            $this->{$key} = $value;
        }
    }



    /**
     * Dynamicly get awnser by field.
     *
     * @param  string          $field Fieldname to search.
     *
     * @param  mixed           $data Data to search for in the field.
     *
     * @return Awnser          Returns a awnser.
     */
    public function getAwnserByField($field, $data)
    {
        return $this->find($field, $data);
    }


    public function getAllByQuestionId($questionId)
    {
        $params = is_array($questionId) ? $questionId : [$questionId];
        return $this->db->connect()
                        ->select("A.id AS id,
                            A.questionId AS questionId,
                            U.id AS userId,
                            A.title AS title,
                            A.accept AS accept,
                            A.content AS content,
                            A.created AS created,
                            A.updated AS updated,
                            A.deleted AS deleted,
                            U.email AS email,
                            U.firstname AS firstname,
                            U.lastname AS lastname,
                            U.administrator AS admin,
                            U.enabled AS enabled")
                        ->from($this->tableName . " AS A")
                        ->join("ramverk1_User AS U", "A.userId = U.id")
                        ->where("questionId = ?")
                        ->orderBy("id")
                        ->execute($params)
                        ->fetchAllClass(get_class($this));
    }



    public function getAllAwnsersByField($field, $data)
    {
        return $this->findAllWhere($field, $data);
    }
}
