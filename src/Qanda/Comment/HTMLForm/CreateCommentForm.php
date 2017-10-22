<?php

namespace Peto16\Qanda\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Peto16\Qanda\Comment\Comment;

/**
 * Example of FormModel implementation.
 */
class CreateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $questionId, $awnserId)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Lägg till kommentar",
            ],
            [
                "questionId" => [
                    "type"        => "hidden",
                    "value"       => $questionId
                ],

                "awnserId" => [
                    "type"        => "hidden",
                    "value"       => $awnserId
                ],

                "title" => [
                    "label"       => "Titel",
                    "type"        => "text",
                ],

                "content" => [
                    "label"       => "Kommentar",
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
        $comment = new Comment();
        $comment->userId = $this->di->get("userService")->getCurrentLoggedInUser()->id;
        $comment->title = $this->form->value("title");
        $comment->content = $this->form->value("content");
        $comment->questionId = $this->form->value("questionId");
        $comment->awnserId = $this->form->value("awnserId");


        // Save to database
        $this->di->get("commentService")->addComment($comment);

        $this->form->addOutput("Kommentar skapad.");
        return true;
    }
}
