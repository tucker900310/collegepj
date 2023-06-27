
<?php 
  header("Content-Type: text/html; charset=utf-8");
  include("connect.php");
  $seldb = @mysqli_select_db($db_link, "accountbook");
  if (!$seldb) die("資料庫選擇失敗！");
  $mid = $_GET['mid'];
  $accnum = $_GET['accnum'];
  $password = $_GET['password'];
  $mname = $_GET['mname'];
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

        <!-- Sidebar -->
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
            <li class="nav-item ">
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

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

            


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
             
                            </div>
                        </li>



                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $mname ?></span>
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
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid ">
                <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
  
                    <!-- Page Heading -->
                    <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">開使記帳!</h1>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                    <div class="row">

                    <div class="col-lg-10">
                    <div class="p-5">
                    <script>
                            department=new Array();
                            department[2]=["請選擇","食物", "飲料", "交通","衣服", "娛樂", "3C", "醫藥", "居家", "繳費", "其他"];	// 收入來源
                            department[1]=["請選擇", "薪資所得", "繼承或贈與", "理財投資所得", "租金收入", "借貸", "退休金", "生活費", "獎金","其他"];	// 支出項目

                            function renew(index){
                                for(var i=0;i<department[index].length;i++)
                                    document.myForm.describe.options[i]=new Option(department[index][i], department[index][i]);	// 設定新選項
                                    document.myForm.describe.length=department[index].length;	// 刪除多餘的選項
                                }
                        </script>
                    <form name="myForm" action="keep.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>" method="post">
                        <div class="form-group row">
                            <label for="Date" class="col-sm-2 col-form-label">日期</label>
                            <div class="col-sm-10">
                            <input type="date" class="form-control" id="Date" name="Date" >
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="InAndEx" class="col-sm-2 col-form-label">收入/支出</label>
                            <div class="col-sm-10">
                            <select  onChange="renew(this.selectedIndex)" id="InAndEx" name="InAndEx" class="form-control">
                                <option selected >請選擇</option>
                                <option value="收入">收入</option>
                                <option value="支出">支出</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="money" class="col-sm-2 col-form-label">金額</label>
                                <div class="col-sm-10">
                                <input type="number" class="form-control" id="money" name="money" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="describe" class="col-sm-2 col-form-label">項目</label>
                            <div class="col-sm-10">
                            <select id="describe" name="describe" class="form-control">
                            <option value="">
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="money" class="col-sm-2 col-form-label">說明</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="detail" name="detail" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input  class="btn btn-primary btn-user btn-block"type="submit" name="submit" value="新增" onclick="return alter()">
                            </div>
                        </div>
                        </form>
                    </div></div></div> 
                    </div></div> </div>
 



                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
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