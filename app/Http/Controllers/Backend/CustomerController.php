<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->only('q');

        $customers = Customer::search($search)->orderBy('id', 'desc')->paginate();;

        return view('backend.customer.index',compact('customers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $request->file('avatar')->store('avatars');

        $data = [
            'name' => $request->input('name'),
            'info' => $request->input('info'),
            'avatar' => $path
        ];
        $customer = Customer::create($data);

        return redirect()->route('admin.customer.index')->withFlashSuccess('创建成功');
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
    public function edit(Customer $customer)
    {
        $customer->tmp_avatar =  Storage::url($customer->avatar);

        return view('backend.customer.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customer $customer)
    {
        if ($request->file('avatar')) {
            $path = $request->file('avatar')->store('avatars');
            $customer->avatar = $path;
        }
        $customer->name = $request->input('name');
        $customer->info = $request->input('info');
        $customer->save();

        return redirect()->route('admin.customer.index')->withFlashSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customer.index')->withFlashSuccess('删除成功');
    }
}
