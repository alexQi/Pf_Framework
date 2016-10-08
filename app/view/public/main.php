<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<?php if ($time!=''): ?>
	<meta http-equiv='Refresh' content='<?php echo $time; ?>; URL=<?php echo $url; ?>' >
	<?php endif ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $tittle; ?></title>
	<link href="/images/favicon.ico" rel="shortcut icon" />
	<link rel="stylesheet" href="<?php echo $this->baseSrc; ?>/web/css/reset.css">
	<link rel="stylesheet" href="<?php echo $this->baseSrc; ?>/web/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->baseSrc; ?>/web/css/bootstrap-theme.min.css">
	<script src="<?php echo $this->baseSrc; ?>/web/js/jquery.min.js"></script>
	<script src="<?php echo $this->baseSrc; ?>/web/js/bootstrap.min.js"></script>
</head>
<body class="public-body">
	<?php  include($viewFile);?>
</body>
</html>