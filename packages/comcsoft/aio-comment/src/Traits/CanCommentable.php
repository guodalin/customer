<?php

namespace Comcsoft\Aio\Comment\Traits;

use Comcsoft\Aio\Comment\CommentFacade;

/**
 * Has Comments trait.
 */
trait CanCommentable
{
    /**
     * Make relationship with comments and commentable.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(config('comment.model'), 'commentable');
    }

    /**
     * Make a comment on this model by a user.
     *
     * @param null|User                             $commenter
     * @return \Comcsoft\Aio\Comment\CommentManager
     */
    public function commentBy($user)
    {
        return CommentFacade::user($user)
            ->on($this);
    }
}
