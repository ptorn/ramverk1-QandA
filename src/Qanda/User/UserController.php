<?php
namespace Peto16\Qanda\User;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Peto16\Qanda\User\HTMLForm\SelectUserForm;

/**
 * Controller for User
 */
class UserController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    private $questionService;
    private $userService;
    private $comService;
    private $awnserService;
    private $pageRender;
    private $view;
    private $qandaUserService;


    /**
     * Initiate the Controller.
     *
     * @return void
     */
    public function init()
    {
        $this->questionService  = $this->di->get("questionService");
        $this->awnserService    = $this->di->get("awnserService");
        $this->comService       = $this->di->get("commentService");
        $this->userService      = $this->di->get("userService");

        $this->pageRender       = $this->di->get("pageRender");
        $this->view             = $this->di->get("view");

        $this->utils            = $this->di->get("utils");
        $this->qandaUserService = $this->di->get("qandaUserService");
    }


    public function getPostListUsersPage()
    {
        $title  = "Lista användare";
        $users  = $this->userService->findAllUsers();
        $form   = new SelectUserForm($this->di);

        $form->check();

        $data = [
            "form"  => $form->getHTML(),
            "users" => $users,
        ];

        $this->view->add("qanda/user/users-list", $data);

        $this->pageRender->renderPage(["title" => $title]);
    }



    public function getUserPage($userId)
    {
        $user       = $this->userService->getUserByField("id", $userId);
        $questions  = $this->questionService->getAllQuestionsByField("userId = ?", $userId);
        $awnsers    = $this->awnserService->getAllAwnsersByField("userId = ?", $userId);
        $comments   = $this->comService->getAllCommentsByField("userId = ?", $userId);
        $title      = "Information om " . $user->username;

        $data = [
            "user"          => $user,
            "userPoints"    => $this->qandaUserService->calculateUserScore($userId),
            "gravatarUrl"   => $this->userService->generateGravatarUrl($user->email),
            "questions"     => $this->qandaUserService->filterDeleted($questions),
            "awnsers"       => $this->qandaUserService->filterDeleted($awnsers),
            "comments"      => $this->qandaUserService->filterDeleted($comments)
        ];

        $this->view->add("qanda/user/user-info", $data);

        $this->pageRender->renderPage(["title" => $title]);
    }
}
