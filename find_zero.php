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
	//session_start();
	$db = mysqli_connect("localhost", "root","", "stock");
	mysqli_set_charset($db,"utf8");
	$stock_hold=mysqli_query($db,"select * from stock_hold"); 
	date_default_timezone_set("Asia/Taipei");
	
	if ($stock_hold->num_rows > 0) 
	{
		$count=0;
    	while($row = $stock_hold->fetch_assoc()) 
    	{
    		echo "stock_hold第幾行:";
	    	echo $count;
	    	echo '<br>';
	    	$temporary_s_id = $row["s_id"];
            $temporary_s_name = $row["s_name"];
            $temporary_s_number = $row["s_number"];
            $temporary_user_id = $row["user_id"];
            $set_date = '2020-06-24';
            $watch = "--";
    		$find_zero=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$row["s_id"]."'AND date='".$set_date."'"); //抓買or賣
			for($i=1;$i<=mysqli_num_rows($find_zero);$i++)
			{
				$rs=mysqli_fetch_row($find_zero);
				$data_find_zero = $rs[0];  
			}
    		if($data_find_zero == $watch || $data_find_zero == 0)
    		{

    			$zeroRecord = "INSERT INTO zero (s_id, s_name, s_number, user_id) values ('$temporary_s_id','$temporary_s_name','$temporary_s_number','$temporary_user_id')";
    			mysqli_query($db,$zeroRecord);	//新增至失敗的紀錄中
    			echo "抓到0";
    			echo '<br>';
        		
    		}
    		else
    		{
    			echo "沒有";
    			echo '<br>';
    		}
    		
				
            
			$count++;
    
    	}//while的括號
	} 
	else 
	{
		//不做任何事
	    echo "0 results";
	}	
	
	
	




























?>

