<?php

namespace Comcsoft\Aio\Exam;

use Comcsoft\Aio\Exam\Contracts\QuestionDriver;
use Comcsoft\Aio\Exam\Drivers\CheckboxDriver;
use Comcsoft\Aio\Exam\Drivers\JudgeDriver;
use Comcsoft\Aio\Exam\Drivers\MaterialDriver;
use Comcsoft\Aio\Exam\Drivers\RadioDriver;
use Comcsoft\Aio\Exam\Drivers\TextDriver;
use Illuminate\Support\Manager;

class QuestionManager extends Manager
{
    /**
     * Get the default driver name.
     * We must call static::driver($driver) to get proper driver
     *
     * @return string|null
     */
    public function getDefaultDriver()
    {
        return null;
    }

    /**
     * 创建单选题实例
     *
     * @return QuestionDriver
     */
    public function createRadioDriver(): QuestionDriver
    {
        return new RadioDriver();
    }

    /**
     * 创建多选题实例
     *
     * @return QuestionDriver
     */
    public function createCheckboxDriver(): QuestionDriver
    {
        return new CheckboxDriver();
    }

    /**
     * 创建判断题实例
     *
     * @return QuestionDriver
     */
    public function createJudgeDriver(): QuestionDriver
    {
        return new JudgeDriver();
    }

    /**
     * 创建问答题实例
     *
     * @return QuestionDriver
     */
    public function createTextDriver(): QuestionDriver
    {
        return new TextDriver();
    }

    /**
     * 创建材料题实例
     *
     * @return QuestionDriver
     */
    public function createMaterialDriver(): QuestionDriver
    {
        return new MaterialDriver();
    }
}
