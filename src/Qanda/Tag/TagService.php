<?php

namespace Peto16\Qanda\Tag;

/**
 * Service class for tag.
 */
class TagService
{

    private $tagStorage;
    private $tagToQuestionStorage;


    /**
     * Constructor for TagService
     *
     * @param object            $di dependency injection.
     */
    public function __construct($di)
    {
        $this->tagStorage           = new TagStorage();
        $this->tagToQuestionStorage = new TagToQuestionStorage();
        $this->tagStorage->setDb($di->get("db"));
        $this->tagToQuestionStorage->setDb($di->get("db"));
    }



    /**
     * Add question
     *
     * @param object    $question Question object.
     *
     * @return void
     */
    public function addTag($tag)
    {
        return $this->tagStorage->createTag($tag);
    }



    public function addTagToQuestion($tagToQuestion)
    {
        $this->tagToQuestionStorage->createTagToQuestion($tagToQuestion);
    }



    public function getAllTags()
    {
        return $this->tagStorage->getAllTags();
    }


    public function getAllQuestionsToTag($tagId)
    {
        return $this->tagToQuestionStorage->getAllQuestionsToTag($tagId);
    }
}
