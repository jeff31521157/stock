<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?Php
if(!isset($_POST["login"])){
  exit("錯誤執行");
  }//檢測是否有submit操作 
  $db = mysqli_connect("localhost", "root","password", "stock");
  $id = $_POST['id'];//post獲得用戶名表單值
  $passowrd = $_POST['password'];//post獲得用戶密碼單值
  echo $id;
  if ($id && $passowrd){//如果用戶名和密碼都不為空
    $sql = "select * from user where id = '$id' and password='$passowrd'";//檢測數據庫是否有對應的username和password的sql
    $result = mysqli_query($db,$sql);//執行sql
    $rows=mysqli_num_rows($result);//返回一個數值
    if($rows){//0 false 1 true
      $_SESSION["user_id"] = $id;
      header("refresh:0;url=stock_home.php");//如果成功跳轉至stock_info.php頁面
      exit;
       }
    else{
      echo "用戶名或密碼錯誤";
      echo "
      <script>
      setTimeout(function(){window.location.href='stock_login.php';},1000);
      </script>
      ";//如果錯誤使用js 1秒後跳轉到登錄頁面重試;
    }
  }
  else
  {//如果用戶名或密碼有空
     echo "表單填寫不完整";
     echo "
     <script>
     setTimeout(function(){window.location.href='stock_login.php';},1000);
     </script>";
     //如果錯誤使用js 1秒後跳轉到登錄頁面重試;
   }//mysql_close();//關閉數據庫
?>