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
	$db = mysqli_connect("localhost", "root","password", "stock");
	mysqli_set_charset($db,"utf8");
	$unsuccess_data=mysqli_query($db,"select * from unsuccessful"); 
	date_default_timezone_set("Asia/Taipei");
	$today_time = date("Y-m-d H:i:s");
	$today_date = date("Y-m-d");
	$check_holiday = array("2020-06-25", "2020-06-26");
	$check_holiday01 = array("2020-06-29");
	//echo $today_time; //print出現在時間
	if(date("w", strtotime("now")) == '1')
	{
		if(in_array($today_date, $check_holiday01)) //國定假日後的星期一
		{
			$yeaterday_date = date("2020-06-24");
		}
		else
		{
			$middle = strtotime("-3 day");
			$yeaterday_date = date('Y-m-d',$middle);
		}
	}
	else
	{
		$middle = strtotime("-1 day");
		$yeaterday_date = date('Y-m-d',$middle);
	}


	if(in_array($today_date, $check_holiday)) //國定假日
	{
		echo "國定假日不運作";
	}
	else
	{
		if ($unsuccess_data->num_rows > 0) 
		{
			$count=0;
	    	while($row = $unsuccess_data->fetch_assoc()) 
	    	{
	    		echo "unsuccessful第幾行:";
	    		echo $count;
	    		echo '<br>';
	    		$watch = "--";
	    		$closePrice=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$row["s_id"]."' AND date = '".$today_date."'"); //抓收盤價
	    		for($i=1;$i<=mysqli_num_rows($closePrice);$i++)
				{
					$rs=mysqli_fetch_row($closePrice);	//收盤價
					if($rs[0] == $watch || $rs[0] == 0)
					{
						$data_closePrice = 0;
					}
					else
					{
						$data_closePrice = $rs[0];
					}
				}

				$Yes_closePrice=mysqli_query($db,"SELECT s_close FROM stock WHERE s_id = '".$row["s_id"]."' AND date = '".$yeaterday_date."'"); //抓昨天的收盤價
	    		for($i=1;$i<=mysqli_num_rows($Yes_closePrice);$i++)
				{
					$rs=mysqli_fetch_row($Yes_closePrice);	//昨天的收盤價
					if($rs[0] == $watch || $rs[0] == 0)	//昨天的收盤價如果是0或沒顯示，會讓他在後面漲停或是跌停判斷時過關
					{
						if($row["action"] == "buy")
						{
							$data_Yes_closePrice = 10000;
						}
						else
						{
							$data_Yes_closePrice = 0.001;
						}
						
					}
					else
					{
						$data_Yes_closePrice = $rs[0];
					}
				}

				$orderPrice=mysqli_query($db,"SELECT order_price FROM unsuccessful WHERE order_price = '".$row["order_price"]."'AND order_time='".$row["order_time"]."'"); //抓出價
				for($i=1;$i<=mysqli_num_rows($orderPrice);$i++)
				{
					$rs=mysqli_fetch_row($orderPrice);
					$data_orderPrice = $rs[0];   
				}
				$amountNumber=mysqli_query($db,"SELECT amount FROM unsuccessful WHERE amount = '".$row["amount"]."'AND order_time='".$row["order_time"]."'"); //抓買賣數量
				for($i=1;$i<=mysqli_num_rows($amountNumber);$i++)
				{
					$rs=mysqli_fetch_row($amountNumber);
					$data_amountNumber = $rs[0];  
				}
				$BuyOrSell=mysqli_query($db,"SELECT action FROM unsuccessful WHERE action = '".$row["action"]."'AND order_time='".$row["order_time"]."'"); //抓買or賣
				for($i=1;$i<=mysqli_num_rows($BuyOrSell);$i++)
				{
					$rs=mysqli_fetch_row($BuyOrSell);
					$data_BuyOrSell = $rs[0];  	
				}
				$orderTime=mysqli_query($db,"SELECT order_time FROM unsuccessful WHERE order_time = '".$row["order_time"]."'"); //抓下單時間
				for($i=1;$i<=mysqli_num_rows($orderTime);$i++)
				{
					$rs=mysqli_fetch_row($orderTime);
					$data_orderTime = $rs[0];  
				}
				$balance=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$row["id"]."'"); //抓餘額
	    		for($i=1;$i<=mysqli_num_rows($balance);$i++)
				{
					$rs=mysqli_fetch_row($balance);
					$data_balance = $rs[0];  
				}
				$transaction_price = $data_closePrice*1000*$data_amountNumber;	//算出交易價格
				
				$temporary_id = $row["id"];
	            $temporary_s_id = $row["s_id"];
	            $temporary_s_name = $row["s_name"];
	            $temporary_order_price = $row["order_price"];
	            $temporary_amount = $row["amount"];
	            $temporary_action = $row["action"];
	            $temporary_order_time = $row["order_time"];
	            $judge = "--";
	            $SpecificTime=date("Y-m-d 13:30:00");
  				
	            $compare_time=date("$temporary_order_time");
				if ($SpecificTime > $compare_time)   //現在時間與下單時間比較($data_orderTime)
                {      echo"馬上做";
	                if ($data_closePrice != 0 && $data_closePrice != $judge)   //如果當天收盤價不是抓到0 就做
	                {
	                	if(strpos($data_BuyOrSell, 'buy') !== false) 
	                	{	                		
	                		if($data_closePrice == round($data_Yes_closePrice * 1.1 ,3))	//今天股價 漲停板
	                		{
	                			$FailRecord = "INSERT INTO fail (id, s_id, s_name, order_price, amount, action, order_time, close_price, process_time, reason) values ('$temporary_id','$temporary_s_id','$temporary_s_name','$temporary_order_price','$temporary_amount','$temporary_action','$temporary_order_time','$data_closePrice','$today_time','漲停買不到')";
	                			mysqli_query($db,$FailRecord);	//新增至失敗的紀錄中
	                		}
	                		else
	                		{
	                			$NewMoney = $data_balance - $transaction_price;	//判斷餘額
		                		echo $NewMoney;
		                		echo '<br>';
		                		if($NewMoney >= 0)	//餘額夠
		                		{
		                			
		                			if ($temporary_order_price >= $data_closePrice)  //買價夠高(出價>=收盤) 可以買
		                			{
		                				
		                				$success = "INSERT INTO record (id, s_id, s_name, order_price, amount, action, order_time, close_price, process_time) values ('$temporary_id','$temporary_s_id','$temporary_s_name','$temporary_order_price','$temporary_amount','$temporary_action','$temporary_order_time','$data_closePrice','$today_time')";
		                				mysqli_query($db,$success);	//新增至成功的紀錄中
		                				$balance_deduct = "UPDATE user SET user_account = '".$NewMoney."' WHERE id = '".$row["id"]."'";
	        							mysqli_query($db, $balance_deduct);	//扣款


	        							$check_hold = mysqli_query($db,"SELECT s_number from stock_hold WHERE s_id='".$row["s_id"] ."' AND user_id='".$row["id"]."'");	//查有沒有擁有這項股票  (決定要insert 或 update至stock_hold)
	        							$num_row=mysqli_num_rows($check_hold);
	        							if($num_row > 0)   //判斷有沒有值  (如果有值就做UPDATE)
	            						{
	            							for($i = 1; $i <= $num_row;$i++)
	        								{
	        									$rs=mysqli_fetch_row($check_hold);//echo $rs[0];
	        								}
	        								$s_number_present=$rs[0];	//取出現有的股數
	        								echo $s_number_present;
	        								echo '<br>';
	        								$s_number_count=$s_number_present+$data_amountNumber;	//現有的股數 + 買的股數
	        								echo $s_number_count;
	        								echo '<br>';
	            							$outcome_0="UPDATE stock_hold SET s_number='".$s_number_count."' WHERE s_id='".$row["s_id"] ."'AND user_id= '".$row["id"] ."'";
	            							mysqli_query($db,$outcome_0);
	            						}
	            						else 	//沒值 用insert的
	            						{
	            							$outcome_1 = "INSERT INTO stock_hold (s_id, s_name, s_number, user_id) values ('$temporary_s_id','$temporary_s_name','$data_amountNumber','$temporary_id')";
	            							mysqli_query($db,$outcome_1);
	            						}
		                			}
		                			else if ($temporary_order_price < $data_closePrice)   //買價太低(出價<收盤) 不能買
		                			{
		                				$FailRecord = "INSERT INTO fail (id, s_id, s_name, order_price, amount, action, order_time, close_price, process_time, reason) values ('$temporary_id','$temporary_s_id','$temporary_s_name','$temporary_order_price','$temporary_amount','$temporary_action','$temporary_order_time','$data_closePrice','$today_time','買價太低')";
		                				mysqli_query($db,$FailRecord);	//新增至失敗的紀錄中
		                			}
		                		}
		                		else if ($NewMoney < 0)  //當餘額不足購買
		                		{
		                			$FailRecord = "INSERT INTO fail (id, s_id, s_name, order_price, amount, action, order_time, close_price, process_time, reason) values ('$temporary_id','$temporary_s_id','$temporary_s_name','$temporary_order_price','$temporary_amount','$temporary_action','$temporary_order_time','$data_closePrice','$today_time','餘額不足')";
		                			mysqli_query($db,$FailRecord);	//新增至失敗的紀錄中
		                		}
	                		}	                		
	                		//刪掉在Unsuccessful的資料   (成功買進,價格買不到,餘額不夠買 都用這個)
	                		$delete = "DELETE FROM unsuccessful WHERE id='".$row["id"]."' AND order_time='".$data_orderTime."'";
	                		mysqli_query($db,$delete);
	                	}
	                	else if (strpos($data_BuyOrSell, 'sell') !== false) 
	                	{	
	                		if($data_closePrice == round($data_Yes_closePrice * 0.9 ,3))	//今天股價 跌停
	                		{
	                			$FailRecord = "INSERT INTO fail (id, s_id, s_name, order_price, amount, action, order_time, close_price, process_time, reason) values ('$temporary_id','$temporary_s_id','$temporary_s_name','$temporary_order_price','$temporary_amount','$temporary_action','$temporary_order_time','$data_closePrice','$today_time','跌停賣不出')";
			                	mysqli_query($db,$FailRecord);	//新增至失敗的紀錄中
	                		}
	                		else
	                		{
	                			$check=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE s_id='".$row["s_id"] ."'AND user_id='".$row["id"]."'");
						        for($i=1;$i<=mysqli_num_rows($check);$i++)
						        {
						        	$remain_amount=mysqli_fetch_row($check);//echo $rs[0];
						        }
						        
								$checknum=mysqli_num_rows($check);
								echo $checknum;
								echo '<br>';
						        if($checknum > 0)	//判斷此使用者還有沒有持有這張股票
						        {
						        	if($remain_amount[0] >= $data_amountNumber)
							        {
							        	//如果有這項股票且數量夠

							        	if ($temporary_order_price <= $data_closePrice)  
				                		{
				                			$NewMoney = $data_balance + $transaction_price;
				                			$success = "INSERT INTO record (id, s_id, s_name, order_price, amount, action, order_time, close_price, process_time) values ('$temporary_id','$temporary_s_id','$temporary_s_name','$temporary_order_price','$temporary_amount','$temporary_action','$temporary_order_time','$data_closePrice','$today_time')";
				                			mysqli_query($db,$success);	//新增至成功的紀錄中

				                			$balance_add = "UPDATE user SET user_account = '".$NewMoney."' WHERE id = '".$row["id"]."'";
			        						mysqli_query($db, $balance_add);	//放款

			        						$OriginAmount = mysqli_query($db,"SELECT s_number from stock_hold WHERE s_id='".$row["s_id"] ."' AND user_id='".$row["id"]."'");	//抓出原有的張數  (決定要delete 或 update至stock_hold)
			        						for($i=1;$i<=mysqli_num_rows($OriginAmount);$i++)
											{
												$rs=mysqli_fetch_row($OriginAmount);
												$data_OriginAmount = $rs[0];  
												echo "原有股數:";
												echo $data_OriginAmount;	//原有的張數
												echo '<br>'; 
											}										
			        						if($data_OriginAmount - $data_amountNumber > 0)   //判斷賣掉後還有沒有剩  (如果有剩就做UPDATE)
			            					{
			            						$data_FinalAmount = $data_OriginAmount - $data_amountNumber;	//現有的股數 - 賣掉的股數
			            						echo "剩餘股數:";
			            						echo '<br>';
			            						echo $data_FinalAmount;
			            						echo '<br>';
			            						$outcome_0="UPDATE stock_hold SET s_number='".$data_FinalAmount."' WHERE s_id='".$row["s_id"] ."' AND user_id= '".$row["id"] ."'";
			            						mysqli_query($db,$outcome_0);
			            					}
			            					else if($data_OriginAmount - $data_amountNumber == 0) 	//賣完後沒剩 刪除
			            					{
			            						$outcome_1 = "DELETE FROM stock_hold WHERE s_id='".$row["s_id"] ."' AND user_id= '".$row["id"] ."'";
			            						mysqli_query($db,$outcome_1);
			            						echo "delete";
			            					}

				                		}
				                		else if ($temporary_order_price > $data_closePrice)   
				                		{
				                			echo "fail";
				                			$FailRecord = "INSERT INTO fail (id, s_id, s_name, order_price, amount, action, order_time, close_price, process_time, reason) values ('$temporary_id','$temporary_s_id','$temporary_s_name','$temporary_order_price','$temporary_amount','$temporary_action','$temporary_order_time','$data_closePrice','$today_time','賣價太高')";
				                			mysqli_query($db,$FailRecord);	//新增至失敗的紀錄中
				                		}
				                		$delete = "DELETE FROM unsuccessful WHERE id='".$row["id"]."' AND order_time='".$data_orderTime."'";
			                			mysqli_query($db,$delete);
							        }
							        else
							        {
							        	$FailRecord = "INSERT INTO fail (id, s_id, s_name, order_price, amount, action, order_time, close_price, process_time, reason) values ('$temporary_id','$temporary_s_id','$temporary_s_name','$temporary_order_price','$temporary_amount','$temporary_action','$temporary_order_time','$data_closePrice','$today_time','股票數量不足')";
			                			mysqli_query($db,$FailRecord);	//新增至失敗的紀錄中
			                			$delete = "DELETE FROM unsuccessful WHERE id='".$row["id"]."' AND order_time='".$data_orderTime."'";
			                			mysqli_query($db,$delete);

							        }
			                		$delete = "DELETE FROM unsuccessful WHERE id='".$row["id"]."' AND order_time='".$data_orderTime."'";
			                		mysqli_query($db,$delete);
						        }
						        else
						        {
							        $FailRecord = "INSERT INTO fail (id, s_id, s_name, order_price, amount, action, order_time, close_price, process_time, reason) values ('$temporary_id','$temporary_s_id','$temporary_s_name','$temporary_order_price','$temporary_amount','$temporary_action','$temporary_order_time','$data_closePrice','$today_time','股票數量不足')";
			                		mysqli_query($db,$FailRecord);	//新增至失敗的紀錄中
			                		$delete = "DELETE FROM unsuccessful WHERE id='".$row["id"]."' AND order_time='".$data_orderTime."'";
			                		mysqli_query($db,$delete);
			                	}
	                		}
	                		$delete = "DELETE FROM unsuccessful WHERE id='".$row["id"]."' AND order_time='".$data_orderTime."'";
			                mysqli_query($db,$delete);
	                		
	                	}
	                }//判斷此股票的收盤價是否為0的if括號
	                else
                    {
                    	//判斷當天是不是都抓到0的else
                       echo "收盤價有錯誤";
                       $FailRecord = "INSERT INTO fail (id, s_id, s_name, order_price, amount, action, order_time, close_price, process_time, reason) values ('$temporary_id','$temporary_s_id','$temporary_s_name','$temporary_order_price','$temporary_amount','$temporary_action','$temporary_order_time','0','$today_time','收盤價有錯誤')";
		                mysqli_query($db,$FailRecord);
		               $delete = "DELETE FROM unsuccessful WHERE id='".$row["id"]."' AND order_time='".$data_orderTime."'";
	                   mysqli_query($db,$delete);
                    }   

				}//比較時間(下午1點的)的if括號
				else
                {   
                    echo "隔天做";
                }
				$count++;
	        	//echo "<br> id: ". $row["id"]. " - Name: ". $row["s_id"]. " " . $row["s_name"] . "<br>";
	    	}//while的括號
		} 
		else 
		{
			//不做任何事
		    echo "0 results";
		}	
	}
	
	




























?>

