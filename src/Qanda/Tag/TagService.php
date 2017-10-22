<?php

namespace Peto16\Qanda\Tag;

/**
 * Service class for tag.
 */
class TagService
{

    private $tagStorage;
    // private $session;
    // private $userService;
    // private $comService;
    // private $awnser;


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

        // $this->comService       = $di->get("commentService");
        // $this->awnserService    = $di->get("awnserService");
        // $this->session          = $di->get("session");
        // $this->userService      = $di->get("userService");
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
