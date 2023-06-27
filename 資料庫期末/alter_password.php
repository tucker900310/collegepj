
<?php 

 header("Content-Type: text/html; charset=utf8");
 $link=  include("connect.php");//連結資料庫
 if($link){  
     $seldb = @mysqli_select_db($db_link, "accountbook");
     if (!$seldb) {die("資料庫選擇失敗！");}
     if(isset($_POST["submit"])){
        $accnum2 = $_POST ["accnum2"]; 
        $oldpassword = $_POST ["oldpassword"]; 
        $newpassword = $_POST ["newpassword"];
        $mid = $_GET['mid'];
        $accnum = $_GET['accnum'];
        $password = $_GET['password'];
        $mname = $_GET['mname'];
    }                                           

    $user_sql = "SELECT * FROM member WHERE accnum = '$accnum' ";
    $user_result = mysqli_query($db_link, $user_sql);
    $row = mysqli_fetch_array($user_result);
    $user = $row;
    
    $dbusername = $user [1]; 
    $dbpassword = $user [2]; 
    
    
    if ( $dbusername != $accnum2) { 
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."使用者帳號不正確"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."changePassword.php?mid=$mid&accnum=$accnum&password=$dbpassword&mname=$mname"."\""."</script>";    
    } 
    if ($dbpassword != $oldpassword) { 
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."密碼錯誤"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."changePassword.php?mid=$mid&accnum=$accnum&password=$dbpassword&mname=$mname"."\""."</script>";    
    } 
    else{$new_pass="UPDATE member SET `pwd`='$newpassword' where `accnum`='$accnum'";
        $new_result=mysqli_query($db_link, $new_pass);
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."更改成功"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."index.php?mid=$mid&accnum=$accnum&password=$newpassword&mname=$mname"."\""."</script>";    }

    }


?> 