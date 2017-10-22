<?php

namespace Peto16\Qanda\Tag;

/**
 * Interface for TagStorage
 */
interface TagStorageInterface
{
    public function createTag(Tag $tag);
    public function getTagByField($field, $data);
    public function getAllTags();
}
