<?php

namespace Comcsoft\Aio\Exam\Composers;

use Illuminate\View\View;

/**
 * Class QuestionTypeComposer.
 */
class QuestionTypeComposer
{
    /**
     * @param View $view
     *
     * @return bool|mixed
     */
    public function compose(View $view)
    {
        $types = config('aio.exam.types.question');

        $types = collect($types)->combine($types)->map(function ($value) {
            return __('aio-exam::labels.types.question.' . $value);
        });

        $view->with('question_types', $types);
    }
}
