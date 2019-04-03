<?php
var_dump($_GET);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form>
	<input type="text" name="name">
	<input type="text" name="password">
	<input type="submit">
</form>
</body>
</html>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
	$('form').submit(function(e){
		$.ajax({data:$(this).serialize();});
	});
</script>