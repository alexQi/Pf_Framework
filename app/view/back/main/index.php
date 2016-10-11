<script type="text/javascript">
var _menus = {
	"menus": [<?php echo $manageMenu; ?>]
};
$(document).ready(function(){
	InitLeftMenu()
	tabClose();
	tabCloseEven();

	$('.easyui-accordion li a').click(function(){
		var tabTitle = $(this).text();
		var url = $(this).attr("href");
		addTab(tabTitle,url);
		$('.easyui-accordion li div').removeClass("selected");
		$(this).parent().addClass("selected");
	}).hover(function(){
		$(this).parent().addClass("hover");
	},function(){
		$(this).parent().removeClass("hover");
	});
})

function InitLeftMenu() {

	$(".easyui-accordion").empty();
	var menulist = "";
   	var idx = 1;
	$.each(_menus.menus, function(i, n) {
		menulist = '<ul>';
		$.each(n.menus, function(j, o) {
			menulist += '<li><div><a target="mainFrame" href="' + o.url + '" ><span class="icon '+o.icon+'" >&nbsp;</span>' + o.menuname + '</a></div></li> ';
		})
		menulist += '</ul>';
		var is_select = false;
		if (idx==1) {
			is_select = true;
		};
		$('#easyui-accordion').accordion('add',{
			menuid:n.menuid,
			title:n.menuname,
			selected:is_select,
			content:menulist
		});
		idx++;
	})
}

function addTab(subtitle,url){
	if(!$('#tabs').tabs('exists',subtitle)){
		$('#tabs').tabs('add',{
			title:subtitle,
			content:createFrame(url),
			closable:true,
			width:$('#mainPanle').width()-10,
			height:$('#mainPanle').height()-26
		});
	}else{
		$('#tabs').tabs('select',subtitle);
	}
	tabClose();
}

function createFrame(url)
{
	var s = '<iframe name="mainFrame" scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
	return s;
}

function tabClose()
{
	/*双击关闭TAB选项卡*/
	$(".tabs-inner").dblclick(function(){
		var subtitle = $(this).children("span").text();
		$('#tabs').tabs('close',subtitle);
	})

	$(".tabs-inner").bind('contextmenu',function(e){
		$('#mm').menu('show', {
			left: e.pageX,
			top: e.pageY,
		});
		
		var subtitle =$(this).children("span").text();
		$('#mm').data("currtab",subtitle);
		
		return false;
	});
}
//绑定右键菜单事件
function tabCloseEven()
{
	//关闭当前
	$('#mm-tabclose').click(function(){
		var currtab_title = $('#mm').data("currtab");
		$('#tabs').tabs('close',currtab_title);
	})
	//全部关闭
	$('#mm-tabcloseall').click(function(){
		$('.tabs-inner span').each(function(i,n){
			var t = $(n).text();
			$('#tabs').tabs('close',t);
		});	
	});
	//关闭除当前之外的TAB
	$('#mm-tabcloseother').click(function(){
		var currtab_title = $('#mm').data("currtab");
		$('.tabs-inner span').each(function(i,n){
			var t = $(n).text();
			if(t!=currtab_title)
				$('#tabs').tabs('close',t);
		});	
	});
	//关闭当前右侧的TAB
	$('#mm-tabcloseright').click(function(){
		var nextall = $('.tabs-selected').nextAll();
		if(nextall.length==0){
			//msgShow('系统提示','后边没有啦~~','error');
			alert('后边没有啦~~');
			return false;
		}
		nextall.each(function(i,n){
			var t=$('a:eq(0) span',$(n)).text();
			$('#tabs').tabs('close',t);
		});
		return false;
	});
	//关闭当前左侧的TAB
	$('#mm-tabcloseleft').click(function(){
		var prevall = $('.tabs-selected').prevAll();
		if(prevall.length==0){
			alert('到头了，前边没有啦~~');
			return false;
		}
		prevall.each(function(i,n){
			var t=$('a:eq(0) span',$(n)).text();
			$('#tabs').tabs('close',t);
		});
		return false;
	});

	//退出
	$("#mm-exit").click(function(){
		$('#mm').menu('hide');
	})
}

//弹出信息窗口 title:标题 msgString:提示信息 msgType:信息类型 [error,info,question,warning]
function msgShow(title, msgString, msgType) {
	$.messager.alert(title, msgString, msgType);
}

function clockon() {
	var now = new Date();
	var year = now.getFullYear(); //getFullYear getYear
	var month = now.getMonth();
	var date = now.getDate();
	var day = now.getDay();
	var hour = now.getHours();
	var minu = now.getMinutes();
	var sec = now.getSeconds();
	var week;
	month = month + 1;
	if (month < 10) month = "0" + month;
	if (date < 10) date = "0" + date;
	if (hour < 10) hour = "0" + hour;
	if (minu < 10) minu = "0" + minu;
	if (sec < 10) sec = "0" + sec;
	var arr_week = new Array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六");
	week = arr_week[day];
	var time = "";
	time = year + "年" + month + "月" + date + "日" + " " + hour + ":" + minu + ":" + sec + " " + week;

	$("#bgclock").html(time);

	var timer = setTimeout("clockon()", 200);
}
$(function() {
	clockon();
	$('#loginOut').click(function() {
		$.messager.confirm('系统提示', '您确定要退出本次登录吗?', function(r) {

			if (r) {
				window.top.location.href = 'index.php?r=back/index/logout';
			}
		});

	})
	$('#tabs').tabs('add',{
		title:'this is an perfect world',
		content:''
	}).tabs({
		onSelect: function (title) {
			var currTab = $('#tabs').tabs('getTab', title);
			var iframe = $(currTab.panel('options').content);

			var src = iframe.attr('src');
			if(src){
				$('#tabs').tabs('update', { tab: currTab, options: { content: createFrame(src)} });
			}
		}
	});
});

</script>

<noscript>
	<div style=" position:absolute; z-index:100000; height:2046px;top:0px;left:0px; width:100%; background:white; text-align:center;">
		<img src="images/noscript.gif" alt='抱歉，请开启脚本支持！' />
	</div>
</noscript>
<div region="north" split="true" border="false" style="overflow: hidden; height: 50px; #7f99be repeat-x center 50%;line-height: 20px;font-family: Verdana, 微软雅黑,黑体">
	<span style="float:right; padding-right:20px;margin-top:10px;" class="head">
		<span style="margin-right:10px;" id="bgclock"></span>
		<span style="margin-right:10px;">欢迎登陆系统，<font color="red"><?php echo $_SESSION[Perfect]['userName']; ?></font></span>
		<a href="#" id="loginOut">安全退出</a>
	</span>
	<span style="padding-left:10px; font-size: 16px; ">
		<!-- <img src="images/blocks.gif" width="20" height="20" align="absmiddle" /> -->
	</span>
</div>
<div region="south" split="true" style="height: 30px; background: #D2E0F2; ">
	<div class="footer">The Black Rose shall bloom once more.</div>
</div>
<div region="west" hide="true" split="false" title="导航菜单" style="width:180px;" id="west">
	<div class="easyui-accordion" id="easyui-accordion" fit="true" border="false"></div>
</div>
<div id="mainPanle" region="center" style="background: #eee; overflow-y:hidden">
	<div id="tabs" class="easyui-tabs" fit="true" border="false">
	<!-- 内容显示区 -->
	</div>
</div>
<div id="mm" class="easyui-menu" style="width:150px;">
	<div id="mm-tabclose">关闭</div>
	<div id="mm-tabcloseall">全部关闭</div>
	<div id="mm-tabcloseother">除此之外全部关闭</div>
	<div class="menu-sep"></div>
	<div id="mm-tabcloseright">当前页右侧全部关闭</div>
	<div id="mm-tabcloseleft">当前页左侧全部关闭</div>
	<div class="menu-sep"></div>
	<div id="mm-exit">退出</div>
</div>
