<?php

namespace Comcsoft\Aio\Exam\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paper extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exam_papers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'type',
        'summary',
        'score',
        'copyfrom',
        'minutes',
        'start_at',
        'description',
        'password',
        'need_permission',
        'active',
    ];

    protected $dates = [
        'start_at',
        'deleted_at',
    ];

    /**
     * 多对多关联题目
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_paper_question')
            ->withPivot('sort', 'score')
            ->orderBy('exam_paper_question.sort', 'asc');
    }

    /**
     * 包含的答题日志
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
