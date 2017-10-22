<?php

namespace Peto16\Qanda\Awnser;

/**
 * Service class for awnsers.
 */
class AwnserService
{

    private $awnserStorage;
    private $session;
    private $userService;
    private $comService;


    /**
     * Constructor for AwnserService
     *
     * @param object            $di dependency injection.
     */
    public function __construct($di)
    {
        $this->awnserStorage = new AwnserStorage();
        $this->awnserStorage->setDb($di->get("db"));

        // $this->comService = $di->get("commentService");
        $this->session = $di->get("session");
        $this->userService = $di->get("userService");
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
     *
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
        $user = $this->userService->getCurrentLoggedInUser();
        $userId = null;

        if ($user) {
            $userId = $this->userService->getCurrentLoggedInUser()->id;
        }

        $allAwnsers = $this->awnserStorage->readAwnser();
        return array_map(function ($item) use ($userId) {
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
     * @return object
     */
    public function getAwnser($id)
    {
        $user = $this->userService->getCurrentLoggedInUser();
        $userId = null;

        if ($user) {
            $userId = $this->userService->getCurrentLoggedInUser()->id;
        }

        return array_map(function ($item) use ($userId) {
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
        }, $this->awnserStorage->readAwnser($id));
    }



    /**
     * Dynamicly get awnser by propertie.
     *
     * @param string            $field field to search by.
     *
     * @param array             $data to search for.
     *
     * @return Awnser
     *
     */
    public function getAwnserByField($field, $data)
    {
        $awnser = new Awnser();
        $awnserVarArray = get_object_vars($awnser);
        $awnserData = $this->awnserStorage->getAwnserByField($field, $data);

        $arrayKeys = array_keys($awnserVarArray);
        foreach ($arrayKeys as $key) {
            $awnser->{$key} = $awnserData->$key;
        }
        return $awnser;
    }


    public function getAwnserByQuestionId($questionId)
    {
        $user = $this->userService->getCurrentLoggedInUser();
        $userId = null;

        if ($user) {
            $userId = $this->userService->getCurrentLoggedInUser()->id;
        }
        $awnsers = $this->awnserStorage->getAllByQuestionId($questionId);
        return array_map(function ($item) use ($userId) {
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
        }, $awnsers);

    }



    public function getAllAwnsersByField($field, $data)
    {
        return $this->awnserStorage->getAllAwnsersByField($field, $data);
    }
}
