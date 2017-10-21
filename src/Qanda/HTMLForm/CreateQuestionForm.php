<?php

namespace Peto16\Qanda\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Peto16\Qanda\Question;

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
        $this->di->get("questionService")->addQuestion($question);

        $this->form->addOutput("Fråga skapad.");
        return true;
    }
}
