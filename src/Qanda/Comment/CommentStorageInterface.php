<?php

namespace Peto16\Qanda\Comment;

/**
 * Interface for CommentStorage
 */
interface CommentStorageInterface
{
    public function createComment(Comment $comment);
    public function deleteComment($commentId);
    public function updateComment(Comment $comment);
    public function readComment($commentId = null);
    public function getCommentByField($field, $data);
}
