<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class MenuItem extends Model
{
    use NodeTrait;

    /**
     * 纯文字.
     */
    const TYPE_OF_RAW = 'raw';

    /**
     * URL.
     */
    const TYPE_OF_URL = 'url';

    /**
     * 命名路由.
     */
    const TYPE_OF_ROUTE = 'route';

    /**
     * 动作.
     */
    const TYPE_OF_ACTION = 'action';

    /**
     * 分割线
     */
    const TYPE_OF_DIVIDE = 'divide';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'menu_id',
        'nickname',
        'type',
        'link',
        'icon',
        'just_icon',
        'html_attributes',
        'meta',
        'active',
        'show',
    ];

    /**
     * 属于的菜单.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    protected function getScopeAttributes()
    {
        return ['menu_id'];
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'show'      => 'boolean',
        'just_icon' => 'boolean',
        'html_attributes' => 'array',
        'meta'      => 'array',
    ];

    /**
     * 昵称属性.
     *
     * @return string
     */
    public function getNicknameAttribute()
    {
        return $this->attributes['nickname'] ?: ('menuitem_' . $this->id);
    }

    public function getTypeAttribute()
    {
        return trim($this->attributes['type']);
    }

    /**
     * get full url.
     *
     * @return string|null
     */
    public function url()
    {
        $url = $this->link;

        switch ($this->type) {
            case static::TYPE_OF_ACTION:
                $url = action($this->link);
                break;
            case static::TYPE_OF_ROUTE:
                $url = route($this->link);
                break;
            case static::TYPE_OF_RAW:
            case static::TYPE_OF_DIVIDE:
                $url = null;
                break;
        }

        return $url;
    }

    /**
     * just show.
     *
     * @param  mixed $query
     * @return mixed
     */
    public function scopeShow($query)
    {
        return $query->where('show', true);
    }

    public function isRaw()
    {
        return $this->type == static::TYPE_OF_RAW;
    }

    public function isDivider()
    {
        return $this->type == static::TYPE_OF_DIVIDE;
    }

    public function hasIcon()
    {
        return !empty($this->icon);
    }
}
