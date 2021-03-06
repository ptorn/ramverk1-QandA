<?php
namespace Peto16\Qanda\User;

use \Peto16\Qanda\Common\CommonController;
use \Peto16\Qanda\User\HTMLForm\SelectUserForm;

/**
 * Controller for User
 */
class UserController extends CommonController
{

    /**
     * GetPost List Users page
     * @return void
     */
    public function getPostListUsersPage()
    {
        $user = $this->di->get("session")->get("user");

        if (!$user) {
            $this->di->get("utils")->redirect("user/login");
        }
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



    /**
     * Get user page with info
     * @param  int          $userId user id
     * @return void
     */
    public function getUserPage($userId)
    {
        $user       = $this->userService->getUserByField("id", $userId);
        $questions  = $this->questionService->getAllQuestionsByField("userId", $userId);
        $awnsers    = $this->awnserService->getAllAwnsersByField("userId", $userId);
        $comments   = $this->commentService->getAllCommentsByField("userId", $userId);
        $votes      = $this->voteService->getAllVotesByField("userId", $userId);
        $title      = "Information om " . $user->username;

        // Escape and format markdown. Questions
        foreach ($questions as $question) {
            $question->content = $this->utils->escapeParseMarkdown($question->content);
            $question->title = htmlspecialchars($question->title);
        }

        // Escape and format markdown. Awnsers
        foreach ($awnsers as $awnser) {
            $awnser->content = $this->utils->escapeParseMarkdown($awnser->content);
            $awnser->title = htmlspecialchars($awnser->title);
        }

        // Escape and format markdown. Comments
        foreach ($comments as $comment) {
            $comment->content = $this->utils->escapeParseMarkdown($comment->content);
            $comment->title = htmlspecialchars($comment->title);
        }

        $data = [
            "user"          => $user,
            "userPoints"    => $this->qandaUserService->calculateUserScore($userId),
            "gravatarUrl"   => $this->userService->generateGravatarUrl($user->email),
            "questions"     => $this->qandaUserService->filterDeleted($questions),
            "awnsers"       => $this->qandaUserService->filterDeleted($awnsers),
            "comments"      => $this->qandaUserService->filterDeleted($comments),
            "nrVotes"       => sizeof($votes)
        ];

        $this->view->add("qanda/user/user-info", $data);
        $this->pageRender->renderPage(["title" => $title]);
    }



    /**
     * Get dashboard to list user stats.
     * @return void
     */
    public function getUserDash()
    {
        $user = $this->di->get("session")->get("user");

        if ($user) {
            if ($user->administrator) {
                $this->getPostListUsersPage();
            }
            $this->getUserPage($user->id);
        }
        $this->di->get("utils")->redirect("user/login");
    }
}
