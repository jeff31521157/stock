<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	<title>login online investing</title>
	<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen">    <!--Link to an external style sheet-->
	<link rel="stylesheet" type="text/css" href="css/style_notice.css" />
	<link rel="shortcut icon" href="/favicon.ico"/>
	<link rel="bookmark" href="/favicon.ico"/>
	<style>
	body {
		margin:0;
		padding:0;
		background: #000 url("./stock_background.png") center center fixed no-repeat;
		-moz-background-size: cover;
		background-size: cover;
	}
	</style>
</head>
<body background="trade_background.jpg">
<body>
	<div id='cssmenu'>
		<ul>
			<li class='has-sub'><a href="main_new.php">+register</a>
	    	</li>
    	</ul>
    </div>
    <center><br/><br/><br/>
	<img src="./title.png" width="900" height="150" border=0 alt="">
	</center>

<?php
ob_start();
session_start();
unset($_SESSION["login_session"]);
?>

	<form method="post" action="login_check.php">
	<br/><br/>
	<font color='white' size='4'>
	<center>
		學號：<input type="text" name="id" size="20"/>
		<br/><br/>
		密碼：<input type="password" name="password" size="20"/>
		<br/><br/>

		<input type="submit" name="login" value="登入" style="width:70px;height:25px;border:3px orange double;font-size:15px;">
	</form>

    <br/><br/><br/><br/>
    <h2><span>聯絡窗口</span></h2>
	<Big>任何系統問題請詢問此窗口:</Big>
	<Big>xxxxxxxx@gmail.com</Big>
	</center>
</body>
</html>
