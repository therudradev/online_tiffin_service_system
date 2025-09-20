<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['otssaid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>

    <title>Online Tiffine Service System - Search Invoice</title>
 
    <link href="assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">

    <link href="dist/css/style.min.css" rel="stylesheet">
   
</head>

<body>
  
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
         <?php include_once('includes/header.php');?>
       
        <?php include_once('includes/sidebar.php');?>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Search Invoice</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="dashboard.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Search Invoice</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    
                </div>
            </div>
           
            <div class="container-fluid">
              
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="basic-form" method="post">
                                <div class="form-group">
                                    <label>Search by Order Number./Name/Mobile No.</label>
                                    <input id="searchdata" type="text" name="searchdata" required="true" class="form-control" placeholder="Order No./Name/Mobile No."></div>
                                
                                <br>
                                <button type="submit" class="btn btn-primary" name="search" id="submit">Search</button>
                            </form>
                            <?php
if(isset($_POST['search']))
{ 

$sdata=$_POST['searchdata'];
  ?>
  <h4 align="center">Result against "<?php echo $sdata;?>" keyword </h4>
                              
                             
                                <div class="table-responsive">

                                    <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Order Number</th>
                                                <th>Name</th>
                                                <th>Mobile Number</th>
                                                <th>Order Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
$sql="SELECT * from tblorder where OrderNumber like '$sdata%' || FullName like '$sdata%' || MobileNumber like '$sdata%'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php  echo htmlentities($row->OrderNumber);?></td>
                                                <td><?php  echo htmlentities($row->FullName);?></td>
                                                <td><?php  echo htmlentities($row->MobileNumber);?></td>
                                                <td><?php  echo htmlentities($row->OrderDate);?></td>
                                         <td class="font-w600">
                                                <?php $ostatus=$row->Status; if($row->Status==""){ ?>

            
<span class="badge badge-warning">  <?php echo "Not Updated Yet"; ?></span>
<?php } elseif($ostatus=='Canceled') { ?>
<span class="badge badge-danger">  <?php  echo htmlentities($row->Status);?></span>
<?php } else{ ?>
<span class="badge badge-success"><?php  echo htmlentities($row->Status);?></span>                                
<?php } ?>    </td> 
<td><a href="invoice-generating.php?invid=<?php echo htmlentities ($row->ID);?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a></td>
</tr>
                              
                                        </tbody>
                                   <?php 
$cnt=$cnt+1;
} } else { ?>
  <tr>
    <td colspan="8"> No record found against this search</td>

  </tr>
  <?php } }?>    
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
            </div>
  
         <?php include_once('includes/footer.php');?>
        </div>
  
    </div>
   
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <!-- themejs -->
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!--This page plugins -->
    <script src="assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/pages/datatable/datatable-basic.init.js"></script>
</body>

</html>
<?php }  ?>