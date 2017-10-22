<?php

namespace Peto16\Qanda\Question\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Peto16\Qanda\Question\Question;
use \Peto16\Qanda\Tag\Tag;
use \Peto16\Qanda\Tag\TagToQuestion;

/**
 * Example of FormModel implementation.
 */
class CreateQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Lägg till Fråga",
            ],
            [
                "title" => [
                    "label"       => "Titel",
                    "type"        => "text",
                ],

                "content" => [
                    "label"       => "Fråga",
                    "type"        => "textarea",
                ],

                "tags" => [
                    "description" => "Kommaseparerad lista",
                    "label"       => "Taggar",
                    "type"        => "text",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Lägg till",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form and create comment object.
        $question = new Question();
        $question->userId = $this->di->get("userService")->getCurrentLoggedInUser()->id;
        $question->title = $this->form->value("title");
        $question->content = $this->form->value("content");

        // Save to database
        $questionId = $this->di->get("questionService")->addQuestion($question);

        $tags = explode(",", $this->form->value("tags"));
        foreach ($tags as $tag) {
            if ($tag === "") {
                continue;
            }
            $newTag = new Tag();
            $newTag->name = trim($tag);
            $tagId = $this->di->get("tagService")->addTag($newTag);
            $tagToQuestion = new TagToQuestion();
            $tagToQuestion->tagId = $tagId;
            $tagToQuestion->questionId = $questionId;
            $this->di->get("tagService")->addTagToQuestion($tagToQuestion);
        }

        $this->form->addOutput("Fråga skapad.");
        return true;
    }
}
