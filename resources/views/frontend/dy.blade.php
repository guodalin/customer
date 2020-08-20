{{--  @extends('frontend.layouts.appdy')  --}}

{{--  @section('title', $dy['name'] )

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
</div>  --}}

@extends('frontend.layouts.appearn')

@section('title', '3小时银行流水100万，网赚天后带你赚钱！' )

@section('content')
<link rel="stylesheet" href="{{ asset('css/dialog.css') }}">
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/dialog.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/clipboard.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/log.js') }}"></script>
<script type="text/javascript">
    var arr_wx =['347482250','470171678'];
         var wx_index = Math.floor((Math.random()*arr_wx.length));
         var stxlwx = "{{ $dy['name'] }}";
</script>
<style type="text/css">
    body {
        font-family: Microsoft Yahei, tahoma, arial, simsun;
        font-size: 16px;
        background: #fff;
        color: #252525;
        height: 100%;
    }

    body,
    p,
    h1,
    h2,
    h3,
    ul,
    li,
    h5 {
        padding: 0;
        margin: 0;
    }

    li {
        list-style-type: none;
    }

    a,
    a:visited {
        color: #999;
        font-size: 13px;
        text-decoration: none;
    }

    img {
        border: 0;
        vertical-align: middle;
        max-width: 100%;
    }

    #wx_icon {
        position: fixed;
        right: 3%;
        z-index: 99;
        background: url(comm/wx_icon.html) no-repeat;
        top: 45%;
        width: 88px;
        height: 99px;
        background-size: 88px;
    }

    #wx_copy {
        width: 100%;
        height: 100%;
        position: fixed;
        left: 0;
        top: 0;
        background: rgba(0, 0, 0, .7);
    }

    .wx_note {
        width: 84%;
        position: fixed;
        z-index: 999;
        top: 30%;
        left: 8%;
        background: #fff;
        border-radius: 5px;
    }

    .wx_note p {
        height: 80px;
        text-align: center;
        line-height: 80px;
    }

    .wx_note p.wx1 {
        font-size: 28px;
        color: #666;
    }

    .wx_note p.wx2 {
        background: #b40000;
        font-size: 32px;
        color: #fff;
        height: 60px;
        line-height: 60px;
    }

    .wx_note p a,
    .wx_note p a:visited {
        font-size: 20px;
        color: #06f;
        margin-left: 8px;
    }

    #close_wx {
        position: absolute;
        right: -18px;
        top: -18px;
        width: 36px;
        height: 36px;
        background: url(comm/close.html) no-repeat;
        background-size: 36px;
    }

    header,
    nav,
    article,
    section,
    footer {
        width: 670px;
        margin: 0 auto;
        overflow: hidden;
    }

    header h1 {
        font-size: 24px;
        margin: 36px 0 15px;
        line-height: 130%;
        font-weight: normal;
        border-bottom: 1px solid #e7e7eb;
        padding-bottom: 16px;
    }

    nav {
        color: #8c8c8c;
    }

    nav span {
        color: #607fa6;
        margin-left: 12px;
    }

    article {
        line-height: 170%;
    }

    article p {
        margin-top: 15px;
    }

    article p span,
    article p strong,
    section li p strong {
        color: #ff2941;
    }

    article h5 {
        margin: 20px auto;
    }

    article h5 span {
        color: #607fa6;
        margin-right: 10px;
    }

    article h5 small {
        font-size: 16px;
        margin-left: 12px;
        background: url(../../../img/frontend/zan.png) no-repeat;
        background-size: 18px;
        padding-left: 19px;
    }

    section h2,
    article h5 {
        font-size: 16px;
        color: #8c8c8c;
        font-weight: normal;
    }

    section h2 {
        border-top: 1px dotted #8c8c8c;
        padding: 26px 0 8px;
        text-align: center;
    }

    section li {
        margin-top: 20px;
        overflow: hidden;
    }

    section li h3 {
        float: left;
        width: 35px;
    }

    section li h3 img {
        width: 35px;
    }

    section li p {
        margin-left: 45px;
        line-height: 160%;
    }

    section li p span {
        display: block;
        color: #999;
    }

    section li p img {
        margin-bottom: 8px;
    }

    section li p small {
        display: block;
        color: #999;
        font-size: 14px;
    }

    footer {
        margin-top: 50px;
        text-align: center;
        line-height: 100%;
        color: #999;
        background: #f0f0f0;
        padding: 3px 0;
    }

    @media (max-width:767px) {
        #wx_icon {
            width: 56px;
            height: 63px;
            background-size: 56px;
        }

        header,
        nav,
        article,
        section,
        footer {
            width: 90%;
            padding: 0 5%;
        }

        header h1 {
            margin-top: 20px;
            border: none;
            padding: 0;
        }

        footer {
            padding: 3px 0 2px;
        }
    }

    .tu4 {
        position: relative;
    }

    .wechat {
        /* position:absolute;
            left: 0;
            bottom:0.5%; */
        font-size: 21px;
        background-color: yellow;
        color: black;
        line-height: 1;

    }

    .wechat button {
        width: 100%;
        border: 1px solid rgba(180, 176, 176, 0.7);
        border-top: none;
        font-size: 18px;
    }

    @keyframes wechat_wx {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 1;
        }

        50.01% {
            opacity: 0;
        }

        100% {
            opacity: 0;
        }
    }

    .wechat_wx {
        color: red;
        font-size: 20px;
        animation: wechat_wx 0.8s linear infinite;
    }

    article p span,
    article p strong,
    section li p strong {
        color: black;
    }

    .dianji {
        /* position:absolute;
            right: 0;
            bottom: 0%;
            font-size: 21px;
            background: chartreuse;
            line-height: 1;
            color: black; */
        text-align: center;
        margin: 0;
    }

    .layui-layer-setwin {
        top: 0 !important;
        right: 0 !important;
    }

    .layui-layer-ico.layui-layer-close.layui-layer-close1 {
        padding: 12px;
        background-position: 12px -58px;
        background-size: 360px;
    }

    .copy_btn {
        border: none;
        background: none;
        font-size: inherit;
        padding: 0px;
    }
</style>
<div class="row">
    <div id="flow_wx">
        <p id="wx_icon" style="display:block;"></p>
        <div id="wx_copy" style="display:none;">
            <div class="wx_note">
                <p class="wx1">长按微信号复制</p>
                <p class="wx2">
                    <button data-setting-click="baidu" data-clipboard-action="copy" data-clipboard-target="#target"
                        class="copy_btn">
                        <script>
                            document.write(stxlwx);
                        </script>
                    </button>
                </p>
                <p class="wx3">
                    <span>打开微信添加好友</span>
                    <a href="weixin://" onclick="PIWI_SUBMIT.Weixin_Open()">打开微信</a>
                </p>
                <p id="close_wx"></p>
            </div>
        </div>
    </div>
    <header>
        {{--  <h1>3小时银行流水100万，网赚天后带你赚钱！</h1>  --}}
    </header>
    <nav style="text-align:center">
        <img src="{{ asset('img/frontend/dy.png') }}" alt="" srcset="" style="width:50%;margin-top:10px;">
    </nav>
    <article>
            <h2 style="margin-bottom:10px;text-align:center">招聘抖音点赞兼职</h2>
            <div style="margin-bottom:10px;text-align:center">
                <img src="{{ asset('img/frontend/hb.jpg') }}" alt="" srcset="" style="width:80%;margin:5px 0px;"><br />
            </div>
            <p>1、月收入过万，手机工作。</p>
            <p>2、主要给网红关注和点赞，在家就能做。</p>
            <p>3、每个点赞关注1.8元，看手速和时间，有限量。</p>
            <p>4、时间自由，实时结算工资，一天300+。<br />
                <span class="text-danger">（正规工作，不收押金，只招前1000名）</span></p>
            <div style="margin-bottom:10px;text-align:center">
                <img src="{{ asset('img/frontend/8.jpg') }}" alt="" srcset="" style="width:80%;margin:5px 0px;"><br />
            </div>
            <a class="wechat">
                <button data-setting-click="baidu" data-clipboard-action="copy" data-clipboard-target="#target" class="copy_btn">
                    <span class="wechat_wx">&nbsp;<script>
                            document.write(stxlwx);
                        </script>&nbsp; </span></button>
            </a>
            <p class="dianji">(点击复制微信号)</p>
            <div style="margin-bottom:10px;text-align:center">
                <img src="{{ asset('img/frontend/9.jpg') }}" alt="" srcset="" style="width:80%;margin:5px 0px;"><br />
            </div>
            <a class="wechat">
                <button data-setting-click="baidu" data-clipboard-action="copy" data-clipboard-target="#target" class="copy_btn">
                    <span class="wechat_wx">&nbsp;<script>
                            document.write(stxlwx);
                        </script>&nbsp; </span></button>
            </a>
            <p class="dianji">(点击复制微信号)</p>
            <div style="margin-bottom:10px;text-align:center">
                <img src="{{ asset('img/frontend/7.jpg') }}" alt="" srcset="" style="width:80%;margin:5px 0px;"><br />
            </div>
            <a class="wechat">
                <button data-setting-click="baidu" data-clipboard-action="copy" data-clipboard-target="#target" class="copy_btn">
                    <span class="wechat_wx">&nbsp;<script>
                            document.write(stxlwx);
                        </script>&nbsp; </span></button>
            </a>
            <p class="dianji">(点击复制微信号)</p>
            你一定像大部分人一样每天大量的时间在刷抖音，但你知道每天动动手指点赞就能赚钱吗？！抖音点赞，又好玩又赚钱的兼职。<b class="text-danger"
                style="font-size:20px;color:red">点击复制 客服微信号<button data-setting-click="baidu" data-clipboard-action="copy" data-clipboard-target="#target" class="copy_btn" style="font-size:20px;color:red">
                    <script>
                        document.write(stxlwx);
                    </script>
                </button>了解咨询</b>

    <br><br>
    <br><br>
    <div class="record"
        style="position: fixed; bottom: 0; left: 0; height:23px;text-align: center;width: 100%;font-size: 20px;background: #d7f2fb;box-shadow: 1px -2px 12px 0px #ccc;padding: 16px 0;">
        <div>
            <span>点击添加客服微信</span>
            <strong>
                <button data-setting-click="baidu" data-clipboard-action="copy" data-clipboard-target="#target"
                    class="copy_btn" id="target">
                    <script>
                        document.write(stxlwx);
                    </script>
                </button>
            </strong>
        </div>
    </div>
</div>
@endsection
