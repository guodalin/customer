<?php

namespace Comcsoft\Aio\Exam\Models;

use Comcsoft\Aio\Exam\Contracts\Questionable;
use Comcsoft\Aio\Exam\Traits\HasQuestionDriver;
use Illuminate\Database\Eloquent\Model;

class Question extends Model implements Questionable
{
    use HasQuestionDriver;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exam_questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'type',
        'section',
        'options',
        'analyze',
    ];

    /**
     * 多对多关联试卷
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function papers()
    {
        return $this->belongsToMany(Paper::class, 'exam_paper_question');
    }

    /**
     * [deprecated] 获得题目选项
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function options()
    // {
    //     return $this->hasMany(QuestionOption::class)
    //         ->orderBy('exam_question_options.sort', 'asc');
    // }

    /**
     * 题目日志详情
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function logs()
    {
        return $this->belongsToMany(Log::class, 'exam_log_question')
            ->withPivot('correct', 'score', 'my_answer');
    }
}
