<?php

namespace Peto16\Qanda\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Peto16\Qanda\Comment\Comment;

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
    public function __construct(DIInterface $di, $questionId, $awnserId, $commentId)
    {
        parent::__construct($di);
        $comment = $di->get("commentService")->getCommentByField("id", $commentId);
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

                "questionId" => [
                    "type" => "hidden",
                    "value" => $questionId,
                ],

                "awnserId" => [
                    "type" => "hidden",
                    "value" => $awnserId,
                ],

                "title" => [
                    "label"       => "Titel",
                    "type"        => "text",
                    "value"       => htmlspecialchars($comment->title)
                ],

                "content" => [
                    "label"       => "Kommentar",
                    "type"        => "textarea",
                    "value"       => htmlspecialchars($comment->content)

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
        $comment->content = $this->form->value("content");
        $comment->awnserId = $this->form->value("awnserId");
        $comment->questionId = $this->form->value("questionId");

        // Save to storage
        $this->di->get("commentService")->editComment($comment);

        $this->form->addOutput("Kommentar uppdaterad.");
        $this->di->get("utils")->redirect("question/" . $comment->questionId . "/awnser/" . $comment->awnserId);
    }
}
