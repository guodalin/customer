<?php

namespace App\Http\Controllers\Backend\Menu;

use App\Models\Menu\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Menu\UpdateMenuItemRequest;
use App\Http\Resources\Backend\Menu\MenuItemResource;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateMenuItemRequest $request)
    {
        $item = MenuItem::create($request->only('menu_id', 'parent_id', 'name', 'icon', 'just_icon',
                'show', 'html_attributes', 'meta', 'type', 'link', 'active'));

        return (new MenuItemResource($item))->additional(['message' => '成功添加菜单项']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function show(MenuItem $menuItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu\MenuItem  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuItemRequest $request, MenuItem $item)
    {
        $item->fill($request->only('name', 'type', 'link', 'show', 'active', 'icon', 'just_icon', 'html_attributes', 'meta'))
            ->save();

        return ['message' => '菜单项更新成功!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $item)
    {
        $item->delete();

        return ['message' => '菜单项已删除'];
    }

    /**
     * Swap the specified resource from storage.
     *
     * @param  \App\Models\Menu\MenuItem  $menuItem
     * @param string $direction
     * @return \Illuminate\Http\Response
     */
    public function swap(MenuItem $item, $direction)
    {
        if ($direction == 'up') {
            $item->up();
        } else {
            $item->down();
        }

        return [];
    }
}
