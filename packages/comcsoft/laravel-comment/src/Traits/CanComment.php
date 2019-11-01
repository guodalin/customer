<?php

namespace Comcsoft\Comment\Traits;

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
     * Make a comment.
     *
     * @param \Illuminate\Database\Eloquent\Model   $commentable
     * @param null|string                           $message
     * @param null|array|string                     $medias      request keys for medias
     * @param bool                                  $anonymous
     * @param null|\Comcsoft\Comment\Models\Comment $at          reply
     */
    public function addComment($commentable, $message = null, $medias = null, $anonymous = false, $at = null)
    {
        $commentModel = config('comment.model');

        return $commentModel::add($this, $commentable, $message, $medias, $anonymous, $at);
    }
}
