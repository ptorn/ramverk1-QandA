<?php

namespace Peto16\Qanda\Tag;

use \Peto16\Qanda\Tag\TagToQuestionStorageInterface;
use \Anax\Database\ActiveRecordModel;

/**
 * Class to communicate with the Database
 */
class TagToQuestionActiveRecordModel extends ActiveRecordModel implements TagToQuestionStorageInterface
{
    protected $tableName = "QandA_TagToQuestion";

    public $id;
    public $tagId;
    public $questionId;



    public function createTagToQuestion(TagToQuestion $tagToQuestion)
    {
        $this->setTagData($tagToQuestion);
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


    public function getAllQuestionsToTag($tagId)
    {
        return $this->findAllWhere("tagId = ?", $tagId);
    }
}
