<?php

namespace Comcsoft\Aio\Comment\Traits;

use Illuminate\Database\Eloquent\Model;

trait CommentTrait
{
    protected $queuedMedias = [];

    public static function bootCommentTrait()
    {
        static::created(function (Model $model) {
            if (count($model->queuedMedias) > 0) {
                $model->attachMedias($model->queuedMedias);
                $model->queuedMedias = [];
            }
        });

        static::deleted(function (Model $model) {
            $model->emptyMedias();
        });
    }

    /**
     * the media collection name
     *
     * @return string
     */
    public function theMediaCollectionName()
    {
        return 'comments';
    }

    /**
     * Get comment medias.
     *
     * @return Collection
     */
    public function getMediasAttribute()
    {
        return $this->getMedia($this->theMediaCollectionName())->map(function ($media) {
            return [
                'original' => $media->getUrl(),
                'thumb'    => $media->getUrl('thumb'),
            ];
        });
    }

    /**
     * @param string|array $medias
     */
    public function setMediasAttribute($medias)
    {
        if (!$this->exists) {
            $this->queuedMedias = $medias;

            return;
        }

        // TODO: remove existed medias ?
        $this->attachMedias($medias);
    }

    /**
     * 添加媒体
     *
     * @param array $medias
     * @return void
     */
    public function attachMedias($medias)
    {
        $this->addMultipleMediaFromRequest($medias)
            ->each(function ($fileAddr) {
                $fileAddr->toMediaCollection($this->theMediaCollectionName());
            });
    }

    /**
     * 清空媒体
     *
     * @return void
     */
    public function emptyMedias()
    {
        $this->getMedia($this->theMediaCollectionName())->each(function ($media) {
            $this->deleteMedia($media);
        });
    }
}
