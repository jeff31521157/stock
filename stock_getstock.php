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
	date_default_timezone_set("Asia/Taipei");
	$today = date('Y-m-d');
	$date_string = str_replace('-', '', $today);
    $connect = mysqli_connect("localhost", "root","password", "stock"); //Connect PHP to MySQL Database
    mysqli_set_charset($connect,"utf8");
    $path = 'C:\\Users\\user\\Desktop\\getstock\\'; 
	$json = 'stock.json';
	$filename = $path.$date_string.$json;
    $data = file_get_contents($filename); //Read the JSON file in PHP
    $array = json_decode($data, true); //Convert JSON String into PHP Array
    $count = 1;
    foreach($array as $row) //Extract the Array Values by using Foreach Loop
    {
        $after_成交股數 = str_replace(',', '', $row[2]);
		$after_成交筆數 = str_replace(',', '', $row[3]);
		$after_成交金額 = str_replace(',', '', $row[4]);
		$after_開盤價 = str_replace(',', '', $row[5]);
		$after_最高價 = str_replace(',', '', $row[6]);
		$after_最低價 = str_replace(',', '', $row[7]);
		$after_收盤價 = str_replace(',', '', $row[8]);
		$after_最後揭示買價 = str_replace(',', '', $row[11]);
		$after_最後揭示買量 = str_replace(',', '', $row[12]);
		$after_最後揭示賣價 = str_replace(',', '', $row[13]);
		$after_最後揭示賣量 = str_replace(',', '', $row[14]);
		$after_本益比 = str_replace(',', '', $row[15]);
        $query = "INSERT INTO stock (`s_index`,`s_id`, `s_name`, `s_transaction_stock`, `s_transaction_number`, `s_transaction_money`, `s_start`, `s_max`, `s_min`, `s_close`, `s_Increase/decrease_spread`, `s_close_buy`, `s_close_buy_number`, `s_close_sell`, `s_close_sell_number`, `s_PER` , `date`) VALUES ('".$count."','".$row[0]."', '".$row[1]."','".$after_成交股數."','".$after_成交筆數."','".$after_成交金額."','".$after_開盤價."','".$after_最高價."','".$after_最低價."','".$after_收盤價."','".$row[10]."','".$after_最後揭示買價."','".$after_最後揭示買量."','".$after_最後揭示賣價."','".$after_最後揭示賣量."','".$after_本益比."','".$today."')";
        	//mysqli_query($connect, $query);
        

        if(mysqli_query($connect, $query))
		{
			echo '新增成功!';
			$count++;
			
		}
		else
		{
			echo '新增失敗!';
		}
    }
?>


