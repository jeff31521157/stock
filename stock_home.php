<?php
session_start();
$db = mysqli_connect("localhost", "root","password", "stock");
mysqli_set_charset($db,"utf8");
$user_id = $_SESSION["user_id"];

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--

	Design by TEMPLATED
	http://templated.co
	Released for free under the Creative Commons Attribution License

	Name       : Nameless Geometry
	Version    : 1.0
	Released   : 20130222

-->
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
							<a href="stock_home.php">股票</a>
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
		<center>
			<h1><span>首頁 </span></h1>
			<br /><br /><br /><br />
			<h2><span>系統公告</span></h2><br/>
			<Big>1.股票查詢更新時間 : 星期一~星期五 下午3:45</Big><br/><br/>

			<Big>2.交易處理(時間) : 星期一~星期五 下午4:00</Big><br/>
			<Big>(建議於每日股市交易營業時間內9:00~13:30買賣[當日收盤價])</Big><br/>
			<Big>(如下單時間超過下午1: 30 屬於隔天的單 則當日將不會處理 延至隔日處理)</Big>
			<br /><br />

			<Big>3.交易處理(買股票) : 買價夠高(下單價格>=收盤價) 可以買 反之會購買失敗</Big><br/><br/>

			<Big>4.交易處理(賣股票) : 賣價夠低(下單價格<=收盤價) 可以賣 反之會販賣失敗</Big><br/><br/>

			<Big>5.交易處理 :當某張股票收盤價為0時，交易處理這張股票會失敗 並顯示收盤價有錯誤</Big><br/><br/>

			<Big>6.有任何問題可以email或是在留言版提出</Big><br/>
			<br /><br />


			<h2><span>聯絡窗口</span></h2>
			<Big>任何系統問題請詢問此窗口:</Big>
			<Big>xxxxxx@gmail.com</Big>
			</center>	
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

      oTimerId = setTimeout('Timeout()', 15 * 60 * 1000);

      }

      document.onmousedown = ReCalculate;

      document.onmousemove = ReCalculate;

      ReCalculate();

      //-->

   </script>

 <?}?>
