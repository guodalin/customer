<?php

namespace Comcsoft\Aio\Exam;

use Illuminate\Support\Facades\Facade;

class QuestionDriverFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public static function getFacadeAccessor()
    {
        return 'aio.exam.question';
    }
}
