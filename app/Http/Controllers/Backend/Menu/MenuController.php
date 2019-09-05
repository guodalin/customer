<?php

namespace App\Http\Controllers\Backend\Menu;

use Illuminate\Http\Request;
use App\Helpers\General\MenuHelper;
use App\Models\Menu\Menu;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Menu\StoreMenuRequest;
use App\Http\Requests\Backend\Menu\UpdateMenuRequest;
use App\Http\Resources\Backend\Menu\MenuResource;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            return MenuResource::collection(Menu::withCount('items')->latest()->get());
        }

        return view('backend.menu.index');
    }

    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create($request->only('name', 'nickname'));

        return ['message' => '菜单创建成功，请为其添加菜单项'];
    }

    public function demo()
    {
        \DB::transaction(function () {
            $bm = (new MenuHelper())->usingBackendMenu();
            // or 获得菜单实例, 如果不存在，指定NAME创建, 不指定使用随机值
            // $bm = (new MenuHelper())->menu('key', ?'NAME');

            // 添加小标题
            $bm->addTitle('视频2', ['class' => 'nav-title'], ['fab fa-elementor'], ['test' => 1]);

            // 添加菜单
            $bm->addRoute('直播管理3', 'admin.auth.user.index', ['class' => 'nav-item'], ['fab fa-youtube']);
            $bm->addRoute('点播管理3', 'admin.auth.user.create', ['class' => 'nav-item'], ['far fa-play-circle']);

            // 添加层级菜单
            $parent = $bm->addUrl('讲座管理23', '#', ['class' => 'nav-item'], ['fas fa-chalkboard-teacher']);
            $child1 = $bm->addRoute('讲座23', 'admin.auth.user.show', ['class' => 'nav-item'], ['fas fa-school']);
            $child1->appendToNode($parent)->save();

            // 添加分割线
            $bm->addSeparator();
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\System\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        $menu->tree = $menu->items()->defaultOrder()->get()->toTree();

        return new MenuResource($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\System\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->fill($request->only('name', 'nickname'))
            ->save();

        return ['message' => '菜单更新成功!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\System\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return ['message' => '菜单删除成功!'];
    }
}
