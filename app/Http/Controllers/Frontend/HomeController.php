<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Earning;

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
        $rand = rand(0, count($customers)-1);
        if (!isset($_COOKIE['rand'])) {
            setcookie('rand', $rand);
            if ($customers[$rand]) {
                Customer::find($customers[$rand]['id'])->increment('hits');
            }
        } else {
            $rand = $_COOKIE['rand'];
        }
        $customer = isset($customers[$rand]) ? $customers[$rand] : ['name' => '官方客服','avatar' => 'http://106.52.65.57:8081/storage/avatars/JsC8A6oBjZxbCocRVqTsqPNFv4TxouumYCVsrbSW.jpeg'];
        return view('frontend.qrcode',compact('customer'));
    }

    public function earn()
    {
        $earnings = Earning::get()->toArray();
        if(count($earnings) == 1){
            $rand = 0;
        }else{
            $rand = rand(0, count($earnings) - 1);
        }
        if (!isset($_COOKIE['rand'])) {
            setcookie('rand', $rand);
            // if ($earnings[$rand]) {
            //     Customer::find($earnings[$rand]['id'])->increment('hits');
            // }
        } else {
            $rand = $_COOKIE['rand'];
        }
        // dd($rand,$earnings);
        $earning = isset($earnings[$rand]) ? $earnings[$rand] : $earnings[0];
        return view('frontend.earn', compact('earning'));
    }
}
