<script type="text/javascript">
$(document).ready(function(){
	$(document).keydown(function(e){
		if(e.keyCode==13){
			document.location.href='index.php?r=back/admin/index&searchTag='+$.trim($('#searchTag').val());
		}
	});
	$("#searchButton").click(function(){
		window.location.href='index.php?r=back/admin/index&searchTag='+$.trim($('#searchTag').val());
	});
	$("#createManagerButton").click(function(){
		window.location.href='index.php?r=back/admin/adminDeal&dType=createMember';
	});
});

function modifyAccount(accountId) {
	window.location.href='index.php?r=back/admin/adminDeal&dType=memberModify&accountId='+accountId;
}


function lockAccount(accountId) {
	$.messager.confirm('提示','确定要锁定该帐号么？',function(r){   
		if (r){
			window.location.href='index.php?r=back/admin/adminDeal&dType=lockMember&accountId='+accountId;
		}else{
			return false;
		}
	});
}

function unLockAccount(accountId) {
	$.messager.confirm('提示','确定要解除该帐号的锁定么？',function(r){   
		if (r){
			window.location.href='index.php?r=back/admin/adminDeal&dType=unlockMember&accountId='+accountId;  
		}else{
			return false;
		}
	});
}
function sickManagerSystemLog(userName,token){
	window.location.href="index.php?r=back/admin/adminDeal&dType=memberLog&userAccount="+userName+"&token="+token;
}
</script>
<div id="mainTB">
	<div class="pageTitle">帐号管理</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable">
	<tr>
		<td colspan="10" style="padding-left:10px;border-right:none;height:40px">
			<span>关键字：<input type="text" id="searchTag" name="searchTag" value="<?php echo $searchTag; ?>" style="width:180px;height:24px;" class="searchBox" /></span>
			<span style="margin-left:10px"><a id="searchButton" class="easyui-linkbutton" icon="icon-search" href="javascript:void(0)">搜索</a></span>
			<span style="margin-left:10px"><a id="createManagerButton" class="easyui-linkbutton" icon="icon-add" href="javascript:void(0)">创建</a></span>
		</td>
	</tr>
	<tr>
		<th><span class="tableHeadTitle">ID</span></th>
		<th><span class="tableHeadTitle">姓名</span></th>
		<th><span class="tableHeadTitle">帐号</span></th>
		<th><span class="tableHeadTitle">日志</span></th>
		<th><span class="tableHeadTitle">紧急联系电话</span></th>
		<th style="text-align:left;padding-left:20px;width:160px"><span class="tableHeadTitle">用户标识</span></th>
		<th><span class="tableHeadTitle">最后登录时间</span></th>
		<th><span class="tableHeadTitle">登陆次数</span></th>
		<th><span class="tableHeadTitle">状态</span></th>
		<th style="border-right:0"><span class="tableHeadTitle">操作</span></th>
	</tr>
	<?php foreach($list as $info): ?>
	<tr height="35px">
		<td class="firstRow" style="text-align:center"><?php echo $info['admin_id']; ?></td>
		<td class="firstRow" style="text-align:center"><?php echo $info['true_name']; ?></td>
		<td class="firstRow" style="text-align:center;height:28px;line-height:28px;padding-left:10px"><?php echo $info['user_account']; ?></td>
		<td class="firstRow" style="text-align:center">
			<span><a class="easyui-linkbutton" icon="icon-tip" href="javascript:sickManagerSystemLog('<?php echo $info['user_account']; ?>','<?php echo rand(1000,100000); ?>')">查看</a></span></span>
		</td>
		<td class="firstRow" style="text-align:center"><?php echo $info['mobile']; ?></td>
		<td class="firstRow" style="text-align:left;padding-left:20px;">
			<?php echo $info['user_role_tag'].'-->'.$info['role_type_tag']; ?>
		</td>
		<td class="firstRow" style="text-align:center"><?php echo $info['last_time']; ?></td>
		<td class="firstRow" style="text-align:center;color:#FF0000;width:80px"><?php echo $info['login_count']; ?></td>
		<td class="firstRow" style="text-align:center;width:72px;font-weight:bold;color:<?php echo $info['is_closed']==0 ? '#31853A':'#FF0000'; ?>"><?php echo $info['is_closed_tag']; ?></td>
		<td class="firstRow" style="text-align:center;width:180px">
		<?php if ($userRole==-1 || ($userRole==0 && $roleType==0)): ?>
			<?php if ($userId==$info['admin_id']): ?>
				<span><font style="color:#EFEFEF">管理帐号</font></span>
			<?php else: ?>
				<?php if($info['is_closed']==0): ?>
				<span><a class="easyui-linkbutton" icon="icon-save" href="javascript:lockAccount('<?php echo $info['admin_id']; ?>');">锁定</a></span>
				<?php else: ?>
				<span><a class="easyui-linkbutton" icon="icon-save" href="javascript:unLockAccount('<?php echo $info['admin_id']; ?>');">解锁</a></span>
				<?php endif; ?>
				<span style="margin-left: 10px;"><a class="easyui-linkbutton" icon="icon-edit" href="javascript:modifyAccount('<?php echo $info['admin_id']; ?>');">编辑</a></span>
			<?php endif; ?>
		<?php else: ?>
			<?php if ($info['user_role']!=-1 && $info['user_role']!=0): ?>
				<?php if($info['is_closed']==0): ?>
				<span><a class="easyui-linkbutton" icon="icon-save" href="javascript:lockAccount('<?php echo $info['admin_id']; ?>');">锁定</a></span>
				<?php else: ?>
				<span><a class="easyui-linkbutton" icon="icon-save" href="javascript:unLockAccount('<?php echo $info['admin_id']; ?>');">解锁</a></span>
				<?php endif; ?>
				<span style="margin-left: 10px;"><a class="easyui-linkbutton" icon="icon-edit" href="javascript:modifyAccount('<?php echo $info['admin_id']; ?>');">编辑</a></span>
			<?php else: ?>
				<span><font style="color:#EFEFEF">管理帐号</font></span>
			<?php endif; ?>
		<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	<?php echo $page; ?>
</div>