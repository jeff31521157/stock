<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta charset="UTF-8" />
		<title>stock trading</title>
		<link href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
</html>

<?php 
	$db = mysqli_connect("localhost", "root","", "test");
	mysqli_set_charset($db,"utf8");
	date_default_timezone_set("Asia/Taipei");
	$today_time = date("Y-m-d H:i:s");
	$today_date = date("Y-m-d");
	$check_holiday = array("2020-04-02", "2020-04-03", "2020-04-04", "2020-05-01", "2020-06-25", "2020-06-26");
	if(in_array($today_date, $check_holiday)) //國定假日
	{
		echo "國定假日不運作";
	}
	else
	{
		$stock_hold = mysqli_query($db,"SELECT id FROM user"); 
		$count = 0;
		for($i=1;$i<=mysqli_num_rows($stock_hold);$i++)
		{

			$rs=mysqli_fetch_row($stock_hold);
			$data_user_id[$count] = $rs[0];  
			$count++;
		}

		$count_array = count($data_user_id);
		for($t=0;$t<$count_array;$t++)
		{
			$user_id = $data_user_id[$t];
			echo $user_id;
			echo ': ';
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
			echo ': ';
			$remain=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
			for($i=1;$i<=mysqli_num_rows($remain);$i++)
			{
				$remain_second=mysqli_fetch_row($remain);
					
			}
			$hole = $total + $remain_second[0];
			$stock_value = "UPDATE user SET stock_value = '".$hole."' WHERE id = '".$user_id."'";
        	mysqli_query($db, $stock_value);
			echo $hole;
			echo '<br>';
		}
		
			
	}


?>

