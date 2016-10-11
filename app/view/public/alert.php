<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Perfect framework</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseSrc; ?>web/css/default.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseSrc; ?>web/js/themes/pepper-grinder/easyui.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseSrc; ?>web/js/themes/icon.css" />
	<script type="text/javascript" src="<?php echo $this->baseSrc; ?>web/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseSrc; ?>web/js/jquery.easyui.min.js"></script>
</head>
<body>
<script>
var url = "<?php echo $goto ?>";
var msg = "<?php echo $msg; ?>";
$(document).ready(function(){
	if (url) {
		$.messager.alert('提示',msg,'warning',function(){ window.location.href=url;});
	}else{
		$.messager.alert('警告',msg,'warning',function(){ window.history.back();});
	}
});
</script>
</body>
</html>