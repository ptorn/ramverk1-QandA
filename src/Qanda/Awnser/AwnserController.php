<?php
namespace Peto16\Qanda\Awnser;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Peto16\Qanda\Awnser\HTMLForm\CreateAwnserForm;
use \Peto16\Qanda\Awnser\HTMLForm\UpdateAwnserForm;
use \Peto16\Qanda\Comment\HTMLForm\CreateCommentForm;

/**
 * Controller for Awnser
 */
class AwnserController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    private $awnserService;
    private $commentService;
    private $pageRender;
    private $view;
    private $utils;
    private $textfilter;



    /**
     * Initiate the Controller.
     *
     * @return void
     */
    public function init()
    {
        $this->awnserService    = $this->di->get("awnserService");
        $this->commentService   = $this->di->get("commentService");
        $this->pageRender       = $this->di->get("pageRender");
        $this->view             = $this->di->get("view");
        $this->utils            = $this->di->get("utils");
        $this->textfilter       = $this->di->get("textfilter");
    }



    /**
     * Delete a awnser
     *
     * @param int       $awnserId
     * @return void
     */
    public function delAwnser($questionId, $awnserId)
    {
        $this->awnserService->delAwnser($awnserId);
        $this->utils->redirect("question/" . $questionId);
    }



    /**
     * Edit awnser page.
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostEditAwnser($questionId, $awnserId)
    {
        $title  = "Redigera svar";
        $form   = new UpdateAwnserForm($this->di, $questionId, $awnserId);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $this->view->add("default2/article", $data);
        $this->pageRender->renderPage(["title" => $title]);
    }



    public function getPostAwnserPage($questionId, $awnserId)
    {
        $title  = "Svar";
        $awnser = $this->awnserService->getAwnser($awnserId)[0];

        // Awnser escape and parse markdown
        $awnser->content = $this->textfilter->parse(
            htmlspecialchars($awnser->content),
            ["yamlfrontmatter", "shortcode", "markdown", "titlefromheader"]
        )->text;

        $awnser->title      = htmlspecialchars($awnser->title);
        $awnser->firstname  = htmlspecialchars($awnser->firstname);
        $awnser->lastname   = htmlspecialchars($awnser->lastname);

        $this->view->add("qanda/awnser/awnser", [
            "awnser"        => $awnser,
            "questionIdUrl" => htmlspecialchars($questionId),
        ], "main");

        // Comments
        $comments = $this->commentService->getComByAwnserId($questionId);
        foreach ($comments as $comment) {
            if ($comment->deleted !== null) {
                continue;
            }

            // Parse markdown
            $comment->content = $this->textfilter->parse(
                htmlspecialchars($comment->content),
                ["yamlfrontmatter", "shortcode", "markdown", "titlefromheader"]
            )->text;

            $comment->title     = htmlspecialchars($comment->title);
            $comment->firstname = htmlspecialchars($comment->firstname);
            $comment->lastname  = htmlspecialchars($comment->lastname);

            $this->di->get("view")->add("qanda/comment/comment", [
                "comment" => $comment,
                "questionIdUrl" => htmlspecialchars($questionId),
                "awnserIdUrl" => htmlspecialchars($awnserId)

            ], "main");
        }

        $form = new CreateCommentForm($this->di, $questionId, $awnserId);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        if ($this->di->get("userService")->getCurrentLoggedInUser()) {
            $this->view->add("qanda/crud/create", $data, "main");
        }
        $this->pageRender->renderPage(["title" => $title]);
    }
}
