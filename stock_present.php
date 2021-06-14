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
		<center>
			<h1><span>股票交易與查詢 </span></h1>
			<br /><br />
			<Big>股票更新 : 星期一~星期五 下午3:45</Big><br/>
			<br />
		</p>
		<form id="form1" name="form1" method="post" action="stock_single.php">
				股票代號：<input type="text" name="stock_id" id="stock_id" size="7"/>
				<input type="submit" name="button" id="button" value="查詢" /> &nbsp (例如:0050)
		</form>
		 
		<br /><br />
		<table width="1400" border="2">
			<tr>
				<td>
					序號
				</td>
				<td>
					證劵代號	
				</td>
				<td>
					證劵名稱	
				</td>
				<td>
					成交股數
				</td>
				<td>
					成交筆數
				</td>
				<td>
					成交金額
				</td>
				<td>
					開盤價
				</td>
				<td>
					最高價
				</td>
				<td>
					最低價
				</td>
				<td>
					收盤價
				</td>
				<td>
					漲跌價差
				</td>
				<td>
					最後揭示買價
				</td>
				<td>
					最後揭示買量
				</td>
				<td>
					最後揭示賣價
				</td>
				<td>
					最後揭示賣量
				</td>
				<td>
					本益比
				</td>
				<td>
					日期
				</td>
			</tr>
		</center>
		<?php
		date_default_timezone_set("Asia/Taipei");
		$today_date = date("Y-m-d");
		$check_holiday01 = array("2020-06-25", "2020-06-26","2020-06-27","2020-06-28");
		$check_holiday02 = array("2020-05-01","2020-05-02","2020-05-03");
		$check_holiday03 = array("2020-06-29");
		$check_holiday04 = array("2020-05-04");
		if(in_array($today_date, $check_holiday01)) //國定假日
		{
			$present_date = date("2020-06-24");
			echo $present_date;
			$data=mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."'");
		}
		else if(in_array($today_date, $check_holiday02))	//國定假日
		{
			$present_date = date("2020-04-30");
			echo $present_date;
			$data=mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."'");
		}
		else if(date("w", strtotime("now")) == '6')	//星期六
		{
			$saturday = strtotime("-1 day");
			$present_date = date('Y-m-d',$saturday);
			echo $present_date;
			$data=mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."'");
		}
		else if (date("w", strtotime("now")) == '0')	//星期日
		{
			$sunday = strtotime("-2 day");
			$present_date = date('Y-m-d',$sunday);
			echo $present_date;
			$data=mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."'");
		}
		else 	//星期一~五
		{
		 	$SpecificTime=date("Y-m-d 15:45:00");	//每天會在15:40將股票丟進資料庫 15:45再做頁面更新
			if(date("r", strtotime("$SpecificTime")) > date("r", strtotime("now")))	//15:45過後換成呈現今天的股票
			{
				if (date("w", strtotime("now")) == '1')	//星期一15:45前會顯示上星期五的股票
				{	
					if(in_array($today_date, $check_holiday03))	//連假後要追到上次開盤時間
					{
						$holiday03_early = strtotime("-5 day");
						$present_date = date('Y-m-d',$holiday03_early);
						echo $present_date;
						$data=mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."'");
					}
					else if(in_array($today_date, $check_holiday04))	//連假後要追到上次開盤時間
					{
						$holiday04_early = strtotime("-4 day");
						$present_date = date('Y-m-d',$holiday04_early);
						echo $present_date;
						$data=mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."'");
					}
					else
					{
						$monday_early = strtotime("-3 day");
						$present_date = date('Y-m-d',$monday_early);
						echo $present_date;
						$data=mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."'");
					}
					

				}
				else
				{
					$yesterday = strtotime("-1 day");
					$present_date = date('Y-m-d',$yesterday);
					echo $present_date;
					$data=mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."'");
				}
				

			}
			else
			{
				
				$present_date = date('Y-m-d');
				echo $present_date;
				$data=mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."'");
			}
		}
		
		$number = 50;
		$total = mysqli_num_rows($data);
		$pages = ceil($total/$number);
		$today = date('Y-m-d');
		$p = 1;
		// echo $p;

		if($number){	//放$number是為了要直接true進來
			$p=1;
			$start = ($p-1)*$number;
			$data = mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."' limit $start, $number");
		}
		
		if(isset($_GET['p'])){
			$p = $_GET['p'];
			$start = ($p-1)*$number;
			$data = mysqli_query($db,"SELECT * from stock WHERE date = '".$present_date ."' limit $start, $number");
		}

		

		
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
				
				<!-- <td>
					<?php 
					echo "<button id = $rs[1] onClick=\"reply_click(this.id)\">購買</button>" 
					?> 
				</td> -->
				<!-- <script>
					// function reply_click_track(s_id){
					// 	var num = <?php echo $i ?>;
					// 	alert(num );
					// 	window.location.href = 'stock_info.php' ;
					// }
					function reply_click(clicked_id)
					{
						/* <?php echo $g  ?> = clicked_id;
						var num = <?php echo $g ?>;*/
						alert(clicked_id);
						//var test = clicked_id-1;
						
						window.location.href = "stock_buy.php?clicked_id="+clicked_id;

					}
				</script> -->  
			</tr>
		<?php
		}
		?>
		</table>
		<p align="center">
		<?php
		$start_p = $p-5 < 0 ? 1 : $p-4;
		$end_p = $p+5 > $pages ? $pages : $start_p+9;
		echo "<a href=stock_present.php?s=1>最前面</a>&nbsp&nbsp";
		for($g=$start_p; $g<=$end_p; $g++){
			if(isset($click_down)){
				echo "<a href=stock_present.php?s=$g>$g</a>&nbsp&nbsp";
			}
			else{
				echo "<a href=stock_present.php?p=$g>$g</a>&nbsp&nbsp";
			}
		}
		echo "<a href=stock_present.php?p=$pages>最後面</a>&nbsp&nbsp";
		?>
		</p>
		<p align="center">共有<?php echo $pages?>頁</p>
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