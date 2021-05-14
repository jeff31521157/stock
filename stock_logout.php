<?php
session_start();
session_unset();
session_destroy();
echo "登出成功！即將導回登入頁！<br/>";
echo '<meta http-equiv=REFRESH CONTENT=1;url=stock_login.php>';
exit;
?>