<?php

namespace Comcsoft\Aio\Exam\Traits;

use Comcsoft\Aio\Exam\Contracts\QuestionDriver as QuestionDriverContract;
use Comcsoft\Aio\Exam\Models\QuestionOption;
use Comcsoft\Aio\Exam\QuestionDriverFacade;
use Illuminate\Support\Collection;

/**
 * Question Driver Helper
 */
trait HasQuestionDriver
{
    /**
     * invoke question driver instance
     *
     * @return \Comcsoft\Aio\Exam\Contracts\QuestionDriver
     */
    public function driver(): QuestionDriverContract
    {
        return QuestionDriverFacade::driver($this->getQuestionType())
            ->bind($this);
    }

    /**
     * 获得题目类型
     *
     * @return string
     */
    public function getQuestionType(): string
    {
        return $this->type;
    }

    /**
     * 获得题目选项
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestionOptions(): Collection
    {
        return collect($this->options)->map(function ($option) {
            return new QuestionOption($option);
        });
    }
}
