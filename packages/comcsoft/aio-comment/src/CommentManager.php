<?php

namespace Comcsoft\Aio\Comment;

use App\Models\Auth\User;
use Comcsoft\Aio\Comment\Models\Comment as CommentModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CommentManager
{
    /**
     * @var \Comcsoft\Aio\Comment\Models\Comment
     */
    public $commentModel;

    /**
     * Create a new comment manage instance.
     */
    public function __construct()
    {
        $this->commentModel = new CommentModel();

        if (Auth::check()) {
            $this->user(Auth::user());
        }
    }

    /**
     * set commenter
     *
     * @param \App\Models\Auth\User|null $user
     * @return self
     */
    public function user(User $user)
    {
        $this->commentModel->commenter()->associate($user);

        return $this;
    }

    /**
     * set commentable
     *
     * @param Model $commentable
     * @return self
     */
    public function on(Model $commentable)
    {
        $this->commentModel->commentable()->associate($commentable);

        return $this;
    }

    /**
     * reply at a comment
     *
     * @param CommentModel $comment
     * @return self
     */
    public function at(CommentModel $comment)
    {
        $this->on($comment->commentable);

        $this->commentModel->appendToNode($comment);

        return $this;
    }

    /**
     * set anonymous for this comment
     *
     * @param boolean $anonymous
     * @return self
     */
    public function anonymous($anonymous = false)
    {
        $this->commentModel->anonymous = $anonymous;

        return $this;
    }

    /**
     * set message
     *
     * @return self
     */
    public function message($message)
    {
        $this->commentModel->message = $message;

        return $this;
    }

    /**
     * attach media
     *
     * @return self
     */
    public function media($files)
    {
        $this->commentModel->medias = $files;

        return $this;
    }

    /**
     * save a comment
     *
     * @return bool
     */
    public function save($message = null)
    {
        if ($message) {
            $this->message($message);
        }

        return $this->commentModel->save();
    }
}
