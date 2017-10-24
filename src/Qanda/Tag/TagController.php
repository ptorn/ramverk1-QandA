<?php
namespace Peto16\Qanda\Tag;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * Controller for Tag
 */
class TagController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    private $pageRender;
    private $view;
    private $utils;
    private $tagService;
    private $queService;


    /**
     * Initiate the Controller.
     *
     * @return void
     */
    public function init()
    {
        $this->pageRender   = $this->di->get("pageRender");
        $this->view         = $this->di->get("view");
        $this->utils        = $this->di->get("utils");
        $this->tagService   = $this->di->get("tagService");
        $this->queService   = $this->di->get("questionService");
    }



    public function getTagsPage()
    {
        $title = "Lista alla taggar";

        $data = [
            "allTags" => $this->tagService->getAllTags(),
        ];

        $this->view->add("qanda/tag/tags-list", $data);
        $this->pageRender->renderPage(["title" => $title]);
    }



    public function getQuestionsToTagPage($tagId)
    {
        $tagToQuestions = $this->tagService->getAllQuestionsToTag($tagId);
        $loggedInUser   = $this->di->get("userService")->getCurrentLoggedInUser();

        $tag = $this->tagService->getTagByField("id", $tagId);
        $this->view->add("qanda/tag/tags-questions", [
            "tag" => $tag
        ], "main");

        foreach ($tagToQuestions as $item) {
            $question = $this->queService->getQuestion($item->questionId);
            $this->view->add("qanda/question/question", [
                "question"      => $question,
                "loggedInUser"  => $loggedInUser
            ], "main");
        }
        $title = "Lista alla frågor till taggen";

        $this->pageRender->renderPage(["title" => $title]);

    }
}
