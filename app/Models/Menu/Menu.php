<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nickname',
        'html_attributes',
    ];

    /**
     * 包含的菜单项.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(MenuItem::class, 'menu_id');
    }

    /**
     * 序列化html属性.
     *
     * @param  array $value
     * @return self
     */
    public function setHtmlAttributesAttribute($value)
    {
        $this->attributes['html_attributes'] = serialize($value);

        return $this;
    }

    /**
     * 反序列化html属性.
     *
     * @return mixed
     */
    public function getHtmlAttributesAttribute()
    {
        return unserialize($this->attributes['html_attributes']);
    }

    /**
     * 获得后台菜单实例.
     *
     * @return self
     */
    public static function findBackendMenu()
    {
        return static::query()->firstOrCreate(['nickname' => config('aio.menu.backend')], ['name' => __('menus.backend.name')]);
    }
}
