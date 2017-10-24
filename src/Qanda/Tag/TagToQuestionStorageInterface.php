<?php

namespace Peto16\Qanda\Tag;

/**
 * Interface for TagToQuestionStorage
 */
interface TagToQuestionStorageInterface
{
    public function createTagToQuestion(TagToQuestion $tagToQuestion);
    public function getTagByField($field, $data);
    public function getAllQuestionsToTag($tagId);
    public function getAllTagsToQuestion($questionId);
    public function deleteAllTagsToQuestion($questionId);
}
