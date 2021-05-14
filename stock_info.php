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
			<!-- <?php
				echo date('Y-m-d');
			?> -->
			
			<h1><span>個人資訊 </span><br /><br />Personal Information</h1>
			<br />------------------------------------------------------------<br /><br />
			
			<Big>帳戶餘額:
			<?php
			//$user_id = $_SESSION["user_id"];
			$data=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
			for($i=1;$i<=mysqli_num_rows($data);$i++)
			{
				$rs=mysqli_fetch_row($data);
				 echo $rs[0];
			}
			?>
			</Big>
			<br /><br />
			<Big>股票總價值:</Big>
			<br />
			

			<?php
				date_default_timezone_set("Asia/Taipei");
				$today_date = date("Y-m-d");
				$check_holiday01 = array("2020-06-25", "2020-06-26","2020-06-27","2020-06-28");
				$check_holiday02 = array("2020-05-01","2020-05-02","2020-05-03");
				$check_holiday03 = array("2020-06-29");
				$check_holiday04 = array("2020-05-04");
				if(in_array($today_date, $check_holiday01)) //國定假日
				{
					$total = 0;
					$present_date = date("2020-06-24");
					$data=mysqli_query($db,"SELECT * FROM stock_hold WHERE user_id = '".$user_id."'");

					if ($data->num_rows > 0) 
					{
						while($row = $data->fetch_assoc()) 
						{
						   $temporary_s_id = $row["s_id"];
						   $temporary_s_number = $row["s_number"];
						   $number=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE user_id = '".$user_id."' AND s_id = '".$temporary_s_id."'");
							$close_price=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$temporary_s_id."' AND date = '".$present_date ."'");
							for($i=1;$i<=mysqli_num_rows($close_price);$i++)
							{
								$judge = "--";
								$aa=mysqli_fetch_row($close_price);	//$aa[0]是此張股票的收盤價
								if ($aa[0] != 0 && $aa[0] != $judge)	//避免算到收盤價是0或是--的股票
								{
									$stock_value = $aa[0] * 1000 * $temporary_s_number;
									$total = $total + $stock_value;
								}
								else
								{
									$aa[0] = 0;
									$stock_value = $aa[0] * 1000 * $temporary_s_number;
									$total = $total + $stock_value;
								}
							}
									
									
						}
					}
						    	
					echo $total;
					echo '<br>';
					echo "(以";
					echo $present_date;
					echo "的收盤價為參考計算)";
					echo '<br>';
					echo '<br>';
					echo '<br>';
					echo  "<html><h2>帳戶總價值:</html></h2>";
					$remain=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
					for($i=1;$i<=mysqli_num_rows($remain);$i++)
					{
						$remain_second=mysqli_fetch_row($remain);
								
					}
					$hole = $total + $remain_second[0];
					$TOTAL_value = "UPDATE user SET stock_value = '".$hole."' WHERE id = '".$user_id."'";
			        mysqli_query($db, $TOTAL_value);
					echo "<html><h2>".$hole."</html></h2>";
				}
				else if(in_array($today_date, $check_holiday02))	//國定假日
				{
					$total = 0;
					$present_date = date("2020-04-30");
					$data=mysqli_query($db,"SELECT * FROM stock_hold WHERE user_id = '".$user_id."'");

					if ($data->num_rows > 0) 
					{
						while($row = $data->fetch_assoc()) 
						{
						   $temporary_s_id = $row["s_id"];
						   $temporary_s_number = $row["s_number"];
						   $number=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE user_id = '".$user_id."' AND s_id = '".$temporary_s_id."'");
							$close_price=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$temporary_s_id."' AND date = '".$present_date ."'");
							for($i=1;$i<=mysqli_num_rows($close_price);$i++)
							{
								$judge = "--";
								$aa=mysqli_fetch_row($close_price);	//$aa[0]是此張股票的收盤價
								if ($aa[0] != 0 && $aa[0] != $judge)	//避免算到收盤價是0或是--的股票
								{
									$stock_value = $aa[0] * 1000 * $temporary_s_number;
									$total = $total + $stock_value;
								}
								else
								{
									$aa[0] = 0;
									$stock_value = $aa[0] * 1000 * $temporary_s_number;
									$total = $total + $stock_value;
								}
							}
									
									
						}
					}
						    	
					echo $total;
					echo '<br>';
					echo "(以";
					echo $present_date;
					echo "的收盤價為參考計算)";
					echo '<br>';
					echo '<br>';
					echo '<br>';
					echo  "<html><h2>帳戶總價值:</html></h2>";
					$remain=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
					for($i=1;$i<=mysqli_num_rows($remain);$i++)
					{
						$remain_second=mysqli_fetch_row($remain);
								
					}
					$hole = $total + $remain_second[0];
					$TOTAL_value = "UPDATE user SET stock_value = '".$hole."' WHERE id = '".$user_id."'";
			        mysqli_query($db, $TOTAL_value);
					echo "<html><h2>".$hole."</html></h2>";
				}
				else if(date("w", strtotime("now")) == '6')	//星期六
				{
					$total = 0;
					$yesterday = strtotime("-1 day");
					$present_date = date('Y-m-d',$yesterday);
					$data=mysqli_query($db,"SELECT * FROM stock_hold WHERE user_id = '".$user_id."'");

					if ($data->num_rows > 0) 
					{
						while($row = $data->fetch_assoc()) 
						{
						   $temporary_s_id = $row["s_id"];
						   $temporary_s_number = $row["s_number"];
						   $number=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE user_id = '".$user_id."' AND s_id = '".$temporary_s_id."'");
							$close_price=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$temporary_s_id."' AND date = '".$present_date ."'");
							for($i=1;$i<=mysqli_num_rows($close_price);$i++)
							{
								$judge = "--";
								$aa=mysqli_fetch_row($close_price);	//$aa[0]是此張股票的收盤價
								if ($aa[0] != 0 && $aa[0] != $judge)	//避免算到收盤價是0或是--的股票
								{
									$stock_value = $aa[0] * 1000 * $temporary_s_number;
									$total = $total + $stock_value;
								}
								else
								{
									$aa[0] = 0;
									$stock_value = $aa[0] * 1000 * $temporary_s_number;
									$total = $total + $stock_value;
								}
							}
									
									
						}
					}
						    	
					echo $total;
					echo '<br>';
					echo "(以";
					echo $present_date;
					echo "的收盤價為參考計算)";
					echo '<br>';
					echo '<br>';
					echo '<br>';
					echo  "<html><h2>帳戶總價值:</html></h2>";
					$remain=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
					for($i=1;$i<=mysqli_num_rows($remain);$i++)
					{
						$remain_second=mysqli_fetch_row($remain);
								
					}
					$hole = $total + $remain_second[0];
					$TOTAL_value = "UPDATE user SET stock_value = '".$hole."' WHERE id = '".$user_id."'";
			        mysqli_query($db, $TOTAL_value);
					echo "<html><h2>".$hole."</html></h2>";
				}
				else if (date("w", strtotime("now")) == '0')	//星期日
				{
					$total = 0;
					$yesterday = strtotime("-2 day");
					$present_date = date('Y-m-d',$yesterday);
					$data=mysqli_query($db,"SELECT * FROM stock_hold WHERE user_id = '".$user_id."'");

					if ($data->num_rows > 0) 
					{
						while($row = $data->fetch_assoc()) 
						{
						   $temporary_s_id = $row["s_id"];
						   $temporary_s_number = $row["s_number"];
						   $number=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE user_id = '".$user_id."' AND s_id = '".$temporary_s_id."'");
							$close_price=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$temporary_s_id."' AND date = '".$present_date ."'");
							for($i=1;$i<=mysqli_num_rows($close_price);$i++)
							{
								$judge = "--";
								$aa=mysqli_fetch_row($close_price);	//$aa[0]是此張股票的收盤價
								if ($aa[0] != 0 && $aa[0] != $judge)	//避免算到收盤價是0或是--的股票
								{
									$stock_value = $aa[0] * 1000 * $temporary_s_number;
									$total = $total + $stock_value;
								}
								else
								{
									$aa[0] = 0;
									$stock_value = $aa[0] * 1000 * $temporary_s_number;
									$total = $total + $stock_value;
								}
							}
									
									
						}
					}
						    	
					echo $total;
					echo '<br>';
					echo "(以";
					echo $present_date;
					echo "的收盤價為參考計算)";
					echo '<br>';
					echo '<br>';
					echo '<br>';
					echo  "<html><h2>帳戶總價值:</html></h2>";
					$remain=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
					for($i=1;$i<=mysqli_num_rows($remain);$i++)
					{
						$remain_second=mysqli_fetch_row($remain);
								
					}
					$hole = $total + $remain_second[0];
					$TOTAL_value = "UPDATE user SET stock_value = '".$hole."' WHERE id = '".$user_id."'";
			        mysqli_query($db, $TOTAL_value);
					echo "<html><h2>".$hole."</html></h2>";
				}
				else 	//星期一~五
				{
					$SpecificTime=date("Y-m-d 15:45:00");	//每天會在15:35將股票丟進資料庫
					if(date("r", strtotime("$SpecificTime")) > date("r", strtotime("now")))	//15:45過後換成呈現今天的股票
					{
						if (date("w", strtotime("now")) == '1')	//星期一15:45前會顯示上星期五的股票
						{
							if(in_array($today_date, $check_holiday03))	//連假後要追到上次開盤時間
							{
								$total = 0;
								$yesterday = strtotime("-5 day");
								$present_date = date('Y-m-d',$yesterday);
								$data=mysqli_query($db,"SELECT * FROM stock_hold WHERE user_id = '".$user_id."'");

								if ($data->num_rows > 0) 
								{
							    	while($row = $data->fetch_assoc()) 
							    	{
							    		$temporary_s_id = $row["s_id"];
							    		$temporary_s_number = $row["s_number"];
							    		$number=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE user_id = '".$user_id."' AND s_id = '".$temporary_s_id."'");
											$close_price=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$temporary_s_id."' AND date = '".$present_date ."'");
											for($i=1;$i<=mysqli_num_rows($close_price);$i++)
											{
												$judge = "--";
												$aa=mysqli_fetch_row($close_price);	//$aa[0]是此張股票的收盤價
												if ($aa[0] != 0 && $aa[0] != $judge)	//避免算到收盤價是0或是--的股票
												{
													$stock_value = $aa[0] * 1000 * $temporary_s_number;
													$total = $total + $stock_value;
												}
												else
												{
													$aa[0] = 0;
													$stock_value = $aa[0] * 1000 * $temporary_s_number;
													$total = $total + $stock_value;
												}
											}
										
										
									}
							    }	
							    echo $total;
								echo '<br>';
								echo "(以";
								echo $present_date;
								echo "的收盤價為參考計算)";
								echo '<br>';
								echo '<br>';
								echo '<br>';
								echo  "<html><h2>帳戶總價值:</html></h2>";
								$remain=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
								for($i=1;$i<=mysqli_num_rows($remain);$i++)
								{
									$remain_second=mysqli_fetch_row($remain);
										
								}
								$hole = $total + $remain_second[0];
								$TOTAL_value = "UPDATE user SET stock_value = '".$hole."' WHERE id = '".$user_id."'";
					        	mysqli_query($db, $TOTAL_value);
								echo "<html><h2>".$hole."</html></h2>";
							}
							else if(in_array($today_date, $check_holiday04))	//連假後要追到上次開盤時間
							{
								$total = 0;
								$yesterday = strtotime("-4 day");
								$present_date = date('Y-m-d',$yesterday);
								$data=mysqli_query($db,"SELECT * FROM stock_hold WHERE user_id = '".$user_id."'");

								if ($data->num_rows > 0) 
								{
							    	while($row = $data->fetch_assoc()) 
							    	{
							    		$temporary_s_id = $row["s_id"];
							    		$temporary_s_number = $row["s_number"];
							    		$number=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE user_id = '".$user_id."' AND s_id = '".$temporary_s_id."'");
											$close_price=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$temporary_s_id."' AND date = '".$present_date ."'");
											for($i=1;$i<=mysqli_num_rows($close_price);$i++)
											{
												$judge = "--";
												$aa=mysqli_fetch_row($close_price);	//$aa[0]是此張股票的收盤價
												if ($aa[0] != 0 && $aa[0] != $judge)	//避免算到收盤價是0或是--的股票
												{
													$stock_value = $aa[0] * 1000 * $temporary_s_number;
													$total = $total + $stock_value;
												}
												else
												{
													$aa[0] = 0;
													$stock_value = $aa[0] * 1000 * $temporary_s_number;
													$total = $total + $stock_value;
												}
											}
										
										
									}
							    }
							    	
							    echo $total;
								echo '<br>';
								echo "(以";
								echo $present_date;
								echo "的收盤價為參考計算)";
								echo '<br>';
								echo '<br>';
								echo '<br>';
								echo  "<html><h2>帳戶總價值:</html></h2>";
								$remain=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
								for($i=1;$i<=mysqli_num_rows($remain);$i++)
								{
									$remain_second=mysqli_fetch_row($remain);
										
								}
								$hole = $total + $remain_second[0];
								$TOTAL_value = "UPDATE user SET stock_value = '".$hole."' WHERE id = '".$user_id."'";
					        	mysqli_query($db, $TOTAL_value);
								echo "<html><h2>".$hole."</html></h2>";
							}
							else
							{
								$total = 0;
								$yesterday = strtotime("-3 day");
								$present_date = date('Y-m-d',$yesterday);
								$data=mysqli_query($db,"SELECT * FROM stock_hold WHERE user_id = '".$user_id."'");

								if ($data->num_rows > 0) 
								{
							    	while($row = $data->fetch_assoc()) 
							    	{
							    		$temporary_s_id = $row["s_id"];
							    		$temporary_s_number = $row["s_number"];
							    		$number=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE user_id = '".$user_id."' AND s_id = '".$temporary_s_id."'");
											$close_price=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$temporary_s_id."' AND date = '".$present_date ."'");
											for($i=1;$i<=mysqli_num_rows($close_price);$i++)
											{
												$judge = "--";
												$aa=mysqli_fetch_row($close_price);	//$aa[0]是此張股票的收盤價
												if ($aa[0] != 0 && $aa[0] != $judge)	//避免算到收盤價是0或是--的股票
												{
													$stock_value = $aa[0] * 1000 * $temporary_s_number;
													$total = $total + $stock_value;
												}
												else
												{
													$aa[0] = 0;
													$stock_value = $aa[0] * 1000 * $temporary_s_number;
													$total = $total + $stock_value;
												}
											}
										
										
									}
							    }
							    	
							    echo $total;
								echo '<br>';
								echo "(以";
								echo $present_date;
								echo "的收盤價為參考計算)";
								echo '<br>';
								echo '<br>';
								echo '<br>';
								echo  "<html><h2>帳戶總價值:</html></h2>";
								$remain=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
								for($i=1;$i<=mysqli_num_rows($remain);$i++)
								{
									$remain_second=mysqli_fetch_row($remain);
										
								}
								$hole = $total + $remain_second[0];
								$TOTAL_value = "UPDATE user SET stock_value = '".$hole."' WHERE id = '".$user_id."'";
					        	mysqli_query($db, $TOTAL_value);
								echo "<html><h2>".$hole."</html></h2>";
							}
							
						}
						else
						{
							$total = 0;
							$yesterday = strtotime("-1 day");
							$present_date = date('Y-m-d',$yesterday);
							$data=mysqli_query($db,"SELECT * FROM stock_hold WHERE user_id = '".$user_id."'");

							if ($data->num_rows > 0) 
							{
						    	while($row = $data->fetch_assoc()) 
						    	{
						    		$temporary_s_id = $row["s_id"];
						    		$temporary_s_number = $row["s_number"];
						    		$number=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE user_id = '".$user_id."' AND s_id = '".$temporary_s_id."'");
										$close_price=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$temporary_s_id."' AND date = '".$present_date ."'");
										for($i=1;$i<=mysqli_num_rows($close_price);$i++)
										{
											$judge = "--";
											$aa=mysqli_fetch_row($close_price);	//$aa[0]是此張股票的收盤價
											if ($aa[0] != 0 && $aa[0] != $judge)	//避免算到收盤價是0或是--的股票
											{
												$stock_value = $aa[0] * 1000 * $temporary_s_number;
												$total = $total + $stock_value;
											}
											else
											{
												$aa[0] = 0;
												$stock_value = $aa[0] * 1000 * $temporary_s_number;
												$total = $total + $stock_value;
											}
										}
									
									
								}
						    }
						    	
						    
						    echo $total;
						    echo '<br>';
						    echo "(以";
						    echo $present_date;
						    echo "的收盤價為參考計算)";
						    echo '<br>';
						    echo '<br>';
						    echo '<br>';
						    echo  "<html><h2>帳戶總價值:</html></h2>";
						    $remain=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
							for($i=1;$i<=mysqli_num_rows($remain);$i++)
							{
								$remain_second=mysqli_fetch_row($remain);
								
							}
							$hole = $total + $remain_second[0];
							$TOTAL_value = "UPDATE user SET stock_value = '".$hole."' WHERE id = '".$user_id."'";
			        		mysqli_query($db, $TOTAL_value);
							echo "<html><h2>".$hole."</html></h2>";
						}
						
						
					}
					else
					{
						$total = 0;
						$present_date = date('Y-m-d');
						$data=mysqli_query($db,"SELECT * FROM stock_hold WHERE user_id = '".$user_id."'");
						if ($data->num_rows > 0) 
						{
					    	while($row = $data->fetch_assoc()) 
					    	{
					    		$temporary_s_id = $row["s_id"];
					    		$temporary_s_number = $row["s_number"];
					    		$number=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE user_id = '".$user_id."' AND s_id = '".$temporary_s_id."'");
									$close_price=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$temporary_s_id."' AND date = '".$present_date ."'");
									for($i=1;$i<=mysqli_num_rows($close_price);$i++)
									{	
										$judge = "--";
										$aa=mysqli_fetch_row($close_price);	//$aa[0]是此張股票的收盤價
										if ($aa[0] != 0 && $aa[0] != $judge)	//避免算到收盤價是0或是--的股票
										{
											$stock_value = $aa[0] * 1000 * $temporary_s_number;
											$total = $total + $stock_value;
										}
										else
										{
											$aa[0] = 0;
											$stock_value = $aa[0] * 1000 * $temporary_s_number;
											$total = $total + $stock_value;
										}
										
									}
								
								
							}
					    }
					    echo $total;
						echo '<br>';
						echo "(以";
						echo $present_date;
						echo "的收盤價為參考計算)";
						echo '<br>';
						echo '<br>';
						echo '<br>';
						echo  "<html><h2>帳戶總價值:</html></h2>";
						$remain=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
						for($i=1;$i<=mysqli_num_rows($remain);$i++)
						{
							$remain_second=mysqli_fetch_row($remain);
								
						}
						$hole = $total + $remain_second[0];
						$TOTAL_value = "UPDATE user SET stock_value = '".$hole."' WHERE id = '".$user_id."'";
			        	mysqli_query($db, $TOTAL_value);
						echo "<html><h2>".$hole."</html></h2>";
					}
				}
			?> 
			
			<br />------------------------------------------------------------<br />
			<br />
			<Big>持有股票</Big><br />
			<table width="600" border="2">
				<tr>
					<td>證劵代號</td>
					<td>證劵名稱</td>
					<td>擁有張數</td>
				</tr>
				<?php
				$data=mysqli_query($db,"select * from stock_hold WHERE user_id='".$user_id."'");
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
