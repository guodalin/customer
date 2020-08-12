//window.onload = function () {
    var clipboard = new Clipboard('.copy_btn');
    clipboard.on('success', function (e) {
        var dialog1 = $(document).dialog({
            type: 'confirm',
            closeBtnShow: true,
            overlayClose: true,
            content: '微信号复制成功，立刻为你打开微信',
            onClickConfirmBtn: function () {
                window.location.href = 'weixin://';
            }
        });

        setTimeout(function () {
            window.location.href = 'weixin://';
        }, 3000);

        e.clearSelection();
    });

    pushHistory();
    window.addEventListener("popstate", function (e) {
      pushHistory();
        var dialog1 = $(document).dialog({
            type: 'confirm',
            closeBtnShow: true,
            overlayClose: true,
           // content: '<div><p>恭喜获得客服指导一次，点击添加客服微信</p><p style="font-size:22px;text-align: center;color: red; ">立刻添加微信</p></div>',
          content:'<p>恭喜您获得免费获得客服指导一次</p><p style="font-size:22px;text-align: center;color: red; ">立刻添加微信</p>',
             onClickConfirmBtn:function () {
              $('#target').click();
                    window.location.href = 'weixin://';
                    layer.closeAll();
            }

                  });


    }, false);

    function pushHistory() {
        var state = {
            title: "title",
            url: "#"
        };
        window.history.pushState(state, "title", "#");
    }
//}