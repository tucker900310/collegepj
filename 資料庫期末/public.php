<!DOCTYPE php>


<?php 
    date_default_timezone_set('Asia/Taipei');
    header("Content-Type: text/html; charset=utf-8");
    include("connect.php");
    $seldb = @mysqli_select_db($db_link, "accountbook");
    if (!$seldb) die("資料庫選擇失敗！");
    $mid = $_GET['mid'];
    $accnum = $_GET['accnum'];
    $password = $_GET['password'];
    $mname = $_GET['mname'];
    $yeardate=date("d");
    $yeartime=date("Y-m");
    $Current=date("m",strtotime("-1 month"));
//所有人花的錢(月)
    $user_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE  E.rid=R.rid AND `date` LIKE '$yeartime%'";
    $user_result = mysqli_query($db_link, $user_sql);
    $MonthTotal=0;

    if($user_result) {
        while ($row_result = mysqli_fetch_assoc($user_result)) {                                               
                $MonthTotal=$MonthTotal+$row_result["eMoney"];
        }
    }
//所有人花的錢(總)
    $totalcost = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE  E.rid=R.rid ";
    $totalcost_result = mysqli_query($db_link, $totalcost);
    $TotalExp=0;

    if($totalcost_result) {
        while ($Exresult = mysqli_fetch_assoc($totalcost_result)) {                                               
                $TotalExp=$TotalExp+$Exresult["eMoney"];
        }
    }
//所有人賺的錢(月)
    $earn = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE   I.rid=R.rid AND `date` LIKE '$yeartime%'";
    $MonthEarn = mysqli_query($db_link, $earn);
    $MonthTotalEarn=0;

    if($earn) {
        while ($MonthEarned = mysqli_fetch_assoc($MonthEarn)) {                                               
                $MonthTotalEarn=$MonthTotalEarn+$MonthEarned["iMoney"];
        }
    }
//所有人賺的錢(總)
    $totalearn = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE   I.rid=R.rid ";
    $ALLEarn = mysqli_query($db_link, $totalearn);
    $aTotalEarn=0;
    if($ALLEarn) {
        while ($ALLEarned = mysqli_fetch_assoc($ALLEarn)) {                                               
                $aTotalEarn=$aTotalEarn+$ALLEarned["iMoney"];
        }
    }
    //找最省的人
    $MostSave = "SELECT * FROM book  WHERE `EImonth` LIKE '$yeartime' ";
    $MostSave_result = mysqli_query($db_link, $MostSave);
    $mostSavePer=100;
    $mostID=0;
    $tmpbID=0;
    if($MostSave_result) {
        while ($MostSave_record = mysqli_fetch_assoc($MostSave_result)) {     
            if($MostSave_record["per"]<$mostSavePer){
                $mostSavePer=$MostSave_record["per"];
                $mostID=$MostSave_record["mid"];
                $tmpbID=$MostSave_record["bid"];
            }                                          
        }
    }
    //把最省的加進表單
    $ifhave = "SELECT `month` FROM list  WHERE `month` LIKE '$yeartime' ";
    $ifhave_result = mysqli_query($db_link, $ifhave);
    $ifhave_row = mysqli_fetch_array($ifhave_result);
    $user_ifhave=$ifhave_row;
    if($yeardate==17&&$user_ifhave[0]==null){
    $list = "INSERT INTO list (`month`,`saveMoney`,`bid`,`mid`) VALUES ('$yeartime','$mostSavePer','$tmpbID','$mostID')";
    $list_result=mysqli_query($db_link, $list);
    }
    $mostIN=0;
    $INpie = "SELECT * FROM (SELECT * FROM record )AS R,income AS I WHERE R.rid=I.rid AND `date` LIKE '$yeartime%' AND mid=$mostID";
    $INpie_result = mysqli_query($db_link, $INpie);
    if($INpie_result) {
        while ($INpie_record = mysqli_fetch_assoc($INpie_result)) {     
            $mostIN=$INpie_record["iMoney"]+$mostIN;                      
        }
    }
//算每個月和總比例
    $monthEC=0;
    $totalEC=0;
    if($MonthTotal!=0&&$MonthTotalEarn!=0){
        $monthEC=round(($MonthTotal*-1)/$MonthTotalEarn*100,2);
    }
     else{
         $monthEC=0;
     }
     if($TotalExp!=0&&$aTotalEarn!=0){
        $totalEC=round(($TotalExp*-1)/$aTotalEarn*100,2);
    }
      else{
          $totalEC=0;
      }
//印出前幾個月收支比例
    $monthEItable = "SELECT * FROM list AS I NATURAL JOIN member AS M  WHERE   I.mid=M.mid ";
    $monthSItable = mysqli_query($db_link, $monthEItable);
    $monthSItable_records = mysqli_num_rows($monthSItable);
//圓餅圖用到的資料
    $expencepie = "SELECT * FROM (SELECT * FROM record )AS R,expenses AS P WHERE R.rid=P.rid AND `date` LIKE '$yeartime%' AND mid=$mostID";
    $spendpie = mysqli_query($db_link, $expencepie);
    $spend_records = mysqli_num_rows($spendpie);
    $food = 0;
    $drink=0;
    $trans=0;
    $cloath=0;
    $entertainment=0;
    $mobile=0;
    $medicine=0;
    $home=0;
    $pay=0;
    $other=0;

    if($spendpie) {
        while ($part_result = mysqli_fetch_assoc($spendpie)) {                                               
            switch ($part_result["items"]) {
                case "食物":
                    $food=$food + $part_result["eMoney"];
                  break;
                case "飲料":
                    $drink= $drink+$part_result["eMoney"];
                  break;
                case "交通":
                    $trans= $trans+$part_result["eMoney"];
                  break; 
                case "衣服":
                    $cloath= $cloath+$part_result["eMoney"];
                case "娛樂":
                    $entertainment= $entertainment+$part_result["eMoney"];
                    break;                                                                                                          
                case "3C":
                    $mobile= $mobile+$part_result["eMoney"];
                    break;                                                   
                case "醫藥":
                    $medicine= $medicine+$part_result["eMoney"];
                    break;                                                     
                case "居家":
                    $home= $home+$part_result["eMoney"];
                    break;                                                        
                
                case "繳費":
                    $pay= $pay+$part_result["eMoney"];
                    break;                                                        
                
                case "其他":
                    $other= $other+$part_result["eMoney"];
                    break;                                                         
                }
    }
    $food = $food*-1;
    $drink=$drink*-1;
    $trans=$trans*-1;
    $cloath=$cloath*-1;
    $entertainment=$entertainment*-1;
    $mobile=$mobile*-1;
    $medicine=$medicine*-1;
    $home=$home*-1;
    $pay=$pay*-1;
    $other=$other*-1;

}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SB 記帳本 </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="index.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<li class="nav-item ">
                <a class="nav-link" href="public.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>public</span></a>
            </li>



<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Addons
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link" href="Bookkeeping.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>記帳</span></a>
</li>



<!-- Nav Item - Tables -->
<li class="nav-item ">
    <a class="nav-link" href="tables.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
        <i class="fas fa-fw fa-table"></i>
        <span>Tables</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>




                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo$mname ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="changePassword.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>" >
                                    修改密碼</a>
                            <a class="dropdown-item" href="login.php" >
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                登出
                            </a>
                            </div>
                        </li>

                    </ul>

                </nav>

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">public</h1>

                    </div>

                    <div class="row">

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                平台登記所有人<?php echo$Current?>月支出</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo$MonthTotal ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">平台登記所有人<?php echo$Current?>月收入
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo$MonthTotalEarn?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                平台登記所有人總支出占比</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo$totalEC?>%</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">平台<?php echo$Current?>月最省的收支模式</h6>
                                    <div class="dropdown no-arrow">
           
                                    </div>
                                </div>
                                
                              
                             
                                <div class="card-body center">
                                <div id="piechart" style=" height: 30rem;"></div>
 
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                        google.charts.load("current", {packages:["corechart"]});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Task', 'Hours per Day'],
                            ['食物',     <?php echo$food?> ],
                            ['飲料',  <?php echo$drink?>],
                            ['交通',  <?php echo$trans?>],
                            ['衣服',  <?php echo$cloath?>],
                            ['娛樂',  <?php echo$entertainment?>],
                            ['3C',  <?php echo$mobile?>],
                            ['醫藥',  <?php echo$medicine?>],
                            ['娛樂',  <?php echo$entertainment?>],
                            ['居家',  <?php echo$home?>],
                            ['繳費',  <?php echo$pay?>],
                            ['收入',  <?php echo$mostIN?>],
                            ['其他',  <?php echo$other?>]
                            ]);
                            var options = {
                            title: 'public  Activities',
                            pieHole: 0.3,
                            };

                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                            chart.draw(data, options);
                        }
                        </script>
                        

                        
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">收支情況</h6> 
                                             
                                </div>
                                <div class="card-body">
                                <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                平台單月支出佔收入比 </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo$monthEC?>%</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>                                        
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                平台本月最省支出佔收入比 </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo$mostSavePer?>%</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">省錢榜</h6>
                                    <div class="dropdown no-arrow">
           
                                    </div>
                                </div>
                                <div class="card-body">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>名字</th>
                                                        <th>月份</th>
                                                        <th>支出占比</th>
                                                    </tr>
                                                </thead>
                                                    <?php
                                                    if($monthSItable) {
                                                        while ($monthSItable_result = mysqli_fetch_assoc($monthSItable)) {                                               
                                                            echo " <tr><td>".$monthSItable_result["mname"]."</td>";
                                                            echo " <td>".$monthSItable_result["month"]."</td>";
                                                            echo "<td>".$monthSItable_result["saveMoney"]."</td></tr>";
                                                        }
                                                    }
                                                    ?>
                                            </table>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-xl-12 col-lg-7">

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">每月消費與收入長條圖比較</h6>
                            </div>
                            <div class="card-body center">
                            <img src="publicgraph.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>" />
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">每月消費與收入折線圖比較</h6>
                            </div>
                            <div class="card-body center">
                            <img src="plinegraph.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>" />
                            </div>
                        </div>

<!-- Color System -->
                        </div>
                       

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->



    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>



    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
</php>