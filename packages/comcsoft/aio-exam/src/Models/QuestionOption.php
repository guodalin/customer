<?php

namespace Comcsoft\Aio\Exam\Models;

use ArrayAccess;
use Overtrue\Socialite\HasAttributes;

class QuestionOption implements ArrayAccess
{
    use HasAttributes;

    /**
     * construct
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }
}
