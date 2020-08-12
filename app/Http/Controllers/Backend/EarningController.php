<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Earning;
use Illuminate\Support\Facades\Storage;


class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->only('q');

        $earnings = Earning::search($search)->orderBy('id', 'desc')->paginate();;

        return view('backend.earning.index',compact('earnings', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.earning.create');
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
        Earning::create($data);

        return redirect()->route('admin.earning.index')->withFlashSuccess('创建成功');
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
    public function edit(Earning $earning)
    {
        if($earning->avatar){
            $earning->tmp_avatar =  Storage::url($earning->avatar);
        }else{
            $earning->tmp_avatar =  '';
        }

        return view('backend.earning.edit', ['earning' => $earning]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, earning $earning)
    {
        $path = '';
        if ($request->file('avatar')) {
            $path = $request->file('avatar')->store('avatars');
        }

        $data = [
            'name' => $request->input('name'),
            'info' => $request->input('info'),
            'avatar' => $path
        ];
        $earning->update($data);

        return redirect()->route('admin.earning.index')->withFlashSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Earning $earning)
    {
        $earning->delete();

        return redirect()->route('admin.earning.index')->withFlashSuccess('删除成功');
    }
}
