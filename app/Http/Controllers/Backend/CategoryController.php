<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Category\StoreCategoryRequest;
use App\Http\Resources\Backend\Category\CategoryResource;
use App\Models\General\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            return CategoryResource::collection(Category::whereIsRoot()->get());
        }

        return view('backend.category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->only('name', 'parent_id'));

        return (new CategoryResource($category))->additional(['message' => '栏目创建成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\General\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category->tree = $category->descendants()->defaultOrder()->get()->toTree();

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\General\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->fill($request->only('name', 'parent_id'))
            ->save();

        return ['message' => '分类更新成功!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\General\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return ['message' => '分类已删除'];
    }

    /**
     * Swap the specified resource from storage.
     *
     * @param  \App\Models\General\Category $category
     * @param  string                    $direction
     * @return \Illuminate\Http\Response
     */
    public function swap(Category $category, $direction)
    {
        if ($direction == 'up') {
            $category->up();
        } else {
            $category->down();
        }

        return [];
    }
}
