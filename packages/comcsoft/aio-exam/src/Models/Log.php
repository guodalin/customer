<?php

namespace Comcsoft\Aio\Exam\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exam_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paper_id',
        'user_id',
        'score',
        'elapsed',
    ];

    /**
     * 从属试卷
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    /**
     * 从属用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 题目详情
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_log_question')
            ->withPivot('correct', 'score', 'my_answer');
    }
}
