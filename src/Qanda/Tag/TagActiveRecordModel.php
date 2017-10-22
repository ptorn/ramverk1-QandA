<?php

namespace Peto16\Qanda\Tag;

use \Peto16\Qanda\Tag\TagStorageInterface;
use \Anax\Database\ActiveRecordModel;

/**
 * Class to communicate with the Database
 */
class TagActiveRecordModel extends ActiveRecordModel implements TagStorageInterface
{
    protected $tableName = "QandA_Tag";

    public $id;
    public $name;



    /**
     * Method to Create a tag in the database.
     *
     * @param Tag     Tag object
     * @return void
     */
    public function createTag(Tag $tag)
    {
        if ($this->find("name", $tag->name)) {
            return $this->id;
        }
        $this->setTagData($tag);
        $this->save();
        return $this->db->lastInsertId();
    }



    // /**
    //  * Method to read from the database. Nu param returns all unless id given.
    //  *
    //  * @param int       $awnserId id for awnser
    //  * @return array    with awnsers
    //  */
    // public function readAwnser($awnserId = null)
    // {
    //     $this->id = $awnserId;
    //     if ($awnserId === null) {
    //         return $this->db->connect()
    //                         ->select("Q.id AS id,
    //                             U.id AS userId,
    //                             Q.title AS title,
    //                             Q.content AS content,
    //                             Q.created AS created,
    //                             Q.updated AS updated,
    //                             Q.deleted AS deleted,
    //                             U.email AS email,
    //                             U.firstname AS firstname,
    //                             U.lastname AS lastname,
    //                             U.administrator AS admin,
    //                             U.enabled AS enabled")
    //                         ->from($this->tableName . " AS Q")
    //                         ->join("ramverk1_User AS U", "Q.userId = U.id")
    //                         ->orderBy("id")
    //                         ->execute()
    //                         ->fetchAllClass(get_class($this));
    //     }
    //     return $this->db->connect()
    //                     ->select("Q.id AS id,
    //                         U.id AS userId,
    //                         Q.title AS title,
    //                         Q.content AS content,
    //                         Q.created AS created,
    //                         Q.updated AS updated,
    //                         Q.deleted AS deleted,
    //                         U.email AS email,
    //                         U.firstname AS firstname,
    //                         U.lastname AS lastname,
    //                         U.administrator AS admin,
    //                         U.enabled AS enabled")
    //                     ->from($this->tableName . " AS Q")
    //                     ->join("ramverk1_User AS U", "Q.userId = U.id")
    //                     ->where("Q.id = " . $awnserId)
    //                     ->orderBy("id")
    //                     ->execute()
    //                     ->fetchAllClass(get_class($this));
    // }



    /**
     * Dynamicly set tag properties to its value.
     *
     * @param array            $tagData Key, value array.
     */
    public function setTagData($tagData)
    {
        foreach ($tagData as $key => $value) {
            $this->{$key} = $value;
        }
    }



    /**
     * Dynamicly get tag by field.
     *
     * @param  string          $field Fieldname to search.
     *
     * @param  mixed           $data Data to search for in the field.
     *
     * @return Tag             Returns a tag.
     */
    public function getTagByField($field, $data)
    {
        return $this->find($field, $data);
    }



    public function getAllTags()
    {
        return $this->findAll();
    }
}
