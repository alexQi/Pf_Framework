<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title></title>
{%include file="../public_meta.html"%}

<script type="text/javascript">
<!--
$(document).ready(function(){
	$(document).keydown(function(e){
		if(e.keyCode==13){
			document.location.href = 'index.php?controller=system&action=operationLogList&searchTag='+$('#searchTag').val()+'&module='+$('#module').val()+'&table='+$('#table').val()+'&type='+$('#type').val();
		}
	});

	$("#searchButton").click(function(){
		document.location.href = 'index.php?controller=system&action=operationLogList&searchTag='+$('#searchTag').val()+'&module='+$('#module').val()+'&table='+$('#table').val()+'&type='+$('#type').val();
	});
	var module = $('#module option:selected').val();
	$.post(
		'index.php?controller=system&action=getLogTableNoAuth',
		{module:module},
		function(data){
			$('#table').html(data);
			$("#table option[value='{%$table%}']").attr("selected",true);
		}
	);
	var table = '{%$table%}';
	$.post(
		'index.php?controller=system&action=getLogTypeNoAuth',
		{table:table},
		function(data){
			$('#type').html(data);
			$("#type option[value='{%$type%}']").attr("selected",true);
		}
	);

	$('#module').change(function(){
		var module = $('#module option:selected').val();
		$.post(
			'index.php?controller=system&action=getLogTableNoAuth',
			{module:module},
			function(data){
				$('#table').html(data);
			}
		);
	});
	$('#table').change(function(){
		var table = $('#table option:selected').val();
		$.post(
			'index.php?controller=system&action=getLogTypeNoAuth',
			{table:table},
			function(data){
				$('#type').html(data);
			}
		);
	});
});

</script>
</head>
<body>
<div id="mainTB">
	<div class="pageTitle">操作日志</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable">
		<tr>
			<td colspan="3" style="text-indent:10px;border-right:none;height:40px">
				<span title="请输入项目名称进行快速查询">
					关键字：<input type="text" id="searchTag" name="searchTag" value="{%$searchTag%}" style="width:170px" class="searchBox" />
				</span>
				<span title="请选择模块" style="margin-left:20px">
					<select name="module" id="module">
						<option value="">全部模块</option>
						{%foreach from=$modules key=k item=v%}
						<option value="{%$v.module%}" {%if $module==$v.module%}selected{%/if%}>{%$v.module%}</option>
						{%/foreach%}
					</select>
				</span>
				<span title="请选择模块" style="margin-left:20px">
					<select name="table" id="table">
					</select>
				</span>
				<span title="请选择模块" style="margin-left:20px">
					<select name="type" id="type">
					</select>
				</span>
				<span style="margin-left:10px"><a id="searchButton" class="easyui-linkbutton" icon="icon-search" href="javascript:void(0)">搜索</a></span>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable">
	<tr>
		<th width='80px'><span class="tableHeadTitle">ID</span></th>
		<th style="text-align:left;padding-left:20px;width:100px;"><span class="tableHeadTitle">模块</span></th>
		<th style="text-align:left;padding-left:20px;width:150px;"><span class="tableHeadTitle">数据表</span></th>
		<th style="text-align:left;padding-left:20px;width:150px;"><span class="tableHeadTitle">操作</span></th>
		<th style="text-align:left;padding-left:40px"><span class="tableHeadTitle">内容</span></th>
		<th width='80px'><span class="tableHeadTitle">操作用户</span></th>
		<th width='200px'><span class="tableHeadTitle">操作日期</span></th>
	</tr>
	{%section name=id loop=$logList%}
	<tr style="margin-top:5px;">
		<td style="text-align:center">{%$logList[id].id%}</td>
		<td style="text-align:left;padding-left:20px">{%$logList[id].module%}</td>
		<td style="text-align:left;padding-left:20px">{%$logList[id].table%}</td>
		<td style="text-align:left;padding-left:20px">{%$logList[id].type%}</td>
		<td style="text-align:left;padding-left:40px;">{%$logList[id].content%}</td>
		<td style="text-align:center">{%$logList[id].true_name%}</td>
		<td style="text-align:center">{%$logList[id].update_time%}</td>

	</tr>
	{%/section%}
	</table>
	{%$pageList%}
</div>
</body>
</html>