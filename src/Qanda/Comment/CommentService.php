<?php

namespace Peto16\Qanda\Comment;

/**
 * Service class for comments.
 */
class CommentService
{

    private $comStorage;
    private $session;
    private $userService;



    /**
     * Constructor for CommentService
     *
     * @param object            $di dependency injection.
     */
    public function __construct($di)
    {
        $this->comStorage = new CommentStorage();
        $this->comStorage->setDb($di->get("db"));
        $this->session = $di->get("session");
        $this->userService = $di->get("userService");
    }



    /**
     * Add comment
     *
     * @param object    $comment Comment object.
     *
     * @return void
     */
    public function addComment($comment)
    {
        $this->comStorage->createComment($comment);
    }



    /**
     * Edit comment
     *
     * @param object    $comment Comment object.
     *
     * @return void
     */
    public function editComment($comment)
    {
        $this->comStorage->updateComment($comment);
    }



    /**
     * Delete comment.
     *
     * @param int       $commentId
     * @return void
     */
    public function delComment($commentId)
    {
        $user = $this->userService->getCurrentLoggedInUser();
        try {
            if ($user && $user->enabled === 1) {
                $this->comStorage->deleteComment([$commentId]);
                return;
            }
            throw new Exception("Not logged in.", 1);
        } catch (Exception $e) {
            echo "Caught exception: ", $e->getMessage();
        }
    }



    /**
     * Get all comments stored and set if current user logged in is owner.
     *
     * @return array        Array with all comments.
     */
    public function getAllComments()
    {
        $user = $this->userService->getCurrentLoggedInUser();
        $userId = null;

        if ($user) {
            $userId = $this->userService->getCurrentLoggedInUser()->id;
        }

        $allComments = $this->comStorage->readComment();
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
        }, $allComments);
    }



    /**
     * Get a comment with a given id.
     *
     * @param int           $id
     * @return object
     */
    public function getComment($id)
    {
        return $this->comStorage->readComment($id);
    }



    /**
     * Dynamicly get comment by propertie.
     *
     * @param string            $field field to search by.
     *
     * @param array             $data to search for.
     *
     * @return Comment
     *
     */
    public function getCommentByField($field, $data)
    {
        $comment = new Comment();
        $commentVarArray = get_object_vars($comment);
        $commentData = $this->comStorage->getCommentByField($field, $data);

        $arrayKeys = array_keys($commentVarArray);
        foreach ($arrayKeys as $key) {
            $comment->{$key} = $commentData->$key;
        }
        return $comment;
    }



    public function getComByAwnserId($awnserId)
    {
        $user = $this->userService->getCurrentLoggedInUser();
        $userId = null;

        if ($user) {
            $userId = $this->userService->getCurrentLoggedInUser()->id;
        }
        $comments = $this->comStorage->getAllByAwnserId($awnserId);
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
        }, $comments);

    }




    public function getAllCommentsByField($field, $data)
    {
        return $this->comStorage->getAllCommentsByField($field, $data);
    }
}
