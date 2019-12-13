<?php

namespace Comcsoft\Aio\Comment\Models;

use Comcsoft\Aio\Comment\Traits\CommentTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Comment extends Model implements HasMedia
{
    use NodeTrait,
        SoftDeletes,
        HasMediaTrait,
        CommentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'commentable_type',
        'commentable_id',
        'user_id',
        'message',
        'anonymous',
        'active',
        'medias',  // virtual key to attach medias
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'media', 'commenter',
    ];

    /**
     * Make Relationship for commenter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commenter()
    {
        return $this->belongsTo(config('comment.commenter.model'), 'user_id', config('comment.commenter.table.primary_key'));
    }

    /**
     * Morph Relation for commentable.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Register Media Collections.
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection($this->theMediaCollectionName())
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, config('comment.media.thumb.width'), config('comment.media.thumb.height'))
                    ->format(Manipulations::FORMAT_PNG)
                    ->background('transparent')
                    ->optimize();
            });
    }

    /**
     * scope of active
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }
}
