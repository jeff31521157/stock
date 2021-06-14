<?php
session_start();
$db = mysqli_connect("localhost", "root","", "stock");
mysqli_set_charset($db,"utf8");
$user_idd = $_SESSION["user_id"];

	
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
		<left>
			<Big>尚未執行的交易資料</Big>
			<br/><br/>
			<table width="600" border="2">
				<tr>
					<td>股票代號</td>
					<td>股票名稱</td>
					<td>下單價格</td>
					<td>數量</td>
					<td>買賣</td>
					<td>下單時間</td>
				</tr>
				<?php
				$data01=mysqli_query($db,"SELECT s_id, s_name, order_price, amount, action, order_time from unsuccessful WHERE id='".$user_idd ."'");
				for($i=1;$i<=mysqli_num_rows($data01);$i++){
					$rs01=mysqli_fetch_row($data01);
					?>
					<tr>
						<td><?php echo $rs01[0]?></td>
						<td><?php echo $rs01[1]?></td>
						<td><?php echo $rs01[2]?></td>
						<td><?php echo $rs01[3]?></td>
						<td><?php echo $rs01[4]?></td>
						<td><?php echo $rs01[5]?></td>					
					</tr>
				<?php
				}
				?>
			</table>
			<br/><br/>
			<Big>已成功的交易資料</Big>
			<br/><br/>
			<table width="600" border="2">
				<tr>
					<td>股票代號</td>
					<td>股票名稱</td>
					<td>下單價格</td>
					<td>數量</td>
					<td>買賣</td>
					<td>下單時間</td>
					<td>收盤價</td>
					<td>處理時間</td>
				</tr>
				<?php
				$data02=mysqli_query($db,"SELECT s_id, s_name, order_price, amount, action, order_time, close_price, process_time from record WHERE id='".$user_idd ."'");
				for($i=1;$i<=mysqli_num_rows($data02);$i++){
					$rs02=mysqli_fetch_row($data02);
					?>
					<tr>
						<td><?php echo $rs02[0]?></td>
						<td><?php echo $rs02[1]?></td>
						<td><?php echo $rs02[2]?></td>
						<td><?php echo $rs02[3]?></td>
						<td><?php echo $rs02[4]?></td>
						<td><?php echo $rs02[5]?></td>
						<td><?php echo $rs02[6]?></td>
						<td><?php echo $rs02[7]?></td>
						
					
					</tr>
				<?php
				}
				?>
			</table>
			<br/><br/>
			<Big>失敗的交易資料</Big>
			<br/><br/>
			<table width="600" border="2">
				<tr>
					<td>股票代號</td>
					<td>股票名稱</td>
					<td>下單價格</td>
					<td>數量</td>
					<td>買賣</td>
					<td>下單時間</td>
					<td>收盤價</td>
					<td>處理時間</td>
					<td>失敗原因</td>
				</tr>
				<?php
				$data03=mysqli_query($db,"SELECT s_id, s_name, order_price, amount, action, order_time, close_price, process_time, reason from fail WHERE id='".$user_idd ."'");
				for($i=1;$i<=mysqli_num_rows($data03);$i++){
					$rs03=mysqli_fetch_row($data03);
					?>
					<tr>
						<td><?php echo $rs03[0]?></td>
						<td><?php echo $rs03[1]?></td>
						<td><?php echo $rs03[2]?></td>
						<td><?php echo $rs03[3]?></td>
						<td><?php echo $rs03[4]?></td>
						<td><?php echo $rs03[5]?></td>
						<td><?php echo $rs03[6]?></td>
						<td><?php echo $rs03[7]?></td>
						<td><?php echo $rs03[8]?></td>
					
					</tr>
				<?php
				}
				?>
			</table>
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