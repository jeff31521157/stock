<?php
session_start();
$db = mysqli_connect("localhost", "root","", "stock");
mysqli_set_charset($db,"utf8");
$user_id = $_SESSION["user_id"];

	
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
			<form name=form1 method="post" action="stock_transaction_process.php">
				<font color='white' size='5'>
				
				股票代碼：<input type="text" name="stock_id" size="20"/> &nbsp (例如:0050)
				<br/><br/>
				下單價格：<input type="text" name="stock_price" size="20"/> &nbsp (例如:78)
				<br/><br/>
				張數(1000股/張)：<input type="text" name="stock_amount" size="20"/> &nbsp (例如:2)
				<br/><br/>
    			<input type="radio" name="BuyOrSell" value="buy"> 買
				<input type="radio" name="BuyOrSell" value="sell"> 賣
				&nbsp&nbsp&nbsp&nbsp (例如:買或賣需要勾選其中一項) <br/><br/> 
				<input type="button"value="確定" onclick="javascript:{this.disabled=true;document.form1.submit();}" style="width:75px;height:35px;border:5px orange double;font-size:20px;"> 
			</form>
	
			<br/><br/>
			<h5><span>可用餘額:</span></h5>
			<?php
			//$user_id = $_SESSION["user_id"];
			$data=mysqli_query($db,"SELECT user_account FROM user WHERE id = '".$user_id."'");
			for($i=1;$i<=mysqli_num_rows($data);$i++)
			{
				$rs=mysqli_fetch_row($data);
				 echo $rs[0];
			}
			date_default_timezone_set("Asia/Taipei");
			$today_time = date("Y-m-d H:i:s");
			//echo $today_time; //print出現在時間
			$get_stock_id= $_POST['stock_id'];
			$get_stock_price = $_POST['stock_price'];
			$get_stock_amount = $_POST['stock_amount'];
			if(empty($_POST['BuyOrSell']))
			{
				$BuyOrSell = "";
			}
			else
			{
				$BuyOrSell = $_POST['BuyOrSell'];
			}
    		if(empty($user_id) || empty($get_stock_id) || empty($get_stock_price) || empty($get_stock_amount) || empty($BuyOrSell) || $get_stock_price > 100001)
    		{
    			echo '<script type="text/javascript">';
				echo ' alert("每一項都要填寫 or 下單價格太大。")';  
				echo '</script>';
    		}
    		else
    		{
    			$id_check=mysqli_query($db,"SELECT s_id FROM stock WHERE s_id='".$get_stock_id ."'");
			    for($i=1;$i<=mysqli_num_rows($id_check);$i++)
			    {
			       $exist=mysqli_fetch_row($id_check);//echo $rs[0];
			    }


    			if(isset($exist[0]) && is_numeric($get_stock_price) && floor($get_stock_amount) == $get_stock_amount)	
    			//is_numeric判斷是否為數字，floor判斷整數
    			{
    				if (strpos($BuyOrSell, 'sell') !== false) 
	    			{
	    				//是sell
		    			$check=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE s_id='".$get_stock_id ."'AND user_id='".$user_id."'");
				        for($i=1;$i<=mysqli_num_rows($check);$i++)
				        {
				        	$gg=mysqli_fetch_row($check);//echo $rs[0];
				        }
				        if(isset($gg[0]))
				        {
				        	if($get_stock_amount > 0) //買的張數超過一張
		    				{
			    				$data=mysqli_query($db,"SELECT s_number FROM stock_hold WHERE s_id='".$get_stock_id ."'AND user_id='".$user_id."'");
					        	for($i=1;$i<=mysqli_num_rows($data);$i++)
					        	{
					        		$rs=mysqli_fetch_row($data);//echo $rs[0];
					        	}

					        	$s_number_remain=$rs[0];
					        	if($s_number_remain<$get_stock_amount)
					        	{
					        		echo '<script type="text/javascript">';
									echo ' alert("無法賣出，張數不足。")';  
									echo '</script>';
					        		//echo "無法賣出，張數不足。";
					        	}
					        	else
					        	{
					        		$stock_name=mysqli_query($db,"SELECT s_name FROM stock WHERE s_id = '".$get_stock_id."'"); //拿股票名稱出來
							    	for($i=1;$i<=mysqli_num_rows($stock_name);$i++)
									{
										$rs=mysqli_fetch_row($stock_name);
										$stockName = $rs[0];   
									}
									$sql = "INSERT INTO unsuccessful (id, s_id, s_name, order_price, amount, action, order_time) values ('$user_id','$get_stock_id','$stockName','$get_stock_price','$get_stock_amount','$BuyOrSell','$today_time')";
									mysqli_query($db,$sql);
									echo '<script type="text/javascript">';
									echo ' alert("已加入交易清單。")';  
									echo '</script>';
				        		}
		    				}
			    			else
			    			{
			    				echo '<script type="text/javascript">';
								echo ' alert("至少要賣一張。")';  
								echo '</script>';
			    				//echo "至少要賣一張";
			    			}
				        }
				        else
				        {
				        	echo '<script type="text/javascript">';
							echo ' alert("無法賣出，沒有擁有此張股票。")';  
							echo '</script>';
				        	//echo "無法賣出，沒有擁有此張股票。";
				        }
	    			
					}
					else
					{
						//是buy
						if($get_stock_amount > 0) //買的張數超過一張
		    			{
							$stock_name=mysqli_query($db,"SELECT s_name FROM stock WHERE s_id = '".$get_stock_id."'"); //拿股票名稱出來
					    	for($i=1;$i<=mysqli_num_rows($stock_name);$i++)
							{
								$rs=mysqli_fetch_row($stock_name);
								$stockName = $rs[0];   
							}
							$sql = "INSERT INTO unsuccessful (id, s_id, s_name, order_price, amount, action, order_time) values ('$user_id','$get_stock_id','$stockName','$get_stock_price','$get_stock_amount','$BuyOrSell','$today_time')";
							mysqli_query($db,$sql);
							echo '<script type="text/javascript">';
							echo ' alert("已加入交易清單。")';  
							echo '</script>';
							//echo "已加入交易清單";
						}
						else
		    			{
		    				echo '<script type="text/javascript">';
							echo ' alert("至少要買一張。")';  
							echo '</script>';
		    				//echo "至少要買一張";
		    			}
					}
    			}
    			else
    			{
    				echo '<script type="text/javascript">';
					echo ' alert("查無股票or下單價格非數字or數量非整數。")';  
					echo '</script>';
    			}
    			
    		}
    		
			
			?>

			
			
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