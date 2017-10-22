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
     * @return int
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
     * @param  string               $field Fieldname to search.
     *
     * @param  mixed                $data Data to search for in the field.
     *
     * @return ActiveRecordModel    Returns a tag.
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
