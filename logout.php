<?php


	if(!isset($_SESSION["sunbeam_app"])) {
		redirect("login");
	}
	
	// log out current user, if any
	logout();
	
	// redirect user
	redirect("login");

?>
