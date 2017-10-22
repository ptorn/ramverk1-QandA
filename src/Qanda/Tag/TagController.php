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
    // private $tagService;


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
    }



    public function getTagsPage()
    {
        $title = "Lista alla taggar";

        $data = [
            "content" => "",
        ];

        $this->view->add("default2/article", $data);
        $this->pageRender->renderPage(["title" => $title]);
    }
}
