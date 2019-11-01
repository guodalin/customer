<?php

namespace Comcsoft\Comment\Traits;

/**
 * Has Comments trait.
 */
trait HasComments
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
     * Make a comment.
     *
     * @param null|string                           $message
     * @param null|array|string                     $medias    request keys for medias
     * @param bool                                  $anonymous
     * @param null|\Comcsoft\Comment\Models\Comment $at        reply
     * @param null|User                             $commenter
     */
    public function addComment($message = null, $medias = null, $anonymous = false, $at = null, $commenter = null)
    {
        $commentModel = config('comment.model');

        return $commentModel::add($commenter ?: auth()->user(), $this, $message, $medias, $anonymous, $at);
    }

    /**
     * Get comments list.
     *
     * @return Collection
     */
    public function commentsPaginate($take = 15)
    {
        return $this->comments()
            ->with(['commenter', 'descendants.commenter'])
            ->whereIsRoot()
            ->latest()
            ->paginate($take);
    }
}
