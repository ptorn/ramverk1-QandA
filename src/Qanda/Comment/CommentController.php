<?php
namespace Peto16\Qanda\Comment;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Peto16\Qanda\Comment\HTMLForm\CreateCommentForm;
use \Peto16\Qanda\Comment\HTMLForm\UpdateCommentForm;

/**
 * Controller for Comment
 */
class CommentController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    private $commentService;
    private $pageRender;
    private $view;
    private $utils;



    /**
     * Initiate the Controller.
     *
     * @return void
     */
    public function init()
    {
        $this->commentService   = $this->di->get("commentService");
        $this->pageRender       = $this->di->get("pageRender");
        $this->view             = $this->di->get("view");
        $this->utils            = $this->di->get("utils");
    }



    /**
     * Delete a comment
     *
     * @param int       $commentId
     * @return void
     */
    public function delComment($questionId, $awnserId, $commentId)
    {
        $this->commentService->delComment($commentId);
        $this->utils->redirect("question/" . $questionId . "/awnser/" . $awnserId);
    }



    /**
     * Edit comment page.
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostEditComment($questionId, $awnserId, $commentId)
    {
        $title  = "Redigera kommentar";
        $form   = new UpdateCommentForm($this->di, $questionId, $awnserId, $commentId);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $this->view->add("default2/article", $data);
        $this->pageRender->renderPage(["title" => $title]);
    }
}
