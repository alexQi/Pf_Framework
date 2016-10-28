<script type="text/javascript">
<!--
$(document).ready(function(){
	$(document).keydown(function(e){
		if(e.keyCode==13){
			document.location.href = 'index.php?r=back/advert/index&sickType='+$('#sickType').val()+'&searchTag='+$('#searchTag').val()+'&searchTagById='+$('#searchTagById').val()+'&search_point='+$('#search_point').val()+'&market='+$('#market').val();
		}
	});
	$("#createButton").click(function(){
		document.location.href = 'index.php?controller=advert&action=advertDeal&dType=createAdvert';
	});
	$("#searchButton").click(function(){
		document.location.href = 'index.php?r=back/advert/index&sickType='+$('#sickType').val()+'&searchTag='+$('#searchTag').val()+'&searchTagById='+$('#searchTagById').val()+'&search_point='+$('#search_point').val()+'&market='+$('#market').val();
	});
	$("#sickType").change(function(){
		document.location.href = 'index.php?r=back/advert/index&sickType='+$('#sickType').val()+'&searchTag='+$('#searchTag').val()+'&searchTagById='+$('#searchTagById').val()+'&search_point='+$('#search_point').val()+'&market='+$('#market').val();
	});
	$("#search_point").change(function(){
		document.location.href = 'index.php?r=back/advert/index&sickType='+$('#sickType').val()+'&searchTag='+$('#searchTag').val()+'&searchTagById='+$('#searchTagById').val()+'&search_point='+$('#search_point').val()+'&market='+$('#market').val();
	});
});

function advertModify(id){
	document.location.href = 'index.php?controller=advert&action=advertDeal&dType=advertModify&ad_id='+id;
}

function advertDirect(id){
	window.open('index.php?controller=advert&action=advertDeal&dType=advertDirect&ad_id='+id);
	// document.location.href = 'index.php?controller=advert&action=advertDeal&dType=advertDirect&ad_id='+id;
}

function passAdvert (advId) {
	var advId = parseInt(advId);
	if(advId=='') return false;
	var submitForm = document.createElement("form");
	submitForm.setAttribute('action','index.php?controller=advert&action=advertDeal&dType=passAdvert');
	submitForm.setAttribute('method','post');
	var advIdBox = document.createElement('input');
	advIdBox.setAttribute('name','ad_id');
	advIdBox.setAttribute('type','hidden');
	advIdBox.setAttribute('value',advId);
	submitForm.appendChild(advIdBox);
	$.messager.confirm('提示','您确定要审核该广告么？',function(r){ 
		if (r){
			document.body.appendChild(submitForm);
			submitForm.submit();
		}else{
			return false;
		}
	});
}

function revocationAdvert (advId) {
	var advId = parseInt(advId);
	if(advId=='') return false;
	var submitForm = document.createElement("form");
	submitForm.setAttribute('action','index.php?controller=advert&action=advertDeal&dType=revocationAdvert');
	submitForm.setAttribute('method','post');
	var advIdBox = document.createElement('input');
	advIdBox.setAttribute('name','ad_id');
	advIdBox.setAttribute('type','hidden');
	advIdBox.setAttribute('value',advId);
	submitForm.appendChild(advIdBox);
	$.messager.confirm('提示','您确定要撤销该广告么？',function(r){   
		if (r){
			document.body.appendChild(submitForm);
			submitForm.submit();
		}else{
			return false;
		}
	});
}

function refuseAdvert (advId) {
	var advId = parseInt(advId);
	if(advId=='') return false;
	var submitForm = document.createElement("form");
	submitForm.setAttribute('action','index.php?controller=advert&action=advertDeal&dType=refuseAdvert');
	submitForm.setAttribute('method','post');
	var advIdBox = document.createElement('input');
	advIdBox.setAttribute('name','ad_id');
	advIdBox.setAttribute('type','hidden');
	advIdBox.setAttribute('value',advId);
	submitForm.appendChild(advIdBox);
	$.messager.confirm('提示','您确定要拒绝该广告么？',function(r){   
		if (r){
			document.body.appendChild(submitForm);
			submitForm.submit();
		}else{
			return false;
		}
	});
}

function pauseAdvert (advId) {
	var advId = parseInt(advId);
	if(advId=='') return false;
	var submitForm = document.createElement("form");
	submitForm.setAttribute('action','index.php?controller=advert&action=advertDeal&dType=pauseAdvert');
	submitForm.setAttribute('method','post');
	var advIdBox = document.createElement('input');
	advIdBox.setAttribute('name','ad_id');
	advIdBox.setAttribute('type','hidden');
	advIdBox.setAttribute('value',advId);
	submitForm.appendChild(advIdBox);
	$.messager.confirm('提示','您确定要暂停该广告么？',function(r){   
		if (r){
			document.body.appendChild(submitForm);
			submitForm.submit();
		}else{
			return false;
		}
	});
}

function advertArrived(advId) {
	var advId = parseInt(advId);
	if(advId=='') return false;
	var submitForm = document.createElement("form");
	submitForm.setAttribute('action','index.php?controller=advert&action=advertDeal&dType=advertArrived');
	submitForm.setAttribute('method','post');
	var advIdBox = document.createElement('input');
	advIdBox.setAttribute('name','ad_id');
	advIdBox.setAttribute('type','hidden');
	advIdBox.setAttribute('value',advId);
	submitForm.appendChild(advIdBox);
	$.messager.confirm('提示','是否添加到达统计？',function(r){
		if (r){
			document.body.appendChild(submitForm);
			submitForm.submit();
		}else{
			return false;
		}
	});
}
function hourModify(id){
	var hours = $('#hour_'+id).val();
	$.post(
		'index.php?controller=advert&action=advertDeal&dType=hourModify',
		{ad_id:id,hours:hours},
		function(data){
			document.write(data);
		}
	);
}

function modifyTotal(id){
	var least = $('#least_'+id).val();
	$.post(
		'index.php?controller=advert&action=advertDeal&dType=modifyTotal',
		{ad_id:id,least:least},
		function(data){
			var obj = eval("("+data+")");
			if (obj.result) {
				$.messager.alert('提示',obj.message);
				$('#least_'+id).val(obj.num);
			}else{
				$.messager.alert('提示',obj.message);
				window.location.reload();
			}
		}
	);
}

function modifyTodayTotal(id){
	var now_amount = $('#TodayTotal_'+id).val();
	$.post(
		'index.php?controller=advert&action=advertDeal&dType=modifyTodayTotal',
		{ad_id:id,now_amount:now_amount},
		function(data){
			var obj = eval("("+data+")");
			if (obj.result) {
				$.messager.alert('提示','修改成功');
			}else{
				$.messager.alert('提示','修改失败');
				window.location.reload();
			}
		}
	);
}
function setFocusColor(obj){
    var trBox=document.getElementById('dataTable').getElementsByTagName("tr");
    for(var i=0;i<trBox.length;i++){
        trBox[i].style.backgroundColor='';
    }
    obj.style.backgroundColor='#ccc';
}

</script>
<div id="mainTB">
	<div class="pageTitle">广告管理</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable">
		<tr>
			<td colspan="3" style="padding-left:10px;border-right:none;height:40px">
				<span title="请输入广告ID">
					ID:
					<input type="text" id="searchTagById" name="searchTagById" class="easyui-textbox" value="<?php echo $searchTagById ?>" style="width:50px" class="searchBox" />
				</span>
				<span title="请输入项目名称进行快速查询">
					关键字：<input type="text" id="searchTag" name="searchTag" class="easyui-textbox" value="<?php echo $searchTag ?>" style="width:170px" class="searchBox" />
				</span>
				<span title="项目负责人">
					<select id="market" name="market" style="vertical-align:middle;height:24px;-webkit-border-radius: 5px 5px 5px 5px;border-radius: 5px 5px 5px 5px;">
					<option value="">全部项目</option>
					<?php foreach ($markets as $market): ?>
					<option value="<?php echo $market['admin_id']; ?>" <?php echo $market['admin_id']==$market_id ?'selected':''; ?>><?php echo $market['true_name']; ?></option>
					<?php endforeach; ?>
					</select>
				</span>
				<span style="margin-left:10px"><a id="searchButton" class="easyui-linkbutton" icon="icon-search" href="javascript:void(0)">搜索</a></span>
				<span style="margin-left:10px"><a id="createButton" class="easyui-linkbutton" icon="icon-edit" href="javascript:void(0)">创建</a></span>
			</td>
			<td colspan="2" style="border-right:none;height:40px;text-align:left;padding-right:10px">
				<span>广告状态：</span>
				<span>
					<select id="sickType" name="sickType" style="vertical-align:middle;height:24px;-webkit-border-radius: 5px 5px 5px 5px;border-radius: 5px 5px 5px 5px;">
					<option value="-1">全部广告</option>
					<?php foreach ($advertStatus as $key => $status): ?>
					<option value="<?php echo $key; ?>" <?php echo $key==$sickType?'selected':''; ?>><?php echo $status; ?></option>
					<?php endforeach ?>
					</select>
				</span>
			</td>
			<td style="border-right:none;height:40px;text-align:left;padding-right:10px">
				<span>广告类型：</span>
				<span>
					<select id="search_point" name="search_point" style="vertical-align:middle;height:24px;-webkit-border-radius: 5px 5px 5px 5px;border-radius: 5px 5px 5px 5px;">
					<option value="">所有类型</option>
					<?php foreach ($advertPoint as $k=>$point): ?>
					<option value="<?php echo $k; ?>" <?php echo $k==$search_point?'selected':''; ?>><?php echo $point; ?></option>
					<?php endforeach ?>
					</select>
				</span>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable" id="dataTable">
	<tr>
		<th colspan="6" style="width: 50%;"><span class="tableHeadTitle">项目信息</span></th>
		<th colspan="4" style="width: 26%;"><span class="tableHeadTitle">素材信息</span></th>
		<th><span class="tableHeadTitle">状态</span></th>
		<th><span class="tableHeadTitle">操作</span></th>
	</tr>
	<?php foreach ($advertList as $key => $advertInfo): ?>
	<tr onmouseover="setFocusColor(this)">
		<td style="text-align:center" colspan="6">
			<table  cellpadding="0" cellspacing="0"  style="margin-top:0;margin-bottom:5px;width:100%;height:100%;border:0;" class="mainTable">
				<tr>
					<td style="border:none;text-align:right;padding-right:5px;">【ID】<font color="red"><?php echo $advertInfo['advert_id']; ?></font></td>
					<td colspan="5" style="border:none;padding-left:5px;">
						<a href="index.php?controller=advertData&action=advertDataDeal&dType=advertSiteList&id=<?php echo $advertInfo['advert_id']; ?>" target="_blank">
							<?php echo $advertInfo['advert_name']; ?>
						</a>
					</td>
				</tr>
				<tr>
					<td style="border:none;text-align:right;width:80px;">转投ID：</td>
					<td style="border:none;padding-left:5px;width:80px;">
						<?php if ($advertInfo['shift_id']!=0): ?>
							<font color="red">[<?php echo $advertInfo['shift_id']; ?>]</font>
						<?php else: ?>
							none
						<?php endif; ?>
					</td>
					<td style="border:none;text-align:right;width:50px;">单价：</td>
					<td style="border:none;padding-left:5px;width:60px;"><?php echo $advertInfo['advert_price']; ?></td>
					<td style="border:none;text-align:right;width:70px;">今日投量：</td>
					<td style="border:none;padding-left:5px;"><?php echo $advertInfo['intraday_amount']; ?></td>
				</tr>
				<tr>
					<td style="border:none;text-align:right;width:80px;">广告主账号：</td>
					<td style="border:none;padding-left:5px;width:80px;"><?php echo $advertInfo['user_name']; ?></td>
					<td style="border:none;text-align:right">归属：</td>
					<td style="border:none;padding-left:5px;"><?php echo $advertInfo['true_name']; ?></td>
					<td style="border:none;text-align:right">今日剩余：</td>
					<td style="border:none;padding-left:5px;"><?php echo $advertInfo['advert_id']; ?></td>
				</tr>
				<tr>
					<td style="border:none;text-align:right;width:80px;">平台：</td>
					<td style="border:none;padding-left:5px;width:80px;"><?php echo $advertInfo['platform']; ?></td>
					<td style="border:none;text-align:right">类型：</td>
					<td style="border:none;padding-left:5px;"><?php echo $advertPoint[$advertInfo['charge_point']]; ?></td>
					<td style="border:none;text-align:right">项目剩余：</td>
					<td style="border:none;padding-left:5px;"><?php echo $advertInfo['advert_id']; ?></td>
				</tr>
				<tr>
					<td style="border:none;text-align:right;width:80px;">时间定向：</td>
					<td colspan="5" style="border:none;padding-left:5px;">
						<input type="text" id="hour_<?php echo $advertInfo['advert_id']; ?>" style="width:95%;" onchange="hourModify(<?php echo $advertInfo['advert_id']; ?>)" value="<?php echo $advertInfo['hours']; ?>" />
					</td>
				</tr>
			</table>
		</td>
		<td style="text-align:center" colspan="4">
			<table  cellpadding="0" cellspacing="0"  style="margin:0;width:100%;height:100%;border:0;" class="mainTable">
				<tr>
					<td style="padding-left:10px;">
						广告地址：<a href="<?php echo $advertInfo['direct_url']; ?>"><?php echo substr($advertInfo['direct_url'],8); ?></a>
					</td>
				</tr>
				<tr>
					<td style="padding-left:7px;" rowspan="2">
						<img src="<?php echo $advertInfo['image_url']; ?>" style="margin-top:0;width:300px;height:70px;">
					</td>
				</tr>
			</table>
		</td>
		<td style="text-align:center;padding:0;">
			<font color="<?php if ($advertInfo['status']==1){ ?>#9E4F0F<?php }elseif($advertInfo['status']==2){ ?>#000<?php }elseif($advertInfo['status']==3){ ?>#0F449E<?php }else{ ?>#9E2E0F<?php }?>">
				<?php if ($advertInfo['status']==1){ ?>待审核<?php }elseif($advertInfo['status']==2){ ?>正常<?php }elseif($advertInfo['status']==3){ ?>暂停<?php }else{ ?>拒绝<?php }?>
			</font>
		</td>
		<td style="text-align:center;border-right:0;padding:0;">
			<table  cellpadding="0" cellspacing="0"  style="margin-top:0;margin-bottom:5px;width:100%;height:100%;border:0;" class="mainTable">
				
				<tr border="0">
					<?php if ($advertInfo['status']): ?>
					<td style="text-align:center;border:0;"><a class="easyui-linkbutton" href="javascript:passAdvert('{%$advertList[id].ad_id%}');">审核</a></td>
					<?php else: ?>
					<td style="text-align:center;border:0;"><a class="easyui-linkbutton" href="javascript:pauseAdvert('{%$advertList[id].ad_id%}');">暂停</a></td>
					<?php endif ?>
					<td style="text-align:center;border:0;"><a class="easyui-linkbutton" href="javascript:refuseAdvert('{%$advertList[id].ad_id%}');">拒绝</a></td>
					<td style="text-align:center;border:0;"><a class="easyui-linkbutton" href="javascript:refuseAdvert('{%$advertList[id].ad_id%}');">素材</a></td>
				</tr>
				<tr border="0">
					<td style="text-align:center;border:0;"><a class="easyui-linkbutton" onclick="advertModify('{%$advertList[id].ad_id%}')">修改</a></td>
					<td style="text-align:center;border:0;"><a class="easyui-linkbutton" onclick="advertDirect('{%$advertList[id].ad_id%}')">定向</a></td>
					<td style="text-align:center;border:0;">
						<a class="easyui-linkbutton" href="javascript:advertArrived('{%$advertList[id].ad_id%}');">
							<font color="{%if $advertList[id].isarrive==2%}red{%/if%}">
								到达
							</font>
						</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	<?php echo $page; ?>
</div>