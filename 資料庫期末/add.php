<?php
$link=  include("connect.php");//連結資料庫
header("Content-type:text/html;charset=utf-8");
if($link){  
    $seldb = @mysqli_select_db($db_link, "accountbook");
    if (!$seldb) die("資料庫選擇失敗！");
    $sql = "SELECT * FROM `member`";
    $result = mysqli_query($db_link, $sql);
//echo"選擇資料庫成功！";
if(isset($_POST["submit"]))
{
$accnum=$_POST["accnum"];
$password1=$_POST['password'];//獲取表單資料
$password2=$_POST["password2"];
$mname=$_POST["mname"];
if($accnum==""||$password1==""||$mname=="")//判斷是否填寫
{
echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."請填寫完成！"."\"".")".";"."</script>";
echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.html"."\""."</script>";    
exit;
}
if($password1==$password2)//確認密碼是否正確
{
    $accnum=$_POST["accnum"];
	$user_sql = "SELECT * FROM member WHERE accnum = '$accnum'";
    $user_result = mysqli_query($db_link, $user_sql);
    $user_resultCheck = mysqli_query($db_link, $user_sql);//(檢查是否有資料用)

//檢查資料表有沒有資料
if(is_null(mysqli_fetch_array($user_resultCheck))){
  $user = 0;
}else{	//有抓到資料就存成php陣列
  while ($row = mysqli_fetch_array($user_result)) { //根據筆數一筆一筆存進陣列
          $user = $row;
  }
}

    if($user[1]==$accnum){
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."該使用者名稱已被註冊"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.html"."\""."</script>";   
    }
    else{
        
        $sql_query = "INSERT INTO member (`mid`,`accnum`,`pwd`,`mname`) VALUES (null,'$accnum','$password1','$mname')";
        $result=mysqli_query($db_link, $sql_query);
        echo$accnum;
        echo$password1;
    }
    echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."註冊成功"."\"".")".";"."</script>";
    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."login.php"."\""."</script>";



//echo"資料庫關閉";
//echo"註冊成功！";
    

}
else
{
echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."密碼不一致！"."\"".")".";"."</script>";
echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.html"."\""."</script>";    
}

}
}
 ?>