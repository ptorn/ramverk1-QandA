<?php

namespace Peto16\Qanda\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Peto16\Qanda\Comment;

/**
 * Example of FormModel implementation.
 */
class UpdateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);
        $comment = $di->get("commentService")->getCommentByField("id", $id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Redigera kommentar",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $comment->id
                ],

                "title" => [
                    "label"       => "Titel",
                    "type"        => "text",
                    "value"       => htmlentities($comment->title)
                ],

                "comment" => [
                    "label"       => "Kommentar",
                    "type"        => "textarea",
                    "value"       => htmlentities($comment->comment)

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
        $comment = new Comment();
        $comment->id = $this->form->value("id");
        $comment->userId = $this->di->get("userService")->getCurrentLoggedInUser()->id;
        $comment->title = $this->form->value("title");
        $comment->comment = $this->form->value("comment");

        // Save to storage
        $this->di->get("commentService")->editComment($comment);

        $this->form->addOutput("Kommentar uppdaterad.");
        $this->di->get("utils")->redirect("comments");
    }
}
