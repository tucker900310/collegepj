
<?php 
date_default_timezone_set('Asia/Taipei');
header("Content-Type: text/html; charset=utf8");
$link=  include("connect.php");//連結資料庫
if($link){  
    $seldb = @mysqli_select_db($db_link, "accountbook");
    if (!$seldb) {die("資料庫選擇失敗！");}
    if(isset($_POST["submit"])){
        
        $rTime = date("H:i:s");
       $Date = $_POST ["Date"]; 
       $InAndEx = $_POST ["InAndEx"]; 
       $money = $_POST ["money"];
       $describe=$_POST ["describe"];
       $mid = $_GET['mid'];
       $accnum = $_GET['accnum'];
       $password = $_GET['password'];
       $mname = $_GET['mname'];
       $detail=$_POST ["detail"];
       if($Date==""||$InAndEx==""||$money==""||$describe=="")//判斷是否填寫
       {
       echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."請填寫完成！"."\"".")".";"."</script>";
       echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."Bookkeeping.php?mid=$mid&accnum=$accnum&password=$dbpassword&mname=$mname"."\""."</script>";    
       exit;
       }
 

       if($InAndEx=="收入"){
        $sql_query = "INSERT INTO record (`rid`,`date`,`rTime`,`rstatus`,`money`,`describes`,`mid`) VALUES (null,'$Date','$rTime','$InAndEx','$money','$describe','$mid')";
        $result=mysqli_query($db_link, $sql_query);
        $user_sql = "SELECT rid FROM record WHERE rTime = '$rTime' ";
        $user_result = mysqli_query($db_link, $user_sql);
        $row = mysqli_fetch_array($user_result);
        $user = $row;
        $sql_query = "INSERT INTO income (`rid`,`source`,`iMoney`,`iDetail`) VALUES ('$row[0]','$describe','$money','$detail')";
        $result=mysqli_query($db_link, $sql_query);
       }
        if($InAndEx=="支出"){
            $money=$money*$money;
            $money=sqrt($money)*-1;
            $sql_query = "INSERT INTO record (`rid`,`date`,`rTime`,`rstatus`,`money`,`describes`,`mid`) VALUES (null,'$Date','$rTime','$InAndEx','$money','$describe','$mid')";
            $result=mysqli_query($db_link, $sql_query);
            $user_sql = "SELECT rid FROM record WHERE rTime = '$rTime' ";
            $user_result = mysqli_query($db_link, $user_sql);
            $row = mysqli_fetch_array($user_result);
            $user = $row;
            $sql_query = "INSERT INTO expenses (`rid`,`items`,`eMoney`,`detail`) VALUES ('$row[0]','$describe','$money','$detail')";
            $result=mysqli_query($db_link, $sql_query);
        }
 
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."新增成功"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."Bookkeeping.php?mid=$mid&accnum=$accnum&password=$dbpassword&mname=$mname"."\""."</script>";  

}}
?> 