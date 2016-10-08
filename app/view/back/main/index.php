<script type="text/javascript">
var _menus = {
	"menus": [{
		"menuid": "1",
		"icon": "icon-sys",
		"menuname": "系统管理",
		"menus": [{
			"menuname": "菜单管理",
			"icon": "icon-nav",
			"url": "index.php"
		}, {
			"menuname": "添加用户",
			"icon": "icon-add",
			"url": "index.php?r=back/main/test"
		}, {
			"menuname": "用户管理",
			"icon": "icon-users",
			"url": "demo2.html"
		}, {
			"menuname": "角色管理",
			"icon": "icon-role",
			"url": "demo2.html"
		}, {
			"menuname": "权限设置",
			"icon": "icon-set",
			"url": "demo.html"
		}, {
			"menuname": "系统日志",
			"icon": "icon-log",
			"url": "demo.html"
		}]
	}, {
		"menuid": "8",
		"icon": "icon-sys",
		"menuname": "员工管理",
		"menus": [{
			"menuname": "员工列表",
			"icon": "icon-nav",
			"url": "demo.html"
		}, {
			"menuname": "视频监控",
			"icon": "icon-nav",
			"url": "demo1.html"
		}]
	}, {
		"menuid": "56",
		"icon": "icon-sys",
		"menuname": "部门管理",
		"menus": [{
			"menuname": "添加部门",
			"icon": "icon-nav",
			"url": "demo1.html"
		}, {
			"menuname": "部门列表",
			"icon": "icon-nav",
			"url": "demo2.html"
		}]
	}, {
		"menuid": "28",
		"icon": "icon-sys",
		"menuname": "财务管理",
		"menus": [{
			"menuname": "收支分类",
			"icon": "icon-nav",
			"url": "demo.html"
		}, {
			"menuname": "报表统计",
			"icon": "icon-nav",
			"url": "demo1.html"
		}, {
			"menuname": "添加支出",
			"icon": "icon-nav",
			"url": "demo.html"
		}]
	}, {
		"menuid": "39",
		"icon": "icon-sys",
		"menuname": "商城管理",
		"menus": [{
			"menuname": "商品分类",
			"icon": "icon-nav",
			"url": "/shop/productcatagory.aspx"
		}, {
			"menuname": "商品列表",
			"icon": "icon-nav",
			"url": "/shop/product.aspx"
		}, {
			"menuname": "商品订单",
			"icon": "icon-nav",
			"url": "/shop/orders.aspx"
		}]
	}]
};

//修改密码
function serverLogin() {
	var $newpass = $('#txtNewPass');
	var $rePass = $('#txtRePass');

	if ($newpass.val() == '') {
		msgShow('系统提示', '请输入密码！', 'warning');
		return false;
	}
	if ($rePass.val() == '') {
		msgShow('系统提示', '请在一次输入密码！', 'warning');
		return false;
	}

	if ($newpass.val() != $rePass.val()) {
		msgShow('系统提示', '两次密码不一至！请重新输入', 'warning');
		return false;
	}

	$.post('/ajax/editpassword.ashx?newpass=' + $newpass.val(), function(msg) {
		msgShow('系统提示', '恭喜，密码修改成功！<br>您的新密码为：' + msg, 'info');
		$newpass.val('');
		$rePass.val('');
		close();
	})

}

$(function() {
	$('#loginOut').click(function() {
		$.messager.confirm('系统提示', '您确定要退出本次登录吗?', function(r) {

			if (r) {
				location.href = 'index.php?r=back/index/logout';
			}
		});

	})
});

$(function() {
	$('#messa').click(function() {
		$.messager.alert('提示','$msg','warning',function(){
			window.history.back();
		});
	})
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
		<div title="欢迎使用" style="padding:20px;overflow:hidden;" id="home">
			<h1 id="messa">Welcome To My world</h1>
		</div>
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
