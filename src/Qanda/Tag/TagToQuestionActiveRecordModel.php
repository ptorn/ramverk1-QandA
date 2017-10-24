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
        $storedTags = $this->getAllTagsToQuestion($tagToQuestion->questionId);
        foreach ($storedTags as $tag) {
            if ($tag->tagId === $tagToQuestion->tagId) {
                return $tag->tagId;
            }
        }
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


    //
    // public function getAllTags()
    // {
    //     return $this->findAll();
    // }


    public function getAllQuestionsToTag($tagId)
    {
        return $this->db->connect()
                ->select("T2Q.id AS id,
                    T.id AS tagId,
                    T2Q.questionId AS questionId,
                    T.name AS name,
                    Q.deleted AS deleted")
                ->from($this->tableName . " AS T2Q")
                ->join("QandA_Tag AS T", "T2Q.tagId = T.id")
                ->join("QandA_Question AS Q", "T2Q.questionId = Q.id")
                ->where("tagId = ? AND deleted IS NULL")
                ->execute([$tagId])
                ->fetchAllClass(get_class($this));
    }


    public function getAllTagsToQuestion($questionId)
    {
        return $this->db->connect()
                ->select("T2Q.tagId AS tagId,
                    T2Q.questionId AS questionId,
                    T.name AS name")
                ->from($this->tableName . " AS T2Q")
                ->join("QandA_Tag AS T", "T2Q.tagId = T.id")
                ->where("questionId = ?")
                ->execute([$questionId])
                ->fetchAllClass(get_class($this));
    }



    public function deleteAllTagsToQuestion($questionId)
    {
        return $this->db->connect()
                ->deleteFrom($this->tableName)
                ->where("questionId = ?")
                ->execute([$questionId])
                ->fetchAllClass(get_class($this));
    }
}
