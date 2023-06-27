<?PHP
header("Content-Type: text/html; charset=utf8");
$link=  include("connect.php");//連結資料庫
if($link){  
    $seldb = @mysqli_select_db($db_link, "accountbook");
    if (!$seldb) {die("資料庫選擇失敗！");}
    if(isset($_POST["submit"])){

    $accnum = $_POST['accnum'];//post獲得使用者名稱錶單值
    $password = $_POST['password'];

    if ($accnum=="" || $password==""){//如果使用者名稱和密碼都不為空
      echo "表單填寫不完整";
      echo "
      <script>
      setTimeout(function(){window.location.href='login.php';},1000);
      </script>";
    }
    else{//如果使用者名稱或密碼有空
      $user_sql = "SELECT * FROM member WHERE accnum = '$accnum' and pwd='$password'";
      $user_result = mysqli_query($db_link, $user_sql);
      $row = mysqli_fetch_array($user_result);
      $user = $row;
      $mname=$user[3];
      $mid=$user[0];

        if($user[1]==$accnum && $user[2]==$password){//0 false 1 true
          
        $sql_findID = "SELECT * FROM member WHERE accnum = '$accnum'";
        $data = mysqli_query($db_link, $sql_findID);
        $theuser = mysqli_fetch_assoc($data);

        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."登入成功"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."index.php?mid=$mid&accnum=$accnum&password=$password&mname=$mname"."\""."</script>";  
          exit;
        }
        else{
          echo "使用者名稱或密碼錯誤";
          echo "
            <script>
            setTimeout(function(){window.location.href='login.php';},1000);
            </script>
            ";//如果錯誤使用js 1秒後跳轉到登入頁面重試;
        }
//如果錯誤使用js 1秒後跳轉到登入頁面重試;
}
}}//關閉資料庫
?>