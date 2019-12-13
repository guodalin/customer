<?php

namespace Comcsoft\Aio\Comment;

use Illuminate\Support\Facades\Facade;

class CommentFacade extends Facade
{
    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'aio.comment';
    }
}
