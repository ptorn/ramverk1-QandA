<?php

namespace Peto16\Qanda\Awnser;

/**
 * Service class for awnsers.
 */
class AwnserService
{

    private $di;
    private $awnserStorage;
    private $session;
    private $userService;


    /**
     * Constructor for AwnserService
     *
     * @param object            $di dependency injection.
     */
    public function __construct($di)
    {
        $this->di = $di;
        $this->awnserStorage    = new AwnserStorage();
        $this->awnserStorage->setDb($di->get("db"));
        $this->session          = $di->get("session");
        $this->userService      = $di->get("userService");
    }



    /**
     * Add awnser
     *
     * @param object    $awnser Awnser object.
     *
     * @return void
     */
    public function addAwnser($awnser)
    {
        $this->awnserStorage->createAwnser($awnser);
    }



    /**
     * Edit awnser
     *
     * @param object    $awnser Awnser object.
     * @return void
     */
    public function editAwnser($awnser)
    {
        $this->awnserStorage->updateAwnser($awnser);
    }



    /**
     * Delete awnser.
     *
     * @param int       $awnserId
     * @return void
     */
    public function delAwnser($awnserId)
    {
        $user = $this->userService->getCurrentLoggedInUser();
        try {
            if ($user && $user->enabled === 1) {
                $this->awnserStorage->deleteAwnser([$awnserId]);
                return;
            }
            throw new Exception("Not logged in.", 1);
        } catch (Exception $e) {
            echo "Caught exception: ", $e->getMessage();
        }
    }



    /**
     * Get all awnsers stored and set if current user logged in is owner.
     *
     * @return array        Array with all awnsers.
     */
    public function getAllAwnsers()
    {
        $user   = $this->userService->getCurrentLoggedInUser();
        $userId = null;

        if ($user) {
            $userId = $this->userService->getCurrentLoggedInUser()->id;
        }

        $allAwnsers = $this->awnserStorage->readAwnser();
        return array_map(function ($item) use ($userId) {
            $item->loggedInUserId = $userId;
            $item->owner = false;
            $item->userAdmin = false;
            $item->gravatar = $this->userService->generateGravatarUrl($item->email);
            if ($item->userId === $userId) {
                $item->owner = true;
            }
            if ($this->userService->validLoggedInAdmin()) {
                $item->userAdmin = true;
            }
            return $item;
        }, $allAwnsers);
    }



    /**
     * Get a awnser with a given id.
     *
     * @param int           $id
     * @return array
     */
    public function getAwnser($id)
    {
        $user   = $this->userService->getCurrentLoggedInUser();
        $userId = null;

        if ($user) {
            $userId = $this->userService->getCurrentLoggedInUser()->id;
        }

        return array_map(function ($item) use ($userId) {
            $item->owner        = false;
            $item->userAdmin    = false;
            $item->gravatar     = $this->userService->generateGravatarUrl($item->email);
            if ($item->userId === $userId) {
                $item->owner    = true;
            }
            if ($this->userService->validLoggedInAdmin()) {
                $item->userAdmin = true;
            }
            return $item;
        }, $this->awnserStorage->readAwnser($id))[0];
    }



    /**
     * Dynamicly get awnser by propertie.
     *
     * @param string            $field field to search by.
     * @param array             $data to search for.
     * @return Awnser
     *
     */
    public function getAwnserByField($field, $data)
    {
        $awnser         = new Awnser();
        $awnserVarArray = get_object_vars($awnser);
        $awnserData     = $this->awnserStorage->getAwnserByField($field, $data);

        $arrayKeys = array_keys($awnserVarArray);
        foreach ($arrayKeys as $key) {
            $awnser->{$key} = $awnserData->$key;
        }
        return $awnser;
    }



    /**
     * Get awnsers by question id
     * @param  int      $questionId question id
     * @return [type]             [description]
     */
    public function getAwnsersByQuestionId($questionId)
    {
        $user   = $this->userService->getCurrentLoggedInUser();
        $userId = null;

        if ($user) {
            $userId = $this->userService->getCurrentLoggedInUser()->id;
        }
        $awnsers = $this->awnserStorage->getAllByQuestionId($questionId);
        return array_map(function ($item) use ($userId) {
            $item->owner        = false;
            $item->userAdmin    = false;
            $item->gravatar     = $this->userService->generateGravatarUrl($item->email);
            if ($item->userId === $userId) {
                $item->owner    = true;
            }
            if ($this->userService->validLoggedInAdmin()) {
                $item->userAdmin = true;
            }
            return $item;
        }, $awnsers);

    }



    /**
     * Get all awnsers by field
     * @param  string       $field field to search
     * @param  mixed        $data  data to find
     * @return array        array with all awnsers
     */
    public function getAllAwnsersByField($field, $data)
    {
        return $this->awnserStorage->getAllAwnsersByField($field, $data);
    }



    /**
     * Set accepted awnser to question
     * @param int $questionId question id
     * @param int $awnserId   awnser id
     */
    public function setAcceptedAwnserToQuestion($questionId, $awnserId)
    {
        $questionService  = $this->di->get("questionService");

        $question   = $questionService->getQuestion($questionId);
        $user       = $this->userService->getCurrentLoggedInUser();
        $awnsers    = $questionService->getAwnsersByQuestionId($questionId);

        if ($question->userId === $user->id) {
            foreach ($awnsers as $storedAwnser) {
                $awnser             = new Awnser();
                $awnser->id         = $storedAwnser->id;
                $awnser->userId     = $storedAwnser->userId;
                $awnser->title      = $storedAwnser->title;
                $awnser->content    = $storedAwnser->content;
                $awnser->created    = $storedAwnser->created;
                $awnser->updated    = $storedAwnser->updated;
                $awnser->deleted    = $storedAwnser->deleted;
                $awnser->accept     = false;

                if ($awnserId === $storedAwnser->id) {
                    $awnser->accept = true;
                }
                $this->editAwnser($awnser);
            }
        }
    }
}
