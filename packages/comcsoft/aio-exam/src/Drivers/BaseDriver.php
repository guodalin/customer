<?php

namespace Comcsoft\Aio\Exam\Drivers;

use Comcsoft\Aio\Exam\Contracts\Questionable;

class BaseDriver
{
    /**
     * 题目对象
     *
     * @var \Comcsoft\Aio\Exam\Contracts\Questionable
     */
    public $question;

    /**
     * Create a new driver instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * set question
     *
     * @param \Comcsoft\Aio\Exam\Contracts\Questionable $question
     * @return self
     */
    public function setQuestion(Questionable $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * get question
     *
     * @return \Comcsoft\Aio\Exam\Contracts\Questionable
     */
    public function getQuestion(): Questionable
    {
        return $this->question;
    }
}
