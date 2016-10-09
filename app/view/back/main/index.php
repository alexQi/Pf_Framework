<script type="text/javascript">
var _menus = {
	"menus": [<?php echo $manageMenu; ?>]
};
$(function() {
	$('#loginOut').click(function() {
		$.messager.confirm('系统提示', '您确定要退出本次登录吗?', function(r) {

			if (r) {
				location.href = 'index.php?r=back/index/logout';
			}
		});

	})

	// $('#tabs').tabs('add',{
	// 	title:'欢迎登录',
	// 	content:createFrame('index.php?r=back/main/welcome');
	// });
});

</script>

<noscript>
	<div style=" position:absolute; z-index:100000; height:2046px;top:0px;left:0px; width:100%; background:white; text-align:center;">
		<img src="images/noscript.gif" alt='抱歉，请开启脚本支持！' />
	</div>
</noscript>
<div region="north" split="true" border="false" style="overflow: hidden; height: 50px; #7f99be repeat-x center 50%;line-height: 20px;font-family: Verdana, 微软雅黑,黑体">
	<span style="float:right; padding-right:20px;margin-top:10px;" class="head">
		<a href="#" id="editpass" style="margin-right:10px;">欢迎登陆系统，<font color="red"><?php echo $_SESSION[Perfect]['userName']; ?></font></a>
		<a href="#" id="loginOut">安全退出</a>
	</span>
	<span style="padding-left:10px; font-size: 16px; ">
		<!-- <img src="images/blocks.gif" width="20" height="20" align="absmiddle" /> -->
	</span>
</div>
<div region="south" split="true" style="height: 30px; background: #D2E0F2; ">
	<div class="footer">The Black Rose shall bloom once more.</div>
</div>
<div region="west" split="true" title="导航菜单" style="width:180px;" id="west">
	<div class="easyui-accordion" fit="true" border="false">
		<!--  导航内容 -->
	</div>
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
