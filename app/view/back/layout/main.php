<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Perfect framework</title>
	<link href="favicon.ico" rel="shortcut icon" />
	<link rel="stylesheet" href="<?php echo $this->baseSrc; ?>/web/css/style.css">
	<link rel="stylesheet" href="<?php echo $this->baseSrc; ?>/web/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->baseSrc; ?>/web/css/bootstrap-theme.min.css">
	<script src="<?php echo $this->baseSrc; ?>/web/js/jquery.min.js"></script>
	<script src="<?php echo $this->baseSrc; ?>/web/js/bootstrap.min.js"></script>
	<script src="<?php echo $this->baseSrc; ?>/web/js/public.js"></script>
</head>
<body>
	<?php  include($viewFile);?>
</body>
</html>