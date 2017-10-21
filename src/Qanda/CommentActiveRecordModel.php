<?php

namespace Peto16\Qanda;

use \Peto16\Qanda\CommentStorageInterface;
use \Anax\Database\ActiveRecordModel;

/**
 * Class to communicate with the Database
 */
class CommentActiveRecordModel extends ActiveRecordModel implements CommentStorageInterface
{
    protected $tableName = "QandA_Comment";

    public $id;
    public $questionId;
    public $parentComId;
    public $userId;
    public $title;
    public $accept;
    public $comment;
    public $published;
    public $created;
    public $updated;



    /**
     * Method to Create a comment in the database.
     *
     * @param array     $data userid, title, comment
     * @return void
     */
    public function createComment(Comment $comment)
    {
        $this->setCommentData($comment);
        $this->save();
    }



    /**
     * Method to read from the database. Nu param returns all unless id given.
     *
     * @param int       $commentId id for comment
     * @return array    with comments
     */
    public function readComment($commentId = null)
    {
        $this->id = $commentId;
        if ($commentId === null) {
            return $this->db->connect()
                            ->select("C.id AS id,
                                C.questionId AS questionId,
                                C.parentComId AS parentComId,
                                U.id AS userId,
                                C.title AS title,
                                C.accept AS accept,
                                C.comment AS comment,
                                C.created AS created,
                                C.updated AS updated,
                                C.deleted AS deleted,
                                U.email AS email,
                                U.firstname AS firstname,
                                U.lastname AS lastname,
                                U.administrator AS admin,
                                U.enabled AS enabled")
                            ->from($this->tableName . " AS C")
                            ->join("ramverk1_User AS U", "C.userId = U.id")
                            ->orderBy("id")
                            ->execute()
                            ->fetchAllClass(get_class($this));
        }
        return $this->db->connect()
                        ->select("C.id AS id,
                            C.questionId AS questionId,
                            C.parentComId AS parentComId,
                            U.id AS userId,
                            C.title AS title,
                            C.accept AS accept,
                            C.comment AS comment,
                            C.created AS created,
                            C.updated AS updated,
                            C.deleted AS deleted,
                            U.email AS email,
                            U.firstname AS firstname,
                            U.lastname AS lastname,
                            U.administrator AS admin,
                            U.enabled AS enabled")
                        ->from($this->tableName . " AS C")
                        ->join("ramverk1_User AS U", "C.userId = U.id")
                        ->where("id = " . $commentId)
                        ->orderBy("id")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }



    /**
     * Method to update comments.
     *
     * @param array     $data comment, title, commentId
     * @return void
     */
    public function updateComment(Comment $comment)
    {
        $this->setCommentData($comment);
        $this->updated = date("Y-m-d H:i:s");
        return $this->save();
    }



    /**
     * Delete a comment
     *
     * @param int       $commentId the comments id
     * @return void
     */
    public function deleteComment($commentId)
    {
        $this->find("id", $commentId);
        $this->deleted = date("Y-m-d H:i:s");
        return $this->save();
    }




    /**
     * Dynamicly set comment properties to its value.
     *
     * @param array            $userData Key, value array.
     */
    public function setCommentData($commentData)
    {
        foreach ($commentData as $key => $value) {
            $this->{$key} = $value;
        }
    }



    /**
     * Dynamicly get comment by field.
     *
     * @param  string          $field Fieldname to search.
     *
     * @param  mixed           $data Data to search for in the field.
     *
     * @return Comment            Returns a user.
     */
    public function getCommentByField($field, $data)
    {
        return $this->find($field, $data);
    }
}
