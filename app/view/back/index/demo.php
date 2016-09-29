<div class="table-responsive">
	<table class="table table-striped table-hover">
		<caption>Optional table caption.</caption>
		<thead>
			<tr>
				<th>#</th>
				<th>管理员ID</th>
				<th>IP地址</th>
				<th>地址</th>
				<th>操作时间</th>
				<th>日期</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $key => $row): ?>
			<tr>
				<th><?php echo $row['id']; ?></th>
				<td><?php echo $row['admin_id']; ?></td>
				<td><?php echo $row['ip']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<td><?php echo $row['time']; ?></td>
				<td><?php echo $row['date']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php echo $page; ?>
</div>