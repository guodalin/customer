<?php

namespace Comcsoft\Aio\Exam\Contracts;

use Illuminate\Support\Collection;

/**
 * 可入题接口
 */
interface Questionable
{
    /**
     * 获得题目类型
     *
     * @return string
     */
    public function getQuestionType(): string;

    /**
     * 获得题目选项
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestionOptions(): Collection;
}
