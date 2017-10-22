<?php
namespace Peto16\Qanda\Question;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Peto16\Qanda\Question\HTMLForm\CreateQuestionForm;
use \Peto16\Qanda\Question\HTMLForm\UpdateQuestionForm;
use \Peto16\Qanda\Awnser\HTMLForm\CreateAwnserForm;


/**
 * Controller for Question
 */
class QuestionController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    private $questionService;
    private $pageRender;
    private $view;



    /**
     * Initiate the Controller.
     *
     * @return void
     */
    public function init()
    {
        $this->questionService  = $this->di->get("questionService");
        $this->pageRender       = $this->di->get("pageRender");
        $this->view             = $this->di->get("view");
        $this->utils            = $this->di->get("utils");
    }



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
        $questions = $this->questionService->getAllQuestions();
        foreach ($questions as $question) {
            if ($question->deleted !== null) {
                continue;
            }
            $this->view->add("qanda/question/question", ["question" => $question], "main");
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
        $title      = "Frågor";
        $question   = $this->questionService->getQuestion($id);
        $awnsers    = $this->questionService->getAwnserByQuestionId($id);

        $this->view->add("qanda/question/question", ["question" => $question], "main");

        foreach ($awnsers as $awnser) {
            if ($awnser->deleted !== null) {
                continue;
            }
            $this->view->add("qanda/awnser/awnser", [
                "awnser" => $awnser,
                "questionIdUrl" => $id
            ], "main");
        }
        $form = new CreateAwnserForm($this->di, $id);

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
