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
         var stxlwx = {{ $earning['name'] }};
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
        margin-top: 20px;
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
                    <button data-setting-click="baidu" data-clipboard-action="copy" data-clipboard-target="#target" class="copy_btn">
                        <script>
                            document.write(stxlwx);
                        </script>{{ $earning['name'] }}
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
        <h1>3小时银行流水100万，网赚天后带你赚钱！</h1>
    </header>
    <nav>
        <span id="inn" style="margin:0 auto; color:#8c8c8c;font-size:16px">2020-8-12</span>
        <span>明星代言</span>
    </nav>
    <article>
        <p>
            <strong style="font-size:18px;">网赚天后、好运团队创始人刘仙芝接受小编采访，传授自己的成功之道。</strong>
            <br><br>
            <strong>好运团队-客服微信：<button data-setting-click="baidu" data-clipboard-action="copy" data-clipboard-target="#target" class="copy_btn">
                    <script>
                        document.write(stxlwx);
                    </script>
                </button>
            </strong>
        </p>
        <p>大家好，我是刘仙芝，半年之前我还是一个农村出来的普通90后女孩，领导口中的小刘，同事眼里的土姑娘。</p>
        <p class="tu4" style="text-align:center">
            <img src="{{ asset('img/frontend/1.jpg') }}" alt="" style="width:50%">
        </p>
        <p>一次偶然机会，让我接触到网赚，顿时对这种好玩又赚钱的项目产生浓厚兴趣。经过半年努力，现在我已经是拥有了千人团队的刘总，加入好运团队，利用一些空闲时间，轻松日赚千元。现在买了一辆宝马，一辆玛莎拉蒂，在上海这样大城市买了套200多平的大洋房。说这些不是炫富，只是想把我的经历告诉大家，让大家在这样一个浮华的尘世中，多些信心，历经千帆，归来仍是少年，你也可以成功！可以加下好运团队的客服微信了解下：
            <strong>
                <button data-setting-click="baidu" data-clipboard-action="copy" data-clipboard-target="#target" class="copy_btn">
                    <script>
                        document.write(stxlwx);
                    </script>
                </button>
            </strong>
        </p>
        <p class="tu4" style="text-align:center">
            <img src="{{ asset('img/frontend/2.jpg') }}" alt="" style="width:50%;margin-bottom:20px;">
        </p>
        <a class="wechat">
            <button data-setting-click="baidu" data-clipboard-action="copy" data-clipboard-target="#target"
                class="copy_btn"> <span class="wechat_wx">&nbsp;<script>
                        document.write(stxlwx);
                    </script>&nbsp; </span></button>
        </a> <br>
        <p class="dianji">(点击复制微信号)</p>
        <p>说实话，我之所以会投身这个行业，也是经过了一段时间的调查、验证，现在我要将自己的经验传授给更多想赚钱的朋友，一方面可以造福大家，另一方面，也可以扩充自己的团队，让更多人帮我一起赚钱。所以，欢迎大家加入我们。</p>
        <p class="tu4" style="text-align:center">
            <img src="{{ asset('img/frontend/3.jpg') }}" alt="" style="width:50%;margin-top:20px;">
        </p>
        <p>
            小编：当然，除了网赚天后，我也简单采访了好运团队的其他成员，大家也都讲了一下自己的历程，采访最后，他们对刘总表示了感谢：刘总践行了自己的诺言，真真实实带自己赚到了钱，也欢迎更多朋友加入赚钱的行列。
            <p>
                <strong>好运团队-客服微信号是：<button data-setting-click="baidu" data-clipboard-action="copy"
                        data-clipboard-target="#target" class="copy_btn">
                        <script>
                            document.write(stxlwx);
                        </script>
                    </button></strong>
            </p>
            <p class="tu4" style="text-align:center">
                <img src="{{ asset('img/frontend/4.jpg') }}" alt="" style="">
            </p>

            <p>所以小编觉得项目有保障！正规项目，可以长期操作！</p>
            <p>
                <strong>好运团队-客服微信号：<button data-setting-click="baidu" data-clipboard-action="copy"
                        data-clipboard-target="#target" class="copy_btn">
                        <script>
                            document.write(stxlwx);
                        </script>
                    </button></strong>
            </p>
            <h5>
                <span>阅读原文</span>阅读 200000+
                <small>7680</small>
            </h5>
    </article>
    <section>
        <h2>精选留言</h2>
        <ul>
            <li>
                <h3>
                    <img src="{{ asset('img/frontend/p1.jpg') }}">
                </h3>
                <p>
                    <span>行走人生</span>很早之前也听人说过网赚，没尝试过，2个月前，加了好运团队客服了解之后，到现在一个月稳定收益是之前工资的5倍了。
                    <img src="{{ asset('img/frontend/zan.png') }}">
                    <img src="{{ asset('img/frontend/zan.png') }}">
                    <small>今天</small>
                </p>
            </li>
            <li>
                <h3>
                    <img src="{{ asset('img/frontend/p5.jpg') }}">
                </h3>
                <p>
                    <span>小静</span>哈哈，我是最早跟着刘总的人之一，赚了多少就不炫耀了。
                    <img src="{{ asset('img/frontend/zan.png') }}">
                    <small>今天</small>
                </p>
            </li>
            <li>
                <h3>
                    <img src="{{ asset('img/frontend/p2.jpg') }}">
                </h3>
                <p>
                    <span>楼兰春色</span>我加了好运团队客服的微信，赶紧通过呀，时间不等人，早点开始，早点赚到钱。
                    <small>今天</small>
                </p>
            </li>
            <li>
                <h3>
                    <img src="{{ asset('img/frontend/p3.jpg') }}">
                </h3>
                <p>
                    <span>毛_大M</span>请问怎么操作啊？我也想赚钱，身边好多朋友赚到了，我也想试试
                    <small>今天</small>
                </p>
                <p>
                    <span>作者回复</span>你就加客服微信 xxxxxxx她会一步步细心地教你。
                    <small>今天</small>
                </p>
            </li>
            <li>
                <h3>
                    <img src="{{ asset('img/frontend/p4.jpg') }}">
                </h3>
                <p>
                    <span>雨菲菲</span>最开始看到，我也是没放心上，下定决心做之后，原来真的能赚钱，我刚加入，至少现在化妆品和衣服包包的钱解决了。
                    <small>今天</small>
                </p>
            </li>
        </ul>
    </section>
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
