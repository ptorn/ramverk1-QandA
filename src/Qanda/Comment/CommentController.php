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



    /**
     * Initiate the Controller.
     *
     * @return void
     */
    public function init()
    {
        $this->commentService = $this->di->get("commentService");
        $this->pageRender = $this->di->get("pageRender");
        $this->view = $this->di->get("view");
        $this->utils = $this->di->get("utils");
    }



    /**
     * Delete a comment
     *
     * @param int       $commentId
     * @return void
     */
    public function delComment($commentId)
    {
        $this->commentService->delComment($commentId);
        $this->utils->redirect("comments");
    }



    /**
     * Edit comment page.
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostEditComment($id)
    {
        $title      = "Redigera kommentar";
        $form       = new UpdateCommentForm($this->di, $id);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $this->view->add("default2/article", $data);

        $this->pageRender->renderPage(["title" => $title]);
    }



    // /**
    //  * Get all comments to display on page.
    //  *
    //  * @return void
    //  */
    // public function getCommentsPage()
    // {
    //     $comments = $this->commentService->getAllComments();
    //     $this->view->add("comment/comment-page", ["comments" => $comments], "comments");
    //     $form       = new CreateCommentForm($this->di);
    //
    //     $form->check();
    //
    //     $data = [
    //         "form" => $form->getHTML(),
    //     ];
    //
    //     if ($this->di->get("userService")->getCurrentLoggedInUser()) {
    //         $this->view->add("comment/crud/create", $data, "comments");
    //     }
    // }
}
