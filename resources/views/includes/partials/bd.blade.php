@if(config('analytics.baidu-analytics') && config('analytics.baidu-analytics') !== 'xxxxxxxx')
    {{-- 百度统计 Analytics: change xxxxxxxx to be your site's ID. --}}
    <script>
        var _hmt = _hmt || [];
    	(function() {
    	  	var hm = document.createElement("script");
    	  	hm.src = "https://hm.baidu.com/hm.js?{{ config('analytics.baidu-analytics') }}";
    	  	var s = document.getElementsByTagName("script")[0];
    	  	s.parentNode.insertBefore(hm, s);
    	})();
    </script>
@endif
