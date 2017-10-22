<?php

namespace Peto16\Qanda\Question;

/**
 * Service class for questions.
 */
class QuestionService
{

    private $queStorage;
    private $session;
    private $userService;
    private $comService;
    private $awnser;


    /**
     * Constructor for QuestionService
     *
     * @param object            $di dependency injection.
     */
    public function __construct($di)
    {
        $this->queStorage = new QuestionStorage();
        $this->queStorage->setDb($di->get("db"));

        $this->comService = $di->get("commentService");
        $this->awnserService = $di->get("awnserService");

        $this->session = $di->get("session");
        $this->userService = $di->get("userService");
    }



    /**
     * Add question
     *
     * @param object    $question Question object.
     *
     * @return void
     */
    public function addQuestion($question)
    {
        $this->queStorage->createQuestion($question);
    }



    /**
     * Edit question
     *
     * @param object    $question Question object.
     *
     * @return void
     */
    public function editQuestion($question)
    {
        $this->queStorage->updateQuestion($question);
    }



    /**
     * Delete question.
     *
     * @param int       $questionId
     * @return void
     */
    public function delQuestion($questionId)
    {
        $user = $this->userService->getCurrentLoggedInUser();
        try {
            if ($user && $user->enabled === 1) {
                $this->queStorage->deleteQuestion([$questionId]);
                return;
            }
            throw new Exception("Not logged in.", 1);
        } catch (Exception $e) {
            echo "Caught exception: ", $e->getMessage();
        }
    }



    /**
     * Get all questions stored and set if current user logged in is owner.
     *
     * @return array        Array with all questions.
     */
    public function getAllQuestions()
    {
        $user = $this->userService->getCurrentLoggedInUser();
        $userId = null;

        if ($user) {
            $userId = $this->userService->getCurrentLoggedInUser()->id;
        }

        $allQuestions = $this->queStorage->readQuestion();
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
        }, $allQuestions);
    }



    /**
     * Get a question with a given id.
     *
     * @param int           $id
     * @return object
     */
    public function getQuestion($id)
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
        }, $this->queStorage->readQuestion($id));
    }



    /**
     * Dynamicly get question by propertie.
     *
     * @param string            $field field to search by.
     *
     * @param array             $data to search for.
     *
     * @return Question
     *
     */
    public function getQuestionByField($field, $data)
    {
        $question = new Question();
        $questionVarArray = get_object_vars($question);
        $questionData = $this->queStorage->getQuestionByField($field, $data);

        $arrayKeys = array_keys($questionVarArray);
        foreach ($arrayKeys as $key) {
            $question->{$key} = $questionData->$key;
        }
        return $question;
    }



    public function getAllQuestionsByField($field, $data)
    {
        return $this->queStorage->getAllQuestionsByField($field, $data);
    }



    public function getAwnserByQuestionId($id)
    {
        return $this->awnserService->getAwnserByQuestionId($id);
    }
}
