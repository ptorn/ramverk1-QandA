<?php

namespace Peto16\Qanda\Question\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Peto16\Qanda\Question\Question;

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
        // Get values from the submitted form and create comment object.
        $question = new Question();
        $question->id = $this->form->value("id");
        $question->userId = $this->di->get("userService")->getCurrentLoggedInUser()->id;
        $question->title = $this->form->value("title");
        $question->content = $this->form->value("content");

        // Save to storage
        $this->di->get("questionService")->editQuestion($question);

        $this->form->addOutput("Fråga uppdaterad.");
        $this->di->get("utils")->redirect("question");
    }
}
