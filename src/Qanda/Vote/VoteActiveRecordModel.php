<?php

namespace Peto16\Qanda\Vote;

use \Peto16\Qanda\Vote\VoteStorageInterface;
use \Anax\Database\ActiveRecordModel;

/**
 * Class to communicate with the Database
 */
class VoteActiveRecordModel extends ActiveRecordModel implements VoteStorageInterface
{
    protected $tableName = "QandA_Vote";

    public $id;
    public $questionId;
    public $awnserId;
    public $commentId;
    public $userId;
    public $vote;



    /**
     * Method to Create a vote in the database.
     *
     * @param Vote     Vote object
     * @return int
     */
    public function createVote(Vote $vote)
    {
        $this->setVoteData($vote);
        $this->save();
        return $this->db->lastInsertId();
    }



    /**
     * Dynamicly set vote properties to its value.
     *
     * @param array            $voteData Key, value array.
     */
    public function setVoteData($voteData)
    {
        foreach ($voteData as $key => $value) {
            $this->{$key} = $value;
        }
    }



    /**
     * Dynamicly get vote by field.
     *
     * @param  string               $field Fieldname to search.
     *
     * @param  mixed                $data Data to search for in the field.
     *
     * @return ActiveRecordModel    Returns a vote.
     */
    public function getVoteByField($field, $data)
    {
        return $this->find($field, $data);
    }



    /**
     * Check if user voted.
     * @param  string $type   [description]
     * @param  [type] $typeId [description]
     * @param  [type] $userId [description]
     * @return [type]         [description]
     */
    public function checkIfUserVoted($type, $typeId, $userId)
    {
        return $this->db->connect()
                ->select("*")
                ->from($this->tableName)
                ->where($type . " = ? AND userId = ?")
                ->execute([$typeId, $userId])
                ->fetchAllClass(get_class($this));
    }



    /**
     * Get all votes by field
     * @param  string       $field string with field
     * @param  mixed        $data  data to search for
     * @return array        array with all votes
     */
    public function getAllVotesByField($field, $data)
    {
        return $this->db->connect()
                ->select("*")
                ->from($this->tableName)
                ->where($field . " = ?")
                ->execute([$data])
                ->fetchAllClass(get_class($this));
    }



    /**
     * Get all votes up
     * @param  string       $field field to search
     * @param  mixed        $data  data to find
     * @return array        array with all votes thumbs up
     */
    public function getAllVotesUp($field, $data)
    {
        return $this->db->connect()
                ->select("*")
                ->from($this->tableName)
                ->where($field . " = ? AND vote = 1")
                ->execute([$data])
                ->fetchAllClass(get_class($this));
    }



    /**
     * Get all votes down
     * @param  string       $field field to search
     * @param  mixed        $data  data to find
     * @return array        array with all votes thumbs down
     */
    public function getAllVotesDown($field, $data)
    {
        return $this->db->connect()
                ->select("*")
                ->from($this->tableName)
                ->where($field . " = ? AND vote = 0")
                ->execute([$data])
                ->fetchAllClass(get_class($this));
    }
}
