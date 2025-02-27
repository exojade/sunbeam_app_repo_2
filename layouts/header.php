<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SunBeam App</title>

  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <link rel="stylesheet" href="AdminLTE_new/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="icon" href="resources/logoNoWhite.png">
  <link rel="stylesheet" href="resources/animate.css" />
  <link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">
</head>
<style>
  .content-wrapper{
    background-color: #fff !important;
  } 
  .navbar-light{
    border-bottom: none !important;
    background-color: #fff !important;
  }
  .color-red{
    color:red;
  }
</style>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-primary" >
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link " data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color:white;"></i></a>
      </li>
    </ul>

    <h5 style="
    padding: .5rem 1rem !important; margin: 0 !important;">Welcome <?php echo($_SESSION["sunbeam_app"]["fullname"]); ?></h5>
    <!-- <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
   
    </ul> -->

    <?php 
    $school_year = query("select * from school_year where active_status = 'ACTIVE'");
    $sy = $school_year[0];
    ?>




    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
      <h5 style="
    padding: .5rem 1rem !important; margin: 0 !important;"><b>Active School Year:</b> <?php echo($sy["school_year"]); ?></h5>
      </li>

      <?php if($_SESSION["sunbeam_app"]["role"] == "admin" || $_SESSION["sunbeam_app"]["role"] == "parent" || $_SESSION["sunbeam_app"]["role"] == "cashier"): ?>

        <li class="nav-item dropdown">
        <a class="nav-link deym" data-toggle="dropdown" href="#">
          <i class="fas fa-bell text-warning"></i>

          <?php $notifications = query("select count(*) as count from notification where receiver_id = ? and read_at is null", $_SESSION["sunbeam_app"]["userid"]); ?>
          <?php if($notifications[0]["count"] != 0): ?>
            <span class="badge badge-danger navbar-badge"><?php echo($notifications[0]["count"]); ?></span>
          <?php endif; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="max-height: 500px; overflow-y: auto; width:500px !important; max-width: 500px !important;">
          
        <?php if($notifications[0]["count"] != 0): ?>
          <?php $myNotif = query("select * from notification where receiver_id = ? and read_at is null", $_SESSION["sunbeam_app"]["userid"]); ?>
       

          <?php foreach($myNotif as $row): 
            $message = unserialize($row["message"]);
            $timeAgo = timeAgo($row["created"]);
            ?>
            <a href="notifications?action=read&id=<?php echo($row["notification_id"]); ?>" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body">
                <p class="text-sm"><?php echo($message["message"]); ?></p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?php echo($timeAgo); ?></p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <?php endforeach; ?>

        <?php else: ?>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
          
          <div class="media">
            <div class="media-body text-center">
              No unread notification!
            </div>
          </div>
          </a>
          <div class="dropdown-divider"></div>

        <?php endif; ?>
          <a href="notifications" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <?php endif; ?>



   

   
    </ul>


  </nav>
<script src="AdminLTE_new/plugins/jquery/jquery.min.js"></script>
<script src="AdminLTE_new/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="AdminLTE_new/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="AdminLTE_new/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="AdminLTE_new/dist/js/adminlte.min.js"></script>
<script src="AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- <script src="AdminLTE/bower_components/jquery-ui/jquery-ui.min.js"></script> -->
<!-- AdminLTE for demo purposes -->


<?php
  $payment_settings = query("select * from payment_settings");
  $currentInstallmentNumber = 11;
  if(!empty($payment_settings)):
    $currentInstallmentNumber = $payment_settings[0]["installment_number"];
  endif;
?>