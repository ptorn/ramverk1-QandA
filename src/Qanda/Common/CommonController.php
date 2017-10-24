<?php
namespace Peto16\Qanda\Common;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * CommonController
 */
class CommonController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    protected $questionService;
    protected $commentService;
    protected $awnserService;
    protected $pageRender;
    protected $view;
    protected $utils;
    protected $textfilter;
    protected $userService;
    protected $qandaUserService;
    protected $voteService;
    protected $tagService;


    /**
     * Initiate the Controller.
     *
     * @return void
     */
    public function init()
    {
        $this->questionService  = $this->di->get("questionService");
        $this->commentService   = $this->di->get("commentService");
        $this->awnserService    = $this->di->get("awnserService");
        $this->pageRender       = $this->di->get("pageRender");
        $this->view             = $this->di->get("view");
        $this->utils            = $this->di->get("utils");
        $this->textfilter       = $this->di->get("textfilter");
        $this->qandaUserService = $this->di->get("qandaUserService");
        $this->userService      = $this->di->get("userService");
        $this->voteService      = $this->di->get("voteService");
        $this->tagService   = $this->di->get("tagService");
    }
}
