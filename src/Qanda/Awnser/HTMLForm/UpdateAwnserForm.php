<?php

namespace Peto16\Qanda\Awnser\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Peto16\Qanda\Awnser\Awnser;

/**
 * Example of FormModel implementation.
 */
class UpdateAwnserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $questionId, $awnserId)
    {
        parent::__construct($di);
        $awnser = $di->get("awnserService")->getAwnserByField("id", $awnserId);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Redigera svar",
            ],
            [
                "questionId" => [
                    "type"  => "hidden",
                    "value" => $questionId
                ],

                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $awnser->id
                ],

                "title" => [
                    "label"       => "Titel",
                    "type"        => "text",
                    "value"       => htmlspecialchars($awnser->title)
                    "required"    => "required"
                ],

                "content" => [
                    "label"       => "Kommentar",
                    "type"        => "textarea",
                    "value"       => htmlspecialchars($awnser->content)
                    "required"    => "required"
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
        $awnser = new Awnser();
        $awnser->id = $this->form->value("id");
        $awnser->userId = $this->di->get("userService")->getCurrentLoggedInUser()->id;
        $awnser->title = $this->form->value("title");
        $awnser->content = $this->form->value("content");

        $questionId = $this->form->value("questionId");

        // Save to storage
        $this->di->get("awnserService")->editAwnser($awnser);

        $this->form->addOutput("Svaret uppdaterat.");
        $this->di->get("utils")->redirect("question/" . $questionId);
    }
}
