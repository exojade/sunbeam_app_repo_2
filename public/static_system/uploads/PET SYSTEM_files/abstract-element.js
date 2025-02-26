<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="public/static_system/uploads\logocityvet.png">
    <title>Admin Login</title>
    <link rel="stylesheet" href="public/static_system/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->

    <!-- <link rel="stylesheet" href="AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css"> -->
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="AdminLTE/bower_components/font-awesome/css/font-awesome.min.css"> -->
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="AdminLTE/bower_components/Ionicons/css/ionicons.min.css"> -->
  <!-- SweetAlert -->
  <link rel="stylesheet" href="AdminLTE/plugins/sweetalert/sweetalert2.min.css">
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="AdminLTE/dist/css/AdminLTE.min.css"> -->
  <!-- iCheck -->
  <!-- <link rel="stylesheet" href="AdminLTE/plugins/iCheck/square/blue.css"> -->
</head>
<style>
  .google-btn {
            background-color: #DB4437;
            color: #FFFFFF;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .google-icon {
            margin-right: 10px;
        }
</style>


<body>
    <section>
        <div class="imgBox">
            <img src="public/static_system/uploads\loginbg.jpg">
        </div>

        <div class="contentBox">  
            <div class="formBox">
                <span>
                    <center>
                        <img src="public/static_system/uploads/logo.png" height="100" style="margin: 5px;">
                    </center>
                </span>
            <br>
                <h2>Login</h2>
<!-- login form section start -->
                <form id="login_form" class="generic_form_trigger" data-url="login">

                    <div class="inputBox">
                            <span>Username</span>
                            <input name="username" type="text" name="username" required>
                        </div>

                        <div class="inputBox">
                            <span>Password</span>
                            <input name="password" type="password" name="password" required>
                        </div>

                        <div class="showPass">  
                            <label>
                                <input type="checkbox">
                                Show Password
                            </label>
                        </div>

                        <div class="inputBox">
                            <input type="submit" value="Sign in" name="">
                        </div>
                 
<br>
<br>

<br>
<br>
                  
                </form>
<!-- login form section end -->
            </div>
        </div>
    </section>
    <script src="AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<!-- <script src="AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<!-- iCheck -->
<!-- <script src="AdminLTE/plugins/iCheck/icheck.min.js"></script> -->
<!-- SweetAlert -->
<script src="AdminLTE/plugins/sweetalert/sweetalert2.min.js"></script>
    
<script>
$(function () {
			$('#login_form').submit(function(e) {
			  e.preventDefault();
			  swal({title: 'Please wait...', imageUrl: './public/images/loader/green-loader.gif', showConfirmButton: false});
			  $.ajax({
				type: 'post',
				url: 'login',
				data: $('#login_form').serialize(),
				success: function (results) {

					if(results == 'register_first')
						window.location.replace("register");
					else if(results == 'wrong_password'){
						swal({
							title: 'Information',
							text: 'Wrong Credentials',
							type: "error"
						}).then(function() {
							swal.close();
						});
					}
					else if(results == 'non_existing'){
						swal({
							title: 'Information',
							text: 'No ETRACS Account. Coordinate to IT Staff',
							type: "error"
						}).then(function() {
							swal.close();
						});
					}
					else if(results == 'proceed'){
						window.location.replace("index");
					}


					
				}
			  });
			});
  });

  </script>
</body>
</html>