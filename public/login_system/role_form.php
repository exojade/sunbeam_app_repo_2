<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MARIPHIL</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="AdminLTE/plugins/sweetalert/sweetalert2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLTE/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="AdminLTE/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<style>
.layer {
    background-color: rgba(5, 5, 5, 0.7);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
  </style>
  
</head>

<header class="main-header" style="background-color: #244D07;">
    <nav class="navbar navbar-static-top" style="margin-left: 0px;">
      <div class="container">
        <div class="navbar-header">
          <a href="../../index2.html" class="navbar-brand">PROJECT MARIPHIL FOUNDATION INC.</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

       
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
  
 
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>

<body class="hold-transition login-page" style="
background-image: url('resources/background.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
">

<div class="layer">
<div class="login-box">
  <div class="login-logo">
    <img src="resources/mariphil.png" width="200" height="200">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <h2 class="login-box-msg text-center">SELECT ROLE</h2>

    <form method="post" action="role" autocomplete="off">
      <input type="hidden" name="action" value="go_role">
      <div class="form-group has-feedback">
        <select required class="form-control" name="role">
          <option value="" selected disabled>Please select role</option>
          <option value="admin">ADMIN</option>
          <option value="APPLICANT">APPLICANT</option>
          <option value="VALIDATOR">VALIDATOR</option>
          <option value="FACILITATOR">FACILITATOR</option>
          <option value="SPONSOR">SPONSOR</option>
        </select>
      </div>
          <button type="submit" class="btn btn-success btn-block btn-flat">Sign In</button>
    </form>
   <br>
   <br>
    <a href="register" class="text-center">Don't have an account? Sign up here.</a>

  </div>
  <!-- /.login-box-body -->
  <Br>
  <p style="color:#fff;" class="text-center">Copyright @ <?php echo(date("Y")); ?> Project Mariphil Foundation INC.</p>
</div>
</div>
<script src="AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<script src="AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="AdminLTE/plugins/iCheck/icheck.min.js"></script>
<script src="AdminLTE/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="public/login_system/login.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    });
  });
</script>
</body>
</html>
