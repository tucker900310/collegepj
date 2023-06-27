
<?php 
  header("Content-Type: text/html; charset=utf-8");
  include("connect.php");
  $seldb = @mysqli_select_db($db_link, "accountbook");
  if (!$seldb) die("資料庫選擇失敗！");
  $mid = $_GET['mid'];
  $accnum = $_GET['accnum'];
  $password = $_GET['password'];
  $mname = $_GET['mname'];
  $rid = $_GET['rid'];
  $date = $_GET['date'];
  $rstatus = $_GET['rstatus'];
  $money = $_GET['money'];
  $describes = $_GET['describes'];
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

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB 記帳本 </div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="index.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="public.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>public</span></a>
            </li>
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Addons
            </div>

            <li class="nav-item ">
                <a class="nav-link" href="Bookkeeping.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>記帳</span></a>
            </li>




            <li class="nav-item ">
                <a class="nav-link" href="tables.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
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

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $mname ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
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

                <div class="container-fluid ">
                <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
  
                    <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">修改!</h1>
                    </div>
                    <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                    <div class="row">

                    <div class="col-lg-10">
                    <div class="p-5">
                    <script>
                            department=new Array();
                            department[2]=["請選擇","食物", "飲料", "交通", "娛樂", "3C", "醫藥", "居家", "繳費", "其他"];	// 收入來源
                            department[1]=["請選擇", "薪資所得", "繼承或贈與", "理財投資所得", "租金收入", "借貸", "退休金", "生活費", "獎金","其他"];	// 支出項目

                            function renew(index){
                                for(var i=0;i<department[index].length;i++)
                                    document.myForm.Newdescribe.options[i]=new Option(department[index][i], department[index][i]);	// 設定新選項
                                    document.myForm.Newdescribe.length=department[index].length;	// 刪除多餘的選項
                                }
                        </script>
                    <div class="container-fluid">
                    <div class="card shadow mb-4">
                    <div class="card-body">
                    <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">原本紀錄</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <?php
                            echo " <td>".$date."</td>";
                            echo "<td>".$rstatus."</td>";
                            echo "<td>".$money."</td>";
                            echo "<td>".$describes."</td>";
                            ?>
                              
                              </table>
                                        </div>   
                                    </div>                        
                                </div>
                            </div>
                        </div>

                    <form name="myForm" action="modifyrecord.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>&rid=<?php echo$rid?>&date=<?php echo$date?>&rstatus=<?php echo$rstatus?>&money=<?php echo$money?>&describes=<?php echo$describes?>" method="post">
                        <div class="form-group row">
                            <label for="Date" class="col-sm-2 col-form-label">日期</label>
                            <div class="col-sm-10">
                            <input type="date" class="form-control" id="NewDate" name="NewDate" >
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="InAndEx" class="col-sm-2 col-form-label">收入/支出</label>
                            <div class="col-sm-10">
                            <select  onChange="renew(this.selectedIndex)" id="NewInAndEx" name="NewInAndEx" class="form-control">
                                <option selected >請選擇</option>
                                <option value="收入">收入</option>
                                <option value="支出">支出</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="money" class="col-sm-2 col-form-label">金額</label>
                                <div class="col-sm-10">
                                <input type="number" class="form-control" id="Newmoney" name="Newmoney">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="describe" class="col-sm-2 col-form-label">項目</label>
                            <div class="col-sm-10">
                            <select id="Newdescribe" name="Newdescribe" class="form-control">
                            <option value="">
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="money" class="col-sm-2 col-form-label">說明</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="newdetail" name="newdetail" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input  class="btn btn-primary btn-user btn-block"type="submit" name="submit" value="修改">
                            </div>
                        </div>
                        </form>
                    </div></div></div> 
                    </div></div> </div>

                    </div>
                    </div>

                </div>

            </div>



        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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