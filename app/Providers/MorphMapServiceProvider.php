<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class MorphMapServiceProvider extends ServiceProvider
{
    /**
     * 设定多态模型映射关系.
     *
     * @var array
     */
    protected $morphMaps = [
        'user' => \App\Models\Auth\User::class,
        'role' => \App\Models\Auth\Role::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->setMorphMaps();
    }

    protected function setMorphMaps()
    {
        Relation::morphMap($this->morphMaps);
    }
}
