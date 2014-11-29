// JavaScript Document

var page = {
		getQuery : function (para) {
				var reg = new RegExp("(^|&)" + para + "=([^&]*)(&|$)");
				var r = window.location.search.substr(1).match(reg);
				if(r != null)
					return unescape(r[2]);
				return 1;
			},
		back : function () {
				var s = location.href;
				if (s.indexOf("page") == -1)
				{
					if (s.indexOf("?") == -1)
						location.href = s + "?page=1";
					else
						location.href = s + "&page=1";
				} else {
					var t = parseInt(page.getQuery("page")) - 1;
					if (t<1)
						t = 1;
					location.href = s.replace("page=" + page.getQuery("page"), "page=" + t);
				}
			},
		next : function () {
				var s = location.href;
				if (s.indexOf("page") == -1)
				{
					if (s.indexOf("?") == -1)
						location.href = s + "?page=2";
					else
						location.href = s + "&page=2";
				}else
					location.href = s.replace("page=" + page.getQuery("page"), "page=" + (parseInt(page.getQuery("page")) + 1));
			},
		go : function () {
				var s = location.href;
				if (s.indexOf("page") == -1)
				{
					if (s.indexOf("?") == -1)
						location.href = s + "?page=" + document.getElementById("page_input").value;
					else
						location.href = s + "&page=" + document.getElementById("page_input").value;
				}
				else
					location.href = s.replace("page=" + page.getQuery("page"), "page=" + document.getElementById("page_input").value);
			}
	};

document.write('\
<!--翻页插件-->\
<style>\
	.page_btn {\
		border: 1px solid #999;\
		padding: 3px;\
		color: #0F0;\
		margin-top: 10px;\
		text-decoration: none;\
	}\
	.page_input {\
		padding: 3px;\
		color: #0F0;\
		border: 1px solid #999;\
		width: 17px;\
	}\
</style>\
<center>\
	<br />\
	<a class="page_btn" href="javascript:page.back();">上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
	<input class="page_input" type="text" value="1" id="page_input" />\
	<script language="javascript">\
		document.getElementById("page_input").value = page.getQuery("page");\
	</script>\
	<a class="page_btn" href="javascript:page.go();">Go</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
	<a class="page_btn" href="javascript:page.next();">下一页</a>\
</center>\
<!--翻页插件-->');