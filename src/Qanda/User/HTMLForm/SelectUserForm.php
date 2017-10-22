<?php

namespace Peto16\Qanda\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class SelectUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);
        $users = $di->get("userService")->findAllUsers();
        $userData = [];
        foreach ($users as $user) {
            $userData[$user->id] = $user->username;
        }

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Välj en användare",
            ],
            [
                "userList" => [
                    "type"        => "select",
                    "label"       => "Välj en användare",
                    "options"     => $userData,
                    "value"       => "",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Uppdatera",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $user = $this->form->value("userList");

        // $this->form->addOutput("Fråga uppdaterad.");
        $this->di->get("utils")->redirect("qanda/user/id/" . $user);
    }
}
