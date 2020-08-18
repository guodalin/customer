<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dy;
use Illuminate\Support\Facades\Storage;


class DyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->only('q');

        $dys = Dy::search($search)->paginate();

        return view('backend.dy.index',compact('dys', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.dy.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = '';
        if($request->file('avatar')){
            $path = $request->file('avatar')->store('avatars');
        }

        $data = [
            'name' => $request->input('name'),
            'info' => $request->input('info'),
            'avatar' => $path
        ];
        Dy::create($data);

        return redirect()->route('admin.dy.index')->withFlashSuccess('创建成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dy $dy)
    {
        if($dy->avatar){
            $dy->tmp_avatar =  Storage::url($dy->avatar);
        }else{
            $dy->tmp_avatar =  '';
        }

        return view('backend.dy.edit', ['dy' => $dy]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dy $dy)
    {
        if ($request->file('avatar')) {
            $path = $request->file('avatar')->store('avatars');
            $dy->avatar = $path;
        }
        $dy->name = $request->input('name');
        $dy->info = $request->input('info');
        $dy->save();

        return redirect()->route('admin.dy.index')->withFlashSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Dy $dy)
    {
        $dy->delete();

        return redirect()->route('admin.dy.index')->withFlashSuccess('删除成功');
    }
}
