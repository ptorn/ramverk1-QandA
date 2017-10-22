<?php
namespace Peto16\Qanda\User;

use \Peto16\Qanda\Common\CommonController;
use \Peto16\Qanda\User\HTMLForm\SelectUserForm;

/**
 * Controller for User
 */
class UserController extends CommonController
{

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
        $comments   = $this->commentService->getAllCommentsByField("userId = ?", $userId);
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
            "comments"      => $this->qandaUserService->filterDeleted($comments)
        ];

        $this->view->add("qanda/user/user-info", $data);

        $this->pageRender->renderPage(["title" => $title]);
    }
}
