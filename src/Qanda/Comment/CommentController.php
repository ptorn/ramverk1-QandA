<?php
namespace Peto16\Qanda\Comment;

use \Peto16\Qanda\Common\CommonController;
use \Peto16\Qanda\Comment\HTMLForm\CreateCommentForm;
use \Peto16\Qanda\Comment\HTMLForm\UpdateCommentForm;

/**
 * Controller for Comment
 */
class CommentController extends CommonController
{

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
