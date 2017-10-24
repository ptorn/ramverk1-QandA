<?php
namespace Peto16\Qanda\Tag;

use \Peto16\Qanda\Common\CommonController;

/**
 * Controller for Tag
 */
class TagController extends CommonController
{

    /**
     * Get tags page
     * @return void
     */
    public function getTagsPage()
    {
        $title = "Lista alla taggar";

        $data = [
            "allTags" => $this->tagService->getAllTags(),
        ];

        $this->view->add("qanda/tag/tags-list", $data);
        $this->pageRender->renderPage(["title" => $title]);
    }



    /**
     * Get questions to tag page
     * @param  int      $tagId id of tag
     * @return void
     */
    public function getQuestionsToTagPage($tagId)
    {
        $tagToQuestions = $this->tagService->getAllQuestionsToTag($tagId);
        $loggedInUser   = $this->di->get("userService")->getCurrentLoggedInUser();

        $tag = $this->tagService->getTagByField("id", $tagId);
        $this->view->add("qanda/tag/tags-questions", [
            "tag" => $tag
        ], "main");

        foreach ($tagToQuestions as $item) {
            $question = $this->questionService->getQuestion($item->questionId);
            $this->view->add("qanda/question/question", [
                "question"      => $question,
                "loggedInUser"  => $loggedInUser,
                "type"          => "questionId",
                "id"            => $question->id,
                "urlReturn"     => $this->di->get("url")->create("question/" . $question->id),
                "nrVotesUp"     => sizeof($this->voteService->getAllVotesUp("questionId", $question->id)),
                "nrVotesDown"   => sizeof($this->voteService->getAllVotesDown("questionId", $question->id)),
                "nrAwnsers"     => sizeof($this->questionService->getAwnsersByQuestionId($question->id)),
                "nrComments"    => sizeof($this->commentService->getAllCommentsByField("questionId", $question->id))
            ], "main");
        }
        $title = "Lista alla frågor till taggen";

        $this->pageRender->renderPage(["title" => $title]);
    }
}
