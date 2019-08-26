<?php

namespace Comcsoft\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Image\Manipulations;

class Comment extends Model implements HasMedia
{
    use NodeTrait,
        SoftDeletes,
        HasMediaTrait;

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
        'media', 'commenter'
    ];

    /**
     * Make Relationship for commenter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commenter()
    {
        return $this->belongsTo(config('comment.commenter.model'), 'user_id', config('comment.commenter.table.primary_key'));
    }

    /**
     * Morph Relation for commentable
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Register Media Collections
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection('galleries')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, config('comment.media.thumb.width'), config('comment.media.thumb.width'))
                    ->optimize();
            });
    }

    /**
     * Get galleries
     *
     * @return Collection
     */
    public function getGalleriesAttribute()
    {
        return $this->getMedia('galleries')->map(function ($media) {
            return [
                'original' => $media->getUrl(),
                'thumb' => $media->getUrl('thumb'),
            ];
        });
    }

    /**
     * attach galleries
     *
     * @param array $keys
     * @return void
     */
    public function attachGalleriesFromRequest(array $keys)
    {
        $this->addMultipleMediaFromRequest($keys)->each(function ($fileAddr) {
            $fileAddr->toMediaCollection('galleries');
        });
    }

    /**
     * add a comment
     *
     * @param \Illuminate\Database\Eloquent\Model $commenter
     * @param \Illuminate\Database\Eloquent\Model $commentable
     * @param null|string $message
     * @param array|string|null $mediaKeys
     * @param boolean $anonymous
     * @param null|\Illuminate\Database\Eloquent\Model $replyTo
     * @return self
     */
    public static function add($commenter, $commentable, $message = null, $mediaKeys = null, $anonymous = false, $replyTo = null)
    {
        return \DB::transaction(function () use ($commenter, $commentable, $message, $mediaKeys, $anonymous, $replyTo) {
            $comment = new static;

            $comment->commenter()->associate($commenter);
            $comment->commentable()->associate($commentable);

            $comment->message = $message;
            $comment->anonymous = $anonymous ? true : false;

            if ($replyTo instanceof static) {
                $comment->appendToNode($replyTo);
            }

            $comment->save();

            if ($mediaKeys) {
                if (is_string($mediaKeys)) {
                    $mediaKeys = [$mediaKeys];
                }

                $comment->attachGalleriesFromRequest($mediaKeys);
            }

            return $comment;
        });
    }

    /**
     * add a reply to this comment;
     * e.g.: $comment->addReply('hello');
     *
     * @param string|null $message
     * @param array|string|null $medias
     * @param null|\Illuminate\Database\Eloquent\Model $commenter
     * @param boolean $anonymous
     * @return self
     */
    public function addReply($message = null, $medias = null, $commenter = null, $anonymous = false)
    {
        return static::add($commenter ?: auth()->user(), $this->commentable, $message, $medias, $anonymous, $this);
    }
}
