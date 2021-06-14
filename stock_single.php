<?php
session_start();
$db = mysqli_connect("localhost", "root","", "stock");
mysqli_set_charset($db,"utf8");
$user_idd = $_SESSION["user_id"];

	
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
			<table width="1400" border="2">
				<tr>
					<td>序號</td>
					<td>證劵代號</td>
					<td>證劵名稱</td>
					<td>成交股數</td>
					<td>成交筆數</td>
					<td>成交金額</td>
					<td>開盤價</td>
					<td>最高價</td>
					<td>最低價</td>
					<td>收盤價</td>
					<td>漲跌價差</td>
					<td>最後揭示買價</td>
					<td>最後揭示買量</td>
					<td>最後揭示賣價</td>
					<td>最後揭示賣量</td>
					<td>本益比</td>
					<td>日期</td>
				</tr>
			</center>	
		<?php
        $stock_single_id = $_POST["stock_id"];
        $data=mysqli_query($db,"SELECT * FROM stock WHERE s_id='".$stock_single_id."'");
        for($i=1;$i<=mysqli_num_rows($data);$i++){



				$rs=mysqli_fetch_row($data);
				?>
				<tr>
					<td><?php echo $rs[0]?></td>
					<td><?php echo $rs[1]?></td>
					<td><?php echo $rs[2]?></td>
					<td><?php echo $rs[3]?></td>
					<td><?php echo $rs[4]?></td>
					<td><?php echo $rs[5]?></td>
					<td><?php echo $rs[6]?></td>
					<td><?php echo $rs[7]?></td>
					<td><?php echo $rs[8]?></td>
					<td><?php echo $rs[9]?></td>
					<td><?php echo $rs[10]?></td>
					<td><?php echo $rs[11]?></td>
					<td><?php echo $rs[12]?></td>
					<td><?php echo $rs[13]?></td>
					<td><?php echo $rs[14]?></td>
					<td><?php echo $rs[15]?></td>
					<td><?php echo $rs[16]?></td>
				</tr>
			<?php
			}
			?>
        
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
