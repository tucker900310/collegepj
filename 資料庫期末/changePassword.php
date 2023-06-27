
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
                <div class="sidebar-brand-text mx-3">SB 記帳本  </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
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



            <!-- Divider -->
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Addons
            </div>

            <li class="nav-item">
                <a class="nav-link" href="Bookkeeping.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>記帳</span></a>
            </li>

            <!-- Nav Item - Charts -->
  

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
                    <h1 class="h4 text-gray-900 mb-4">修改密碼!</h1>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                    <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> 

                    <div class="col-lg-6">
                    <div class="p-5">
                    <form class="user" action="alter_password.php?mid=<?php echo$mid?>&accnum=<?php echo$accnum?>&password=<?php echo$password?>&mname=<?php echo$mname?>" method="post" onsubmit="return alter()">
                        <div class="form-group">
                        <input type="text" class="form-control form-control-user"
                        id="accnum2" name="accnum2" aria-describedby="emailHelp"
                        placeholder="輸入帳號">
                        </div> 

                        <div class="form-group">
                        <input type="password" class="form-control form-control-user"
                        id="oldpassword" name="oldpassword" aria-describedby="emailHelp"
                        placeholder="輸入舊密碼">
                        </div> 

                        <div class="form-group">
                        <input type="password" class="form-control form-control-user"
                        id="newpassword" name="newpassword" aria-describedby="emailHelp"
                        placeholder="輸入新密碼">
                        </div> 

                        <div class="form-group">
                        <input type="password" class="form-control form-control-user"
                        id="newpassword2" aria-describedby="emailHelp"
                        placeholder="輸入新密碼">
                        </div> 

                        <input  class="btn btn-primary btn-user btn-block"type="submit" name="submit" value="修改密碼" onclick="return alter()">

                    </form>
                    </div></div></div> 
                    </div></div> </div></div> 
 
                        <script type="text/javascript"> 
                        document.getElementById("accnum").value="<?php echo $accnum;?>" 
                        </script> 
                        <script type="text/javascript"> 
                        function alter() { 
                        var accnumber=document.getElementById("accnum").value; 
                        var oldpassword=document.getElementById("oldpassword").value; 
                        var newpassword=document.getElementById("newpassword").value; 
                        var assertpassword=document.getElementById("newpassword2").value; 
                        var regex=/^[/s] $/; 
                        if(regex.test(accnumber)||accnumber.length==0){ 
                        alert("使用者名稱格式不對"); 
                        return false; 
                        } 
                        if(regex.test(oldpassword)||oldpassword.length==0){ 
                        alert("密碼格式不對"); 
                        return false; 
                        } 
                        if(regex.test(newpassword)||newpassword.length==0) { 
                        alert("新密碼格式不對"); 
                        return false; 
                        } 
                        if (assertpassword != newpassword||assertpassword==0) { 
                        alert("兩次密碼輸入不一致"); 
                        return false; 
                        } 


                        return true; 
                        } 
                        </script>  
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