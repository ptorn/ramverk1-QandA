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
     * @return int
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



    /**
     * Dynamicly get question by propertie.
     *
     * @param string            $field field to search by.
     *
     * @param array             $data to search for.
     *
     * @return Question
     *
     */
    public function getTagByField($field, $data)
    {
        $tag           = new Tag();
        $tagVarArray   = get_object_vars($tag);
        $tagData       = $this->tagStorage->getTagByField($field, $data);

        $arrayKeys = array_keys($tagVarArray);
        foreach ($arrayKeys as $key) {
            $tag->{$key} = $tagData->$key;
        }
        return $tag;
    }



    public function getAllQuestionsToTag($tagId)
    {
        return $this->tagToQuestionStorage->getAllQuestionsToTag($tagId);
    }



    public function getMostPopularTags()
    {
        $allTags = $this->getAllTags();
        $mostPopular = [];
        foreach ($allTags as $tag) {
            $questions = $this->getAllQuestionsToTag($tag->id);
            $mostPopular[$tag->name] = sizeof($questions);
        }
        arsort($mostPopular, SORT_NUMERIC);
        return $mostPopular;
    }



    public function getTagByName($name)
    {

    }
}
