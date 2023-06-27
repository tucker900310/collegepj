
<?php 

header("Content-Type: text/html; charset=utf8");
$link=  include("connect.php");//連結資料庫
if($link){  
    $seldb = @mysqli_select_db($db_link, "accountbook");
    if (!$seldb) {die("資料庫選擇失敗！");}
    if(isset($_POST["submit"])){
       $mid = $_GET['mid'];
       $accnum = $_GET['accnum'];
       $password = $_GET['password'];
       $mname = $_GET['mname'];
       $rid = $_GET['rid'];
       $NewDate = $_POST['NewDate'];
       $NewInAndEx = $_POST['NewInAndEx'];
       $Newmoney = $_POST['Newmoney'];
       $Newdescribe = $_POST['Newdescribe'];
       $newdetail=$_POST['newdetail'];
   }                                           

  
   if($NewDate==""||$NewInAndEx==""||$Newmoney==""||$Newdescribe=="")//判斷是否填寫
       {
       echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."請填寫完成！"."\"".")".";"."</script>";
       echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."modify.php?mid=$mid&accnum=$accnum&password=$dbpassword&mname=$mname"."\""."</script>";    
       exit;
       }
       if($NewInAndEx=="收入"){
        $sql_query = "UPDATE record SET `date`='$NewDate',`rstatus`='$NewInAndEx',`money`='$Newmoney',`describes`='$Newdescribe' WHERE rid='$rid'";
        $result=mysqli_query($db_link,$sql_query);

        $newsql_query = "UPDATE income SET iMoney='$Newmoney',source='$Newdescribe',`iDetail`='$newdetail' WHERE rid='$rid'";
        $newresult=mysqli_query($db_link,$newsql_query);
       }
        if($NewInAndEx=="支出"){
            $Newmoney=$Newmoney*$Newmoney;
            $Newmoney=sqrt($Newmoney)*-1;
            $sql_query = "UPDATE record SET `date`='$NewDate',`rstatus`='$NewInAndEx',`money`='$Newmoney',`describes`='$Newdescribe' WHERE rid='$rid'";
            $result=mysqli_query($db_link, $sql_query);
 
            $sql_query = "UPDATE expenses SET eMoney='$Newmoney',items='$Newdescribe',`detail`='$newdetail' WHERE rid='$rid'";
            $result=mysqli_query($db_link, $sql_query);
        }
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."更改成功"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."tables.php?mid=$mid&accnum=$accnum&password=$newpassword&mname=$mname"."\""."</script>";
   }
  


?> 