<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      redirect("login?role=".$_POST["role"]);
    }
    else
    {
	
        renderview("public/login_system/role_form.php", ["title" => "Log In"]);
    }
?>