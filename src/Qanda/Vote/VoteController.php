<?php
namespace Peto16\Qanda\Vote;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * Controller for Vote
 */
class VoteController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    private $utils;
    private $request;



    /**
     * Initiate the Controller.
     *
     * @return void
     */
    public function init()
    {
        $this->request      = $this->di->get("request");
        $this->utils        = $this->di->get("utils");
        $this->voteService  = $this->di->get("voteService");
    }



    public function postVote()
    {
        $user = $this->di->get("session")->get("user");

        if (!$user) {
            $this->di->get("utils")->redirect("user/login");
        }
        $type   = $this->request->getPost("type");
        $url    = $this->request->getPost("url");
        $postId = $this->request->getPost("id");
        $vote   = $this->request->getPost("vote");

        $this->voteService->addVote($type, $postId, $vote);
        $this->utils->redirect($url);

    }
}
