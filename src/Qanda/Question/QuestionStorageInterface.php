<?php

namespace Peto16\Qanda\Question;

/**
 * Interface for QuestionStorage
 */
interface QuestionStorageInterface
{
    public function createQuestion(Question $question);
    public function deleteQuestion($questionId);
    public function updateQuestion(Question $question);
    public function readQuestion($questionId = null);
    public function getQuestionByField($field, $data);
}
