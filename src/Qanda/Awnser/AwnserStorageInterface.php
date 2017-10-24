<?php

namespace Peto16\Qanda\Awnser;

/**
 * Interface for AwnserStorage
 */
interface AwnserStorageInterface
{
    public function createAwnser(Awnser $awnser);
    public function deleteAwnser($awnserId);
    public function updateAwnser(Awnser $awnser);
    public function readAwnser($awnserId = null);
    public function getAwnserByField($field, $data);
    public function getAllByQuestionId($questionId);
    public function getAllAwnsersByField($field, $data);
}
