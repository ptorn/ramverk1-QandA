<?php

namespace Peto16\Qanda\Awnser\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Peto16\Qanda\Awnser\Awnser;

/**
 * Example of FormModel implementation.
 */
class CreateAwnserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $questionId)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Lägg till svar",
            ],
            [
                "questionId" => [
                    "label"       => "QuestionId",
                    "type"        => "hidden",
                    "value"       => $questionId
                ],

                "title" => [
                    "label"       => "Titel",
                    "type"        => "text",
                    "required"    => "required"
                ],

                "content" => [
                    "label"       => "Svar",
                    "type"        => "textarea",
                    "required"    => "required"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Svara",
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
        $awnser = new Awnser();
        $awnser->userId = $this->di->get("userService")->getCurrentLoggedInUser()->id;
        $awnser->title = $this->form->value("title");
        $awnser->content = $this->form->value("content");
        $awnser->questionId = $this->form->value("questionId");


        // Save to database
        $this->di->get("awnserService")->addAwnser($awnser);

        $this->form->addOutput("Svar skapat.");
        return true;
    }
}
