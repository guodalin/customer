<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {

        return view('frontend.index');
    }

    public function qrcode()
    {
        $customers = Customer::get()->toArray();
        $rand = rand(1, count($customers));
        if (!isset($_COOKIE['rand'])) {
            setcookie('rand', $rand);
        } else {
            $rand = $_COOKIE['rand'];
        }

        $customer = isset($customers[$rand]) ? $customers[$rand] : ['name' => '官方客服','avatar' => 'http://rand.test/storage/avatars/vMA5mj6FiMtM5Pnf0EuBhF2NpCPKau8eN1IZidm6.png'];
        return view('frontend.qrcode',compact('customer'));
    }
}
