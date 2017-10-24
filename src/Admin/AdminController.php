<?php

namespace Peto16\Admin;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

class AdminController implements InjectionAwareInterface
{
    use InjectionAwareTrait;


    /**
     * Admin dashboard
     * @return void
     */
    public function dashboard()
    {
        $userService = $this->di->get("userService");
        $user = $this->di->get("session")->get("user");

        $users = [];
        if ($user) {
            if ($user->administrator) {
                $users = $userService->findAllUsers();
            }
            $this->di->get("view")->add("admin/dashboard", [
                "user"          => $user,
                "users"         => $users,
                "gravatarUrl"   => $userService->generateGravatarUrl($user->email)
            ], "main");
            $this->di->get("pageRender")->renderPage(["title" => "Admin Dashboard"]);
        }
        $this->di->get("utils")->redirect("user/login");
    }
}
