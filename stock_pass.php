<?php
session_start();
$db = mysqli_connect("localhost", "root","password", "stock");
mysqli_set_charset($db,"utf8");
$user_idd = $_SESSION["user_id"];
$good=mysqli_query($db,"SELECT username FROM user WHERE id = '".$user_idd."'");
	for($i=1;$i<=mysqli_num_rows($good);$i++)
	{
		$rss=mysqli_fetch_row($good);
		$_SESSION["user_name"] = $rss[0];
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>stock trading</title>
		<link href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<div id="bg">
			<div id="outer">
				<div id="header">
					<div id="logo">
						<h1>
							<a href="stock_home.php">股票系統</a>
						</h1>
					</div>
					<div id="nav">
						<ul>
							<li class="first active">
								<a href="stock_home.php">首頁</a>
							</li>
							<li>
								<a href="stock_present.php">股票查詢</a>
							</li>
							<li>
								<a href="stock_transaction.php">股票交易</a>
							</li>
							<li>
								<a href="stock_record.php">交易紀錄</a>
							</li>
							<li>
								<a href="stock_info.php">個人資料</a>
							</li>
							<li>
								<a href="stock_pass.php">修改密碼</a>
							</li>
							<li>
								<a href="stock_board.php">留言板</a>
							</li>
							<li>
								<a href="stock_logout.php">登出</a>
							</li>
						</ul>
						<br class="clear" />
					</div>
			    </div>
		    </div>
		</div>
		<left>
			<form method="post" action="stock_pass_process.php">
				<font color='white' size='5'>
				
				舊密碼：<input type="password" name="old_pass" size="20"/>
				<br/><br/>
				新密碼：<input type="password" name="new_pass0" size="20"/>
				<br/><br/>
				再次輸入新密碼：<input type="password" name="new_pass1" size="20"/>
				<br/><br/>
				<input type="submit" name="pass_alter" value="確定" style="width:70px;height:25px;border:3px orange double;font-size:15px;">
			</form>
			
			
		</left>	
	</body>
</html>
<script language=javascript>

      //一段時間未執行,則系統登出

      <!--

      var oTimerId;

      function Timeout(){

      window.open("stock_logout.php","_top")

      }

      function ReCalculate(){

      clearTimeout(oTimerId);

      oTimerId = setTimeout('Timeout()', 5 * 60 * 1000);

      }

      document.onmousedown = ReCalculate;

      document.onmousemove = ReCalculate;

      ReCalculate();

      //-->

   </script>

 <?}?>
