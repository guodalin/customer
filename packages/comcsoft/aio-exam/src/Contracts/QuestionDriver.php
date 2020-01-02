<?php

namespace Comcsoft\Aio\Exam\Contracts;

interface QuestionDriver
{
    /**
     * bind question
     *
     * @param Questionable $question
     * @return self
     */
    public function bind(Questionable $question);
}
