<?php

namespace App\Helpers\General;

use App\Models\Menu\Menu;
use App\Models\Menu\MenuItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Lavary\Menu\Facade as MenuFacade;

class MenuHelper
{
    /**
     * The menu instance.
     *
     * @var null|\App\Models\Menu\Menu
     */
    protected $menu;

    /**
     * MenuHelper constructor.
     *
     * @param \App\Models\Menu\Menu
     */
    public function __construct(Menu $menu = null)
    {
        $this->menu = $menu;
    }

    public function usingBackendMenu()
    {
        $this->menu = Menu::findBackendMenu();

        return $this;
    }

    public function menu($key, $name = '')
    {
        $this->menu = Menu::firstOrCreate(['nickname' => $key], ['name' => $name ?: Str::random(8)]);

        return $this;
    }

    public function addTitle($name, $html = [], $icon = [], $meta = [])
    {
        return $this->addItem($name, [MenuItem::TYPE_OF_RAW], $html, $icon, $meta);
    }

    public function addUrl($name, $url, $html = [], $icon = [], $meta = [], $active = '')
    {
        return $this->addItem($name, [MenuItem::TYPE_OF_URL, $url], $html, $icon, $meta, $active);
    }

    public function addRoute($name, $route, $html = [], $icon = [], $meta = [], $active = '')
    {
        return $this->addItem($name, [MenuItem::TYPE_OF_ROUTE, $route], $html, $icon, $meta, $active);
    }

    public function addAction($name, $action, $html = [], $icon = [], $meta = [], $active = '')
    {
        return $this->addItem($name, [MenuItem::TYPE_OF_ACTION, $action], $html, $icon, $meta, $active);
    }

    public function addSeparator($name = null, $html = [])
    {
        return $this->addItem($name ?: 'SEPARATOR', [MenuItem::TYPE_OF_DIVIDE], $html);
    }

    /**
     * 添加链接
     *
     * @param string $name
     * @param array $html HTML属性
     * @param array $icon 图标设置 [0 => 图标地址或者样式, 1 => true 仅显示图标 false 都显示]
     * @param array $meta 其他设置
     * @param string $active 激活pattern
     * @return self
     */
    public function addItem($name, $links = [], $html = [], $icon = [], $meta = [], $active = '')
    {
        return $this->menu->items()->create([
            'name' => $name,
            'type' => $links[0] ?? MenuItem::TYPE_OF_URL,
            'link' => $links[1] ?? '',
            'icon' => $icon[0] ?? null,
            'just_icon' => $icon[1] ?? false,
            'meta' => $meta,
            'html_attributes' => $html,
            'active' => $active,
        ]);
    }

    public function items()
    {
        return MenuItem::scoped(['menu_id' => $this->menu->id])->defaultOrder()->get()->toTree();
    }

    public function build()
    {
        $items = $this->getCachedMenuItems();

        if ($items->isEmpty()) {
            return;
        }

        MenuFacade::makeOnce($this->menu->nickname, function ($menu) use ($items) {
            foreach ($items as $item) {
                $this->addItemToMenu($item, $menu);
            }
        });
    }

    public function getCachedMenuItems()
    {
        $key = 'menu.' . $this->menu->nickname . '.items';

        // no cache when app is under debug mode
        if (config('app.debug')) {
            Cache::forget($key);
        }

        return Cache::remember($key, now()->addMonth(), function () {
            return $this->items();
        });
    }

    /**
     * 将持久化的菜单项加入菜单
     *
     * @param MenuItem $item
     * @param mixed $menu
     * @return void
     */
    public function addItemToMenu(MenuItem $item, $menu)
    {
        if ($item->isRaw()) {
            $m = $menu->raw($item->name)
                ->attr($item->html_attributes)
                ->nickname($item->nickname)
                ->data($item->meta)
                ->id($item->id);
        } elseif ($item->isDivider()) {
            $m = $menu->divide();
        } else {
            $m = $menu->add($item->name, ['url' => $item->url()]);
        }

        $m->attr($item->html_attributes)
            ->nickname($item->nickname)
            ->data($item->meta)
            ->id($item->id);

        if ($item->hasIcon()) {
            $m->prepend('<i class="nav-icon ' . $item->icon . '"></i> ');
        }

        if ($item->active) {
            $m->active($item->active);
        }

        if ($item->children->isNotEmpty()) {
            foreach ($item->children as $child) {
                $this->addItemToMenu($child, $m);
            }
        }
    }
}
