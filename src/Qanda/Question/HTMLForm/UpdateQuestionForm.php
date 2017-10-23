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
class UpdateQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);
        $question = $di->get("questionService")->getQuestionByField("id", $id);
        $tags = $di->get("tagService")->getAllTagsToQuestion($id);
        $stringTag = "";
        foreach ($tags as $tag) {
            $stringTag .= $tag->name . ",";
        }
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Redigera fråga",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $question->id
                ],

                "title" => [
                    "label"       => "Titel",
                    "type"        => "text",
                    "value"       => htmlspecialchars($question->title, ENT_QUOTES, 'UTF-8')
                ],

                "content" => [
                    "label"       => "Kommentar",
                    "type"        => "textarea",
                    "value"       => htmlspecialchars($question->content)

                ],

                "tags" => [
                    "description" => "Kommaseparerad lista",
                    "label"       => "Taggar",
                    "type"        => "text",
                    "value"       => htmlspecialchars(rtrim($stringTag, ","))
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Uppdatera",
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
        $tagService = $this->di->get("tagService");
        $questionStored = $this->di->get("questionService")->getQuestion($this->form->value("id"));

        // Get values from the submitted form and create comment object.
        $question = new Question();
        $question->id = $this->form->value("id");
        $question->userId = $this->di->get("userService")->getCurrentLoggedInUser()->id;
        $question->title = $this->form->value("title");
        $question->content = $this->form->value("content");
        $question->created = $questionStored->created;

        $tagService->deleteAllTagsToQuestion($question->id);

        // Save to storage
        $this->di->get("questionService")->editQuestion($question);

        $tags = explode(",", $this->form->value("tags"));
        foreach ($tags as $tag) {
            if ($tag === "") {
                continue;
            }
            $newTag = new Tag();
            $newTag->name = trim($tag);
            $tagId = $tagService->addTag($newTag);
            $tagToQuestion = new TagToQuestion();
            $tagToQuestion->tagId = $tagId;
            $tagToQuestion->questionId = $question->id;
            $tagService->addTagToQuestion($tagToQuestion);
        }




        $this->form->addOutput("Fråga uppdaterad.");
        $this->di->get("utils")->redirect("question");
    }
}
