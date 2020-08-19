@extends('frontend.layouts.appdy')

@section('title', $dy['name'] )

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom:60px">
        <div class="text-center">
            <img src="{{ asset('img/frontend/dy.png') }}" alt="" srcset="" style="width:50%;margin-top:10px">
            <h3 style="margin-bottom:10px">招聘抖音点赞兼职</h3>
        </div>

        <p>1、月收入过万，手机工作。</p>
        <p>2、主要给网红关注和点赞，在家就能做。</p>
        <p>3、每个点赞关注1.8元，看手速和时间，有限量。</p>
        <p>4、时间自由，实时结算工资，一天300+。<br/>
        <span class="text-danger">（正规工作，不收押金，只招前1000名）</span></p>
        <div class="text-center">
            <img src="{{ asset('img/frontend/hb.jpg') }}" alt="" srcset="" style="width:80%;margin:5px 0px;"><br/>
        </div>
        你一定像大部分人一样每天大量的时间在刷抖音，但你知道每天动动手指点赞就能赚钱吗？！抖音点赞，又好玩又赚钱的兼职。<b class="text-danger" style="font-size:20px;">点击下方“添加客服”按键咨询！！！</b>
    </div>
    <div>
        <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal" style="position:fixed;bottom:3px;font-size:1.8rem">
            添加客服
        </button>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal fade" id="exampleModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ $dy['name'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <small class="text-danger">提示：<br />1.截图保存二维码；<br/>2.打开微信扫一扫；<br />3.扫相册二维码，添加公众号咨询客服报名赚钱！</small>
                        <img src="{{ asset('storage/'.$dy['avatar']) }}" alt="" srcset="" style="width:100%;margin-top:10px">
                    </div>
                    <div class="modal-footer" >
                        <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
