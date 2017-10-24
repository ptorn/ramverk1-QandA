<?php
namespace Peto16\Qanda\Question;

use \Peto16\Qanda\Common\CommonController;
use \Peto16\Qanda\Question\HTMLForm\CreateQuestionForm;
use \Peto16\Qanda\Question\HTMLForm\UpdateQuestionForm;
use \Peto16\Qanda\Awnser\HTMLForm\CreateAwnserForm;

/**
 * Controller for Question
 */
class QuestionController extends CommonController
{

    /**
     * Delete a question
     *
     * @param int       $questionId
     * @return void
     */
    public function delQuestion($questionId)
    {
        $this->questionService->delQuestion($questionId);
        $this->utils->redirect("question");
    }



    /**
     * Edit question page.
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostEditQuestion($id)
    {
        $title  = "Redigera fråga";
        $form   = new UpdateQuestionForm($this->di, $id);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $this->view->add("default2/article", $data);
        $this->pageRender->renderPage(["title" => $title]);
    }



    /**
     * Get all questions to display on page.
     *
     * @return void
     */
    public function getPostQuestionsPage()
    {
        $loggedInUser   = $this->di->get("userService")->getCurrentLoggedInUser();
        $validSort = ["created", "vote"];
        $validDir = ["asc", "desc"];

        $sort = $this->di->get("request")->getGet("sort");
        $direction = $this->di->get("request")->getGet("dir", "desc");

        if (in_array($sort, $validSort) && in_array($direction, $validDir)) {
            $questions = $this->questionService->getAllQuestions($sort, $direction);
        } else {
            $questions = $this->questionService->getAllQuestions();
        }
        $this->view->add("qanda/question/question-top", [], "main");

        foreach ($questions as $question) {
            if ($question->deleted !== null) {
                continue;
            }
            $question->content = $this->utils->escapeParseMarkdown($question->content);
            $question->title        = htmlspecialchars($question->title);
            $question->firstname    = htmlspecialchars($question->firstname);
            $question->lastname     = htmlspecialchars($question->lastname);

            $this->view->add("qanda/question/question", [
                "question" => $question,
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
        $title  = "Frågor";
        $form   = new CreateQuestionForm($this->di);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        if ($this->di->get("userService")->getCurrentLoggedInUser()) {
            $this->view->add("qanda/crud/create", $data, "main");
        }
        $this->pageRender->renderPage(["title" => $title]);
    }



    /**
     * Get all questions to display on page.
     *
     * @return void
     */
    public function getPostQuestionByIdPage($id)
    {
        $title          = "Frågor";
        $question       = $this->questionService->getQuestion($id);
        $awnsers        = $this->questionService->getAwnsersByQuestionId($id);
        $loggedInUser   = $this->di->get("userService")->getCurrentLoggedInUser();

        // Escape question and parse markdown
        $question->content = $this->utils->escapeParseMarkdown($question->content);
        $question->title        = htmlspecialchars($question->title);
        $question->firstname    = htmlspecialchars($question->firstname);
        $question->lastname     = htmlspecialchars($question->lastname);
        $this->view->add("qanda/question/question", [
            "question" => $question,
            "loggedInUser"  => $loggedInUser,
            "type"          => "questionId",
            "id"            => $question->id,
            "urlReturn"     => $this->di->get("url")->create("question/" . $question->id),
            "nrVotesUp"     => sizeof($this->voteService->getAllVotesUp("questionId", $question->id)),
            "nrVotesDown"   => sizeof($this->voteService->getAllVotesDown("questionId", $question->id)),
            "nrAwnsers"     => sizeof($this->questionService->getAwnsersByQuestionId($question->id)),
            "nrComments"    => sizeof($this->commentService->getAllCommentsByField("questionId", $question->id))
        ], "main");

        foreach ($awnsers as $awnser) {
            if ($awnser->deleted !== null) {
                continue;
            }

            $awnser->content = $this->utils->escapeParseMarkdown($awnser->content);
            $awnser->title      = htmlspecialchars($awnser->title);
            $awnser->firstname  = htmlspecialchars($awnser->firstname);
            $awnser->lastname   = htmlspecialchars($awnser->lastname);

            $this->view->add("qanda/awnser/awnser", [
                "awnser"        => $awnser,
                "question"      => $question,
                "questionIdUrl" => htmlspecialchars($id),
                "loggedInUser"  => $loggedInUser,
                "type"          => "awnserId",
                "id"            => $awnser->id,
                "urlReturn"     => $this->di->get("url")->create("question/" . $id),
                "nrVotesUp"     => sizeof($this->voteService->getAllVotesUp("awnserId", $awnser->id)),
                "nrVotesDown"   => sizeof($this->voteService->getAllVotesDown("awnserId", $awnser->id))
            ], "awnser");
        }
        $form = new CreateAwnserForm($this->di, $id);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        if ($loggedInUser) {
            $this->view->add("qanda/crud/create", $data, "main");
        }
        $this->pageRender->renderPage(["title" => $title]);
    }
}
