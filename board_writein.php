<?php
session_start();
$db = mysqli_connect("localhost", "root","", "stock");
mysqli_set_charset($db,"utf8");


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
	<?php
    $typing = $_POST['typing'];
    $user_id = $_SESSION["user_id"];
	/*echo $user_name;
	echo $typing;*/
	$sql = "INSERT INTO board (user_id, content) values ('$user_id','$typing')";
	//echo $sql;
	mysqli_query($db,$sql);
    
	?>
	<center>	
	<form action="board_writein.php" method="post">
		留言:<input type="text" name="typing" />
		<input type="submit" name="submit" value="提交" />
	</form>
	</br>
	<table width="1200" border="2">
	<tr>
		<td>學號</td>
		<td>內容</td>
		<td>時間</td>
	</tr>
    </center>
	<?php
	    $data=mysqli_query($db,"select * from board");
		for($i=1;$i<=mysqli_num_rows($data);$i++){
			$rs=mysqli_fetch_row($data);
			?>
			<tr>
				<td><?php echo $rs[0]?></td>
				<td><?php echo $rs[1]?></td>
				<td><?php echo $rs[2]?></td>
			</tr>
	<?php
	}
	?>
	</table>		
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