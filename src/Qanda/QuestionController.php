<?php
namespace Peto16\Qanda;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Peto16\Qanda\HTMLForm\CreateQuestionForm;
use \Peto16\Qanda\HTMLForm\UpdateQuestionForm;

/**
 * Controller for Question
 */
class QuestionController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    private $questionService;



    /**
     * Initiate the Controller.
     *
     * @return void
     */
    public function init()
    {
        $this->questionService = $this->di->get("questionService");
        $this->utils = $this->di->get("utils");
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
        $this->utils->redirect("/");
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
        $title      = "Redigera fråga";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new UpdateQuestionForm($this->di, $id);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $view->add("default2/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Get all questions to display on page.
     *
     * @return void
     */
    public function getQuestionsPage()
    {
        $questions = $this->questionService->getAllQuestions();
        $this->di->get("view")->add("qanda/questions-page", ["questions" => $questions], "main");
        $view       = $this->di->get("view");
        $form       = new CreateQuestionForm($this->di);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        if ($this->di->get("userService")->getCurrentLoggedInUser()) {
            $view->add("qanda/crud/create", $data, "main");
        }
    }
}
