<script type="text/javascript">
$(document).ready(function(){
	var userTouch = "<?php echo $accountInfo['user_touch']; ?>";
	userTouchArr = userTouch.split('|');
	for(var i=0;i<userTouchArr.length;i++){
		var temp = userTouchArr[i].split('-');
		$('#viewPermissions_'+temp[0]).attr("checked",true);
		var checkDetal = temp[1].split(',');
		if(temp[1].length>1){
			for(var q=0;q<checkDetal.length;q++){
				if(checkDetal[q]!='0'){
					var fatherBox = document.getElementsByName('operatingAuthority['+temp[0]+'][]');
					for(var b=0;b<fatherBox.length;b++){
						if(fatherBox[b].value==checkDetal[q]){
							fatherBox[b].checked=true;
						}
					}
				}
			}
		}
	}
	$('#saveButton').click(function() {
		var fields =String,fieldObj=Object,fatherForm=document.getElementById('modifySystemManagerForm'),checkPermissions=0;
		var verifyFiled = ['passWord','trueName','qqAccount','privatePhone','officePhone','userRole','roleType'];
		for(var i = 0; i <verifyFiled.length;i++){
			fields = verifyFiled[i];
			fieldObj = document.getElementById(fields);
			if(fields=='passWord'){
				if(!isNull(fieldObj.value) && !minLength(fieldObj.value,8)){
					$.messager.alert('错误','密码不能少于8位！','error');
					return false;
				}
			}else if(fields=='trueName'){
				if(isNull(fieldObj.value) || !minLength(fieldObj.value,2) || !isChinese(fieldObj.value)){
					$.messager.alert('错误','请填写真实姓名！','error');
					return false;
				}
			}else if(fields=='qqAccount'){
				if(isNull(fieldObj.value) || !isInteger(fieldObj.value) || !minLength(fieldObj.value,5)){
					$.messager.alert('错误','请输入正确的QQ号码！','error');
					return false;
				}
			}else if(fields=='privatePhone'){
				if(isNull(fieldObj.value)){
					$.messager.alert('错误','请输入联系电话！','error');
					return false;
				}
			}else if(fields=='userRole'){
				if(isNull(fieldObj.value)){
					$.messager.alert('错误','必须选择帐号所属管理组！','error');
					return false;
				}
				if(fieldObj.value=='1' || fieldObj.value=='2'){
					var customerLimit = document.getElementById('customerLimit');
					if(customerLimit.value.trim()=='0' || !isInteger(customerLimit.value.trim()) || customerLimit.value.trim()<0){
						$.messager.alert('错误','市场和媒介人员必须设置客户上限!','error');
						return false;
					}
					var nickName = document.getElementById('nickName');
					if(isNull(nickName.value.trim())) {
						$.messager.alert('错误','请填写媒介或市场人员马夹！','error');
						return false;
					}
				}
			}else if(fields=='roleType'){
				if(isNull(fieldObj.value)){
					$.messager.alert('错误','必须设定帐号角色！','error');
					return false;
				}
			}
		}
		purviewFieldBox = fatherForm.getElementsByTagName('input');
		for(var i=0;i<purviewFieldBox.length;i++){
			fieldName=purviewFieldBox[i].getAttribute('name');
			fieldType=purviewFieldBox[i].getAttribute('type');
			if(fieldName!==null && fieldType=='checkbox'){
				if(purviewFieldBox[i].checked==true) checkPermissions++;
			}
		}

		if(checkPermissions==0){
			$.messager.confirm('提示','确定给予该帐号所有管理权限么？',function(r){   
				if (!r){
					return false;
				}
			});
		}
		fatherForm.submit();
	});
});


function relevanceViewPermissions(itemId,eventsBox,selectAllBtn){
	var obj = document.getElementById(itemId);
	var eventsBox = document.getElementsByName(eventsBox);
	var selectAllBox = document.getElementById(selectAllBtn);
	var countEvents=0;
	if(obj.checked!=true) obj.checked=true;
	for (var i = 0; i < eventsBox.length; i++){
			if(eventsBox[i].checked == true) countEvents++;
	}
	if(countEvents==0){
		$.messager.confirm('提示','您已经取消了该栏目下操作权限，需要保留查看权限么?',function(r){   
			if (r){
				document.getElementById(itemId).checked=true;
			}else{
				document.getElementById(itemId).checked=false;
			}
		});
		selectAllBox.checked=false;
	}
	if(countEvents<=eventsBox.length) selectAllBox.checked=false;
	if(countEvents==eventsBox.length) selectAllBox.checked=true;
}


function setOperatingAuthority (buttonId,boxName,sickBoxId) {
	var boxes = document.getElementsByName(boxName);
	var sclTrue = document.getElementById(buttonId);
	var sickBox = document.getElementById(sickBoxId);
	if(sclTrue.checked){
		for (var i = 0; i < boxes.length; i++){
			boxes[i].checked = true;
		}
		sickBox.checked = true;
	}else{
		for (var i = 0; i < boxes.length; i++){
			boxes[i].checked = false;
		}
		$.messager.confirm('提示','已经取消了所有操作权限,需要保留查看权限么?',function(r){   
			if (r){
				document.getElementById(sickBoxId).checked=true;
			}else{
				document.getElementById(sickBoxId).checked=false;
			}
		});
	}
}
function checkChildSelect (focusObj,childrenName) {
	if(typeof(document.getElementsByName(childrenName)) != "undefined"){
		var obj = document.getElementsByName(childrenName),childSelectCount=0;
		for(var i=0;i<obj.length;i++){
			if(obj[i].checked==true) childSelectCount++;
		}
		if(childSelectCount<obj.length && childSelectCount!=0){
			focusObj.checked=true;
		}
	}
}
</script>
</head>
<body>
<div id="mainTB">
	<div class="pageTitle">修改管理帐号</div>
	<form method="post" action="index.php?controller=system&action=systemDeal" name="modifySystemManagerForm" id="modifySystemManagerForm">
	<input type="hidden" name="accountId" id="accountId" value="<?php echo $accountInfo['admin_id']; ?>">
	<input type="hidden" name="dType" value="systemModifyManager">
	<input type="hidden" name="aType" value="systemModifyManager">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable">
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px">帐号：</td>
		<td style="text-align:left;text-indent:5px"><?php echo $accountInfo['user_account']; ?></td>
	</tr>
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px">密码：</td>
		<td style="text-align:left;text-indent:5px"><input type="text" name="passWord" id="passWord" style="width:145px;height:18px;line-height:18px;border:1px solid #000000"></td>
	</tr>
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px">真实姓名：</td>
		<td style="text-align:left;text-indent:5px"><input type="text" name="trueName" id="trueName" style="width:145px;height:18px;line-height:18px;border:1px solid #000000" value="<?php echo $accountInfo['true_name']; ?>"></td>
	</tr>
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px">QQ：</td>
		<td style="text-align:left;text-indent:5px"><input type="text" name="qqAccount" id="qqAccount" style="width:145px;height:18px;line-height:18px;border:1px solid #000000" value="<?php echo $accountInfo['qq']; ?>"></td>
	</tr>
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px">联系电话：</td>
		<td style="text-align:left;text-indent:5px"><input type="text" name="privatePhone" id="privatePhone" style="width:145px;height:18px;line-height:18px;border:1px solid #000000" value="<?php echo $accountInfo['mobile']; ?>"></td>
	</tr>
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px">办公电话：</td>
		<td style="text-align:left;text-indent:5px"><input type="text" name="officePhone" id="officePhone" style="width:145px;height:18px;line-height:18px;border:1px solid #000000" value="<?php echo $accountInfo['tel']; ?>"></td>
	</tr>
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px">帐号群组：</td>
		<td style="text-align:left;text-indent:5px">
		<select id="userRole" name="userRole">
			<option value=''>请选择帐号管理组</option>
			<?php foreach ($userGroup as $key => $group): ?>
			<option value="<?php echo $group['groupValue']; ?>" <?php echo $group['tag']; ?>><?php echo $group['groupName']; ?></option>	
			<?php endforeach ?>
		</select>
		</td>
	</tr>
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px">所属角色：</td>
		<td style="text-align:left;text-indent:5px">
		<select id="roleType" name="roleType">
			<?php foreach ($roleTypeSelect as $key => $roleType): ?>
			<option value="<?php echo $roleType['value']; ?>" <?php echo $roleType['tag']; ?>><?php echo $roleType['title']; ?></option>
			<?php endforeach ?>
		</select>
		</td>
	</tr>
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px">帐号昵称：</td>
		<td style="text-align:left;text-indent:5px">
		<input type="text" name="nickName" id="nickName" value="<?php echo $accountInfo['nick_name']; ?>" style="width:145px;height:18px;line-height:18px;border:1px solid #000000">
		</td>
	</tr>
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px">登录限制：</td>
		<td style="text-align:left;text-indent:5px;padding:4px">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable" style="margin:auto;border:none">
		<tr>
		<td style="border:none">
			<?php foreach ($areaLimits as $key => $area): ?>
			<ul style="float:left">
				<li style="float:left;width:25px">
					<input type="checkbox" style="vertical-align:middle;" name="areaLimits[]" <?php echo $area['tag']; ?> value="<?php echo $area['value']; ?>">
				</li>
				<li style="width:80px"><?php echo $area['title']; ?></li>
			</ul>
			<?php endforeach ?>
			<ul style="float:left"><li style="float:left;width:25px"><input type="checkbox" id="selectAreaLimits" onclick="selectAll('selectAreaLimits','areaLimits[]');"></li><li style="width:80px">全选</li></ul>
		</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr><td colspan="2" style="padding:10px">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable" style="margin:auto">
	<?php foreach ($exportMenu as $key => $row): ?>
	<tr>
		<th style="width:100px;background:#b83400;color:#FFFFFF"><?php echo $row['MENU']; ?></th>
		<th style="text-align:left;text-indent:10px;background:none"></th>
	</tr>
	<?php foreach ($row['MENUITEM'] as $k => $item): ?>
	<tr <?php if($item['DK']==01): ?> style="display:none" <?php endif; ?> >
		<td style="text-align:left;text-indent:10px;background:none;padding:4px" colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable" style="margin:auto">
		<tr>
			<th style="width:180px;background:#F1F1F1;text-align:right;padding-right:10px">[<?php echo $item['DV']; ?>]</th>
			<th style="text-align:left;text-indent:10px;background:none">
			<span><input type="checkbox" style="vertical-align:middle;" name="viewPermissions[]" id="viewPermissions_<?php echo $item['DK']; ?>" value="<?php echo $item['DK']; ?>_0" onclick="checkChildSelect(this,'operatingAuthority[<?php echo $item['DK']; ?>][]')" <?php if($item['DK']==01): ?>checked="checked"<?php endif; ?> ></span>
			<span style="margin-left:2px">查看权限</span>
			<span style="margin-left:10px;color:#F83418;font-weight:normal"></span>
			</th>
		</tr>
		<?php if(isset($item['DA']) && $item['DA']!=''): ?>
		<tr>
			<td style="width:180px;background:#F1F1F1;text-align:right;padding-right:10px;color: #FF5300;">-操作权限-</td>
			<td style="background:#FFFFFF;line-height:20px;text-indent:10px;">
				<?php foreach ($item['DA'] as $kk => $iItem): ?>
				<span>
					<input type="checkbox" style="vertical-align:middle;" name="operatingAuthority[<?php echo $item['DK']; ?>][]" value="<?php echo $iItem['DAK']; ?>" onclick="relevanceViewPermissions('viewPermissions_<?php echo $item['DK']; ?>','operatingAuthority[<?php echo $item['DK']; ?>][]','selectAll_<?php echo $item['DK']; ?>')">
					&nbsp;<?php echo $iItem['DAT']; ?>
				</span>
				<?php endforeach ?>
				<span>
					<input type="checkbox" style="vertical-align:middle;" id="selectAll_<?php echo $item['DK']; ?>" onclick="setOperatingAuthority('selectAll_<?php echo $item['DK']; ?>','operatingAuthority[<?php echo $item['DK']; ?>][]','viewPermissions_<?php echo $item['DK']; ?>');">&nbsp;&nbsp;<font style="font-weight:bold;color:#597895">全选</font>
				</span>
			</td>
		</tr>
		<?php endif; ?>
		</table>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php endforeach; ?>
	<tr>
		<td class="tableHeadTitle" style="width:140px;text-align:right;height:24px;border-right:none"></td>
		<td style="text-align:left;height:45px;line-height:45px"><a id="saveButton" class="easyui-linkbutton" icon="icon-save" href="javascript:void(0);" style="width: 80px">修改</a></td>
	</tr>
	</table>
	</td></tr>
	</table>
	</form>
</div>
</body>
</html>