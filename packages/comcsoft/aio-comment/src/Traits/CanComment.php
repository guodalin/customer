<?php

namespace Comcsoft\Aio\Comment\Traits;

use Comcsoft\Aio\Comment\CommentFacade;

/**
 * Can Comment trait.
 */
trait CanComment
{
    /**
     * Make relationship with comments and commenter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(config('comment.model'), 'user_id', config('comment.commenter.table.primary_key'));
    }

    /**
     * Make a comment on a commentable model.
     *
     * @param \Illuminate\Database\Eloquent\Model   $commentable
     * @return \Comcsoft\Aio\Comment\CommentManager
     */
    public function commentOn($commentable)
    {
        return CommentFacade::user($this)
            ->on($commentable);
    }

    /**
     * Reply a comment.
     *
     * @param \Illuminate\Database\Eloquent\Model   $comment
     * @return \Comcsoft\Aio\Comment\CommentManager
     */
    public function commentAt($comment)
    {
        return CommentFacade::user($this)
            ->at($comment);
    }
}
