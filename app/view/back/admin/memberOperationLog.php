<script type="text/javascript">
$(document).ready(function(){
	$(document).keydown(function(e){
		if(e.keyCode==13){
			document.location.href = 'index.php?r=back/admin/operationLogList&searchTag='+$('#searchTag').val()+'&module='+$('#module').val()+'&table='+$('#table').val()+'&type='+$('#type').val();
		}
	});

	$("#searchButton").click(function(){
		document.location.href = 'index.php?r=back/admin/operationLogList&searchTag='+$('#searchTag').val()+'&module='+$('#module').val()+'&table='+$('#table').val()+'&type='+$('#type').val();
	});
	var module = $('#module option:selected').val();
	$.post(
		'index.php?r=back/admin/getLogTableNoAuth',
		{module:module},
		function(data){
			$('#table').html(data);
			$("#table option[value='<?php echo $table; ?>']").attr("selected",true);
		}
	);
	var table = '<?php echo $table; ?>';
	$.post(
		'index.php?r=back/admin/getLogTypeNoAuth',
		{table:table},
		function(data){
			$('#type').html(data);
			$("#type option[value='<?php echo $type; ?>']").attr("selected",true);
		}
	);

	$('#module').change(function(){
		var module = $('#module option:selected').val();
		$.post(
			'index.php?r=back/admin/getLogTableNoAuth',
			{module:module},
			function(data){
				$('#table').html(data);
			}
		);
	});
	$('#table').change(function(){
		var table = $('#table option:selected').val();
		$.post(
			'index.php?r=back/admin/getLogTypeNoAuth',
			{table:table},
			function(data){
				$('#type').html(data);
			}
		);
	});
});
</script>
</head>
<div id="mainTB">
	<div class="pageTitle">操作日志</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable">
		<tr>
			<td colspan="3" style="vertical-align:middle;border-right:none;height:40px">
				<span title="请输入项目名称进行快速查询">
					关键字：<input type="text" class="easyui-textbox" id="searchTag" name="searchTag" value="<?php echo $searchTag; ?>" style="width:170px;height:24px;" class="searchBox" />
				</span>
				<span title="请选择模块" style="margin-left:20px">
					<select name="module" id="module" style="height:24px;-webkit-border-radius: 5px 5px 5px 5px;border-radius: 5px 5px 5px 5px;">
						<option value="">全部模块</option>
						<?php foreach ($modules as $v): ?>
						<option value="<?php echo $v['module']; ?>" <?php echo $module==$v['module'] ? 'selected':''; ?>><?php echo $v['module']; ?></option>
						<?php endforeach ?>
					</select>
				</span>
				<span title="请选择模块" style="margin-left:20px">
					<select name="table" id="table" style="height:24px;-webkit-border-radius: 5px 5px 5px 5px;border-radius: 5px 5px 5px 5px;">
					</select>
				</span>
				<span title="请选择模块" style="margin-left:20px">
					<select name="type" id="type" style="height:24px;-webkit-border-radius: 5px 5px 5px 5px;border-radius: 5px 5px 5px 5px;">
					</select>
				</span>
				<span style="margin-left:10px"><a id="searchButton" style="vertical-align:middle;" class="easyui-linkbutton" icon="icon-search" href="javascript:void(0)">搜索</a></span>
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
	<?php foreach ($logList as $log): ?>
	<tr style="margin-top:5px;">
		<td style="text-align:center"><?php echo $log['id']; ?></td>
		<td style="text-align:left;padding-left:20px"><?php echo $log['module']; ?></td>
		<td style="text-align:left;padding-left:20px"><?php echo $log['table']; ?></td>
		<td style="text-align:left;padding-left:20px"><?php echo $log['type']; ?></td>
		<td style="text-align:left;padding-left:40px;"><?php echo $log['content']; ?></td>
		<td style="text-align:center"><?php echo $log['true_name']; ?></td>
		<td style="text-align:center"><?php echo $log['update_time']; ?></td>

	</tr>
	<?php endforeach ?>
	</table>
	<?php echo $page; ?>
</div>