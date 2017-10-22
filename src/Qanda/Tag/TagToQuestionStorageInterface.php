<?php

namespace Peto16\Qanda\Tag;

/**
 * Interface for TagToQuestionStorage
 */
interface TagToQuestionStorageInterface
{
    public function createTagToQuestion(TagToQuestion $tagToQuestion);
}
